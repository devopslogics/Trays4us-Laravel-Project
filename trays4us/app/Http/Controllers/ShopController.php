<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Countries;
use App\Models\Customer;
use App\Models\Helper;
use App\Models\HomepageSlider;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\SearchTags;
use App\Models\ProductCustomizable;
use App\Models\ProductImages;
use App\Models\ProductPrices;
use App\Models\Wishlist;
use App\Models\Products;
use App\Models\Cart;
use App\Models\ProductStyle;
use App\Models\ProductType;
use App\Models\SiteManagements;
use App\Models\States;
use App\Models\User;
use App\Traits\Definations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Constraints\SeeInOrder;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Psr\Log\NullLogger;

class ShopController extends Controller
{
    use Definations;

    function shop_in_wholesale(Request $request)
    {

        $data = $request->all();

        if(isset($data['search_by']) && isset($data['g-recaptcha-response'])) {

            $recaptchaToken = $request->input('g-recaptcha-response');

            // Send a request to Google to verify the token
            $response = \Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => '6Lc79WsqAAAAAMiZRJt_LvNNa_F3xh_aUkvE8DkD',
                'response' => $recaptchaToken,
                'remoteip' => $request->ip(),
            ]);

            $responseData = $response->json();

            if (isset($responseData['score']) && $responseData['success'] != 1 && (isset($responseData['score']) && $responseData['score'] < 0.5)) {
                \Log::error('reCAPTCHA verification failed: Token not provided.');
                return back()->withErrors(['captcha' => 'Captcha verification failed.']);
            }
        }

        $is_customer = Session::get('is_customer');
        $siteManagement  = SiteManagements::getSiteManagment();
        $pagination = (isset($siteManagement->pagination) AND $siteManagement->pagination > 0) ? $siteManagement->pagination : 30;

        //------------------------------ Get feature arist ------------------------------------------------

        $artists = Artist::whereHas('products', function ($query) {
            $query->where('is_feature', 1);
        })->has('products')->orderBy('artist.sort_order', 'asc')->get();

        //-------------------------- check product by search name or tag exist or not then reset ------------
        $query = Products::join('product_prices', 'products.id', '=', 'product_prices.product_id')
        ->join('artist', 'products.artist_id', '=', 'artist.id')
        ->leftJoin('badges', 'badges.id', '=', 'products.p_badge')
        ->join('product_type', 'product_prices.pt_parent_id', '=', 'product_type.id')
        ->select(
            'products.product_name',
            'products.type',
            'products.id as pid',
            'products.product_slug',
            'products.product_customizable',
            'products.feature_image',
            'products.product_sku',
            'badges.badge',
            'badges.color',
            'artist.first_name',
            'artist.last_name',
            'artist.display_name',
            'product_prices.price',
            'product_prices.pt_parent_id',
            'product_prices.pt_sub_id',
            'product_type.type_name'
        )
        ->where('products.status', 1)
        ->where('artist.status', 1);
    
        if (Session::has('is_customer')) {
            $is_customer = Session::get('is_customer');
            $query->where(function ($customerQuery) use ($is_customer) {
                $customerQuery->where('products.customer_id', 0)
                    ->orWhere('products.customer_id', $is_customer->id);
            });
        } else {
            $query->where('products.customer_id', 0);
        }
        
        $searchCriteria = [
            'display_name' => null,
            'product_type' => null,
        ];
        
        if (!empty(trim($data['search_by'] ?? ''))) {
            $wordsArray = preg_split('/\s+/', $data['search_by'], -1, PREG_SPLIT_NO_EMPTY);
        
            if (count($wordsArray) === 1) {
                $productTypeMatch = ProductType::where('type_name', 'LIKE', '%' . ucfirst($wordsArray[0]) . '%')->first();
                $searchCriteria['product_type'] = $productTypeMatch ? ucfirst($wordsArray[0]) : null;
                $searchCriteria['display_name'] = !$productTypeMatch ? ucfirst($wordsArray[0]) : null;
            } elseif (count($wordsArray) >= 2) {
                $searchCriteria['display_name'] = ucfirst($wordsArray[0]);
                $searchCriteria['product_type'] = ucfirst($wordsArray[count($wordsArray) - 1]);
        
                $productTypeMatch = ProductType::where('type_name', 'LIKE', '%' . $searchCriteria['product_type'] . '%')->first();
                $searchCriteria['product_type'] = $productTypeMatch ? $searchCriteria['product_type'] : null;
            }
        
            if ($searchCriteria['product_type'] && substr($searchCriteria['product_type'], -1) === 's') {
                $searchCriteria['product_type'] = rtrim($searchCriteria['product_type'], 's');
            }
        
            $query->where(function ($subQuery) use ($data, $searchCriteria) {
                if (!empty($searchCriteria['display_name'])) {
                    $subQuery->where('artist.display_name', 'LIKE', '%' . trim($searchCriteria['display_name']) . '%');
                }
        
                if (!empty($searchCriteria['product_type'])) {
                    $subQuery->where('product_type.type_name', 'LIKE', '%' . trim($searchCriteria['product_type']) . '%');
                }
        
                if (!empty($data['search_by'])) {
                    $subQuery->orWhere('products.product_name', 'LIKE', '%' . $data['search_by'] . '%')
                        ->orWhere('products.product_sku', 'LIKE', '%' . $data['search_by'] . '%')
                        ->orWhereHas('tags', function ($tagQuery) use ($data) {
                            $tagQuery->where('tag_name', 'LIKE', '%' . $data['search_by'] . '%')
                                ->orWhereHas('synonyms', function ($synonymQuery) use ($data) {
                                    $synonymQuery->where('synonym', 'LIKE', '%' . $data['search_by'] . '%');
                                });
                        })
                        ->orWhere('artist.first_name', 'LIKE', '%' . $data['search_by'] . '%')
                        ->orWhere('artist.last_name', 'LIKE', '%' . $data['search_by'] . '%');
                }
            });
        }
            
        $productCount = $query->count();
        $productPrices = $query->get();
        


// Debug output
// dump($productCount);
//  dump($productPrices);


        
        // $products_count = Products::join('product_prices', 'products.id', '=', 'product_prices.product_id')
        //     ->join('artist', 'products.artist_id', '=', 'artist.id')
        //     ->leftJoin('badges', 'badges.id', '=', 'products.p_badge')
        //     ->select('products.product_name','products.type','products.id as pid','products.product_slug','products.product_customizable','products.feature_image','products.product_sku','badges.badge','badges.color','artist.first_name','artist.last_name','artist.display_name' ,'product_prices.price', 'product_prices.pt_parent_id','product_prices.pt_sub_id')
        //     ->where("products.status", "=", 1)
        //     ->where("artist.status", "=", 1)
        //     ->where(function ($query) {
        //         $query->where("products.customer_id", "=", 0)
        //         ->orWhere(function ($query) {
        //             if (Session::has('is_customer')) {
        //                 $is_customer = Session::get('is_customer');
        //                 $query->where('products.customer_id', $is_customer->id);
        //             }
        //         });
        //     })
        //     ->when(isset($data['search_by']) && !empty($data['search_by']), function ($query) use ($data) {
        //         return $query->where(function ($subquery) use ($data) {
        //             $subquery->where('products.product_name', 'LIKE', '%' . $data['search_by'] . '%')
        //                 ->orWhere('product_sku', 'LIKE', '%' . $data['search_by'] . '%')
        //                 ->orWhereHas('tags', function ($tagQuery) use ($data) {
        //                     $tagQuery->where('tag_name', 'LIKE', '%' . $data['search_by'] . '%')
        //                         ->orWhereHas('synonyms', function ($synonymQuery) use ($data) {
        //                             $synonymQuery->where('synonym', 'LIKE', '%' . $data['search_by'] . '%');
        //                         });
        //                 })
        //                 ->orWhereHas('artist', function ($artistSubquery) use ($data) {
        //                     $artistSubquery->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', '%' . $data['search_by'] . '%')
        //                         ->orWhere('display_name', 'LIKE', '%' . $data['search_by'] . '%');
        //                 });

        //                 /*
        //                 ->orWhereHas('artist', function ($artistSubquery) use ($data) {
        //                     $artistSubquery->where('first_name', 'LIKE', '%' . $data['search_by'] . '%')
        //                         ->orWhere('last_name', 'LIKE', '%' . $data['search_by'] . '%');
        //                 }); */
        //         });
        //     })
        //     ->count();

        $search_flag = false;
        $queryParams = \Request::query();

        if(isset($queryParams['search_by']) && isset($queryParams['g-recaptcha-response']) && count($queryParams) == 2 &&  $productCount == 0) {

            // Save search the product name or tag which is user searching from text field ---------------
            $search_tags = new SearchTags();
            $search_tags->search_tags = $data['search_by'];

            $ipAddress = $request->ip();
            list($browser, $os) = $this->parseUserAgent($request->header('User-Agent'));

            if (Session::has('is_customer')) {
                $is_customer = Session::get('is_customer');
                $search_tags->email = $is_customer->email;
            }
            $search_tags->ip_address = $ipAddress;
            $search_tags->browser = $browser;
            $search_tags->os = $os;
            $search_tags->save();

            //---------------------------------------------------------------------------------------------

            $search_flag = true;
            $data['search_by'] = '';
        }

        //-------------------------- get all products ------------------------------------------------------

        $query = Products::join('product_prices', 'products.id', '=', 'product_prices.product_id')
            ->join('artist', 'products.artist_id', '=', 'artist.id')
            ->leftJoin('badges', 'badges.id', '=', 'products.p_badge')  // Include badges table
            ->join('product_type', 'product_prices.pt_parent_id', '=', 'product_type.id')  // Join product_type table
            ->select(
                'products.product_name',
                'products.type',
                'products.id as pid',
                'products.product_slug',
                'products.product_customizable',
                'products.feature_image',
                'products.product_sku',
                'badges.badge',
                'badges.color',
                'artist.first_name',
                'artist.last_name',
                'artist.display_name',
                'artist.artist_slug',
                'product_prices.price',
                'product_prices.pt_parent_id',
                'product_prices.pt_sub_id',
                'product_type.type_name'
            )
            ->where('products.status', '=', 1)
            ->where('artist.status', '=', 1)
            ->where(function ($query) {
                $query->where('products.customer_id', '=', 0)
                    ->orWhere(function ($query) {
                        if (Session::has('is_customer')) {
                            $is_customer = Session::get('is_customer');
                            $query->where('products.customer_id', $is_customer->id);
                        }
                    });
            });

        // Add joins for wishlist and cart if the user is logged in
        if (Session::has('is_customer')) {
            $is_customer = Session::get('is_customer');

            // Join wishlist
            $query->leftJoin('wishlist as wl', function ($join) use ($is_customer) {
                $join->on('wl.product_id', '=', 'products.id')
                    ->where('wl.customer_id', $is_customer->id);
            })->addSelect('wl.id as wid');

            // Join cart
            $query->leftJoin('cart', function ($join) use ($is_customer) {
                $join->on('cart.product_id', '=', 'products.id')
                    ->where('cart.customer_id', $is_customer->id);
            })->addSelect('cart.id as cid', 'cart.quantity as cart_quantity');
        }

        // Apply filters based on input data
        if (!empty($data['artists'])) {
            $query->whereIn('artist_id', $data['artists']);
        }
        if (!empty($data['product_style'])) {
            $query->whereIn('style_id', $data['product_style']);
        }
        if (!empty($data['customizable'])) {
            $query->whereIn('product_customizable', $data['customizable']);
        }
        if (!empty($data['country'])) {
            $query->where('products.country_id', $data['country']);
        }
        if (!empty($data['state_id'])) {
            $query->where('products.state_id', $data['state_id']);
        }
        if (!empty($data['child_type'])) {
            $query->whereIn('product_prices.pt_sub_id', $data['child_type']);
        }
           
        $searchCriteria = [
            'display_name' => null,
            'product_type' => null,
        ];
        
        if (!empty(trim($data['search_by'] ?? ''))) {
            $wordsArray = preg_split('/\s+/', $data['search_by'], -1, PREG_SPLIT_NO_EMPTY);
        
            if (count($wordsArray) === 1) {
                $productTypeMatch = ProductType::where('type_name', 'LIKE', '%' . ucfirst($wordsArray[0]) . '%')->first();
                $searchCriteria['product_type'] = $productTypeMatch ? ucfirst($wordsArray[0]) : null;
                $searchCriteria['display_name'] = !$productTypeMatch ? ucfirst($wordsArray[0]) : null;
            } elseif (count($wordsArray) >= 2) {
                $searchCriteria['display_name'] = ucfirst($wordsArray[0]);
                $searchCriteria['product_type'] = ucfirst($wordsArray[count($wordsArray) - 1]);
        
                $productTypeMatch = ProductType::where('type_name', 'LIKE', '%' . $searchCriteria['product_type'] . '%')->first();
                $searchCriteria['product_type'] = $productTypeMatch ? $searchCriteria['product_type'] : null;
            }
        
            if ($searchCriteria['product_type'] && substr($searchCriteria['product_type'], -1) === 's') {
                $searchCriteria['product_type'] = rtrim($searchCriteria['product_type'], 's');
            }
        
            $query->where(function ($subQuery) use ($data, $searchCriteria) {
                if (!empty($searchCriteria['display_name'])) {
                    $subQuery->where('artist.display_name', 'LIKE', '%' . trim($searchCriteria['display_name']) . '%');
                }
        
                if (!empty($searchCriteria['product_type'])) {
                    $subQuery->where('product_type.type_name', 'LIKE', '%' . trim($searchCriteria['product_type']) . '%');
                }
        
                if (!empty($data['search_by'])) {
                    $subQuery->orWhere('products.product_name', 'LIKE', '%' . $data['search_by'] . '%')
                        ->orWhere('products.product_sku', 'LIKE', '%' . $data['search_by'] . '%')
                        ->orWhereHas('tags', function ($tagQuery) use ($data) {
                            $tagQuery->where('tag_name', 'LIKE', '%' . $data['search_by'] . '%')
                                ->orWhereHas('synonyms', function ($synonymQuery) use ($data) {
                                    $synonymQuery->where('synonym', 'LIKE', '%' . $data['search_by'] . '%');
                                });
                        })
                        ->orWhere('artist.first_name', 'LIKE', '%' . $data['search_by'] . '%')
                        ->orWhere('artist.last_name', 'LIKE', '%' . $data['search_by'] . '%');
                }
            });
        }
            
        $productCount = $query->count();
        $productPrices = $query->get();
        
        $orderCases = [];
        $state_str = '';
        $purchasedOrderStr = '';
        $orderByRaw = " ";
        if (isset($siteManagement->display_order_value) && !empty($siteManagement->display_order_value)) {
            foreach ($siteManagement->display_order_value as $index => $badgeValue) {
                switch ($badgeValue) {
                    case '_1':
                        if (Session::has('is_customer')) {
                            $is_customer = Session::get('is_customer');
                            $query->leftJoin('order_items as oi', function ($join) {
                                $join->on('oi.product_id', '=', 'products.id');
                            })
                                ->leftJoin('orders as o', function ($join) use ($is_customer) {
                                    $join->on('oi.order_id', '=', 'o.id')
                                        ->where('o.customer_id', $is_customer->id);
                                })
                                ->addSelect(DB::raw('CASE WHEN o.customer_id IS NOT NULL THEN 1 ELSE 0 END as purchased_order'));
                            $orderByRaw .= "CASE WHEN purchased_order = 1 THEN 0 ELSE 1 END ASC,";
                        }
                        break;
                    case '_2':
                        if (Session::has('is_customer')) {
                            $is_customer = Session::get('is_customer');
                            $orderByRaw .= "CASE WHEN products.state_id = $is_customer->state_id THEN 0 ELSE 1 END ASC, ";
                        }
                        break;
                    default:
                        $orderByRaw .= "CASE WHEN products.p_badge = '$badgeValue' THEN 0 ELSE 1 END ASC, ";
                        break;
                }
            }
        }


        $orderByRaw .= "products.id DESC";

        // Apply the ORDER BY clause
        $query->orderByRaw($orderByRaw);

        $products = $query->paginate($pagination);
        $last_page = $products->lastPage();


        //--------------------------------------------------------------------------------------------------

        $product_types = ProductType::select('id','type_name','parent_id')->where("status", 1)->where("parent_id", 0)->orderBy('id', 'desc')->get();

        //--------------------------------------------------------------------------------------------------

        $product_styles = ProductStyle::select('id','style_name')->where("status", 1)->orderBy('id', 'desc')->get();

        //------------------------------------------------------------------------------------------------

        $customizables = ProductCustomizable::select('id','customizable_name')->where("status", 1)->orderBy('id', 'desc')->get();


        //------------------------------------------------------------------------------------------------
        $countries = Countries::getCountries();
        $selected_filter = $this->selected_filter($data);
        $page_title = 'Wholesale Catalog';
        $page_description = 'Browse 600+ different existing tray designs and search them with keywords like hydrangea, buoys, lobster, daffodils, blueberries, and Nantucket. Create collections by combining round large trays and coaster sets.';
        return view('frontend/shop/shop-in-wholesale', compact('products','last_page','artists','product_styles','product_types','customizables','countries','search_flag','page_title','page_description','selected_filter'));
    }

    function filter_products(Request $request)
    {
        $data = $request->all();
        $siteManagement  = SiteManagements::getSiteManagment();
        $pagination = (isset($siteManagement->pagination) AND $siteManagement->pagination > 0) ? $siteManagement->pagination : 30;

        $querystring = '';
        if(isset($data) AND count($data) > 0) {
            $querystring = http_build_query($data);
        }
         $query = Products::join('product_prices', 'products.id', '=', 'product_prices.product_id')
            //->join('product_type', 'product_prices.pt_sub_id', '=', 'product_type.id')
            ->join('artist', 'products.artist_id', '=', 'artist.id')
            ->leftJoin('badges', 'badges.id', '=', 'products.p_badge')
            ->select('products.product_name','products.type','products.product_customizable','products.id as pid','products.product_slug','products.feature_image','products.product_sku','badges.badge','badges.color','artist.first_name','artist.last_name','artist.display_name' ,'artist.artist_slug' ,'product_prices.price', 'product_prices.pt_parent_id','product_prices.pt_sub_id')
            ->where("products.status", "=", 1)
            ->where("artist.status", "=", 1)
            ->where(function ($query) {
                $query->where("products.customer_id", "=", 0)
                    ->orWhere(function ($query) {
                        if (Session::has('is_customer')) {
                            $is_customer = Session::get('is_customer');
                            $query->where('products.customer_id', $is_customer->id);
                        }
                    });
            })
            ->when(Session::has('is_customer'), function ($query)  {
                $is_customer = Session::get('is_customer');
                // Left Join for Wishlist
                $query->leftJoin('wishlist as wl', function ($join) use ($is_customer) {
                    $join->on('wl.product_id', '=', 'products.id')
                        ->where('wl.customer_id', $is_customer->id);
                })
                    ->addSelect('wl.id as wid');

                // Left Join for Cart
                $query->leftJoin('cart', function ($join) use ($is_customer) {
                    $join->on('cart.product_id', '=', 'products.id')
                        ->where('cart.customer_id', $is_customer->id);
                })
                    ->addSelect('cart.id as cid','cart.quantity as cart_quantity');

                return $query;
            })
            ->when((isset($data['artists']) AND !empty($data['artists'])), function ($query) use ($data) {
                return $query->whereIn('artist_id', $data['artists']);
            })
            ->when((isset($data['product_style']) AND !empty($data['product_style'])), function ($query) use ($data) {
                return $query->whereIn('style_id', $data['product_style']);
            })
            ->when((isset($data['customizable']) AND !empty($data['customizable'])), function ($query) use ($data) {
                return $query->whereIn('product_customizable', $data['customizable']);
            })
            ->when((isset($data['country']) AND !empty($data['country'])), function ($query) use ($data) {
                return $query->where('products.country_id', $data['country']);
            })
            ->when((isset($data['state_id']) AND !empty($data['state_id']) AND !empty($data['state_id'])), function ($query) use ($data) {
                return $query->where('products.state_id', $data['state_id']);
            })
            ->when((isset($data['parent_type']) AND !empty($data['parent_type'])), function ($query) use ($data) {
              //  return $query->orwhereIn('product_prices.pt_parent_id', $data['parent_type']);
            })
            ->when((isset($data['child_type']) AND !empty($data['child_type'])), function ($query) use ($data) {
                return $query->whereIn('product_prices.pt_sub_id', $data['child_type']);
            })
            ->when(isset($data['search_by']) && !empty($data['search_by']), function ($query) use ($data) {
                return $query->where(function ($subquery) use ($data) {
                    $subquery->where('products.product_name', 'LIKE', '%' . $data['search_by'] . '%')
                        ->orWhere('product_sku', 'LIKE', '%' . $data['search_by'] . '%')
                        ->orWhereHas('tags', function ($tagQuery) use ($data) {
                            $tagQuery->where('tag_name', 'LIKE', '%' . $data['search_by'] . '%')
                                ->orWhereHas('synonyms', function ($synonymQuery) use ($data) {
                                    $synonymQuery->where('synonym', 'LIKE', '%' . $data['search_by'] . '%');
                                });
                        })
                        ->orWhereHas('artist', function ($artistSubquery) use ($data) {
                            $artistSubquery->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', '%' . $data['search_by'] . '%')
                                ->orWhere('display_name', 'LIKE', '%' . $data['search_by'] . '%');
                        });
                });
            });


         $orderCases = [];
         $state_str = '';
         $purchasedOrderStr = '';
         $orderByRaw = " ";
        if (isset($siteManagement->display_order_value) && !empty($siteManagement->display_order_value)) {
            foreach ($siteManagement->display_order_value as $index => $badgeValue) {
                switch ($badgeValue) {
                    case '_1':
                        if (Session::has('is_customer')) {
                            $is_customer = Session::get('is_customer');
                            $query->leftJoin('order_items as oi', function ($join) {
                                $join->on('oi.product_id', '=', 'products.id');
                            })
                                ->leftJoin('orders as o', function ($join) use ($is_customer) {
                                    $join->on('oi.order_id', '=', 'o.id')
                                        ->where('o.customer_id', $is_customer->id);
                                })
                                ->addSelect(DB::raw('CASE WHEN o.customer_id IS NOT NULL THEN 1 ELSE 0 END as purchased_order'));
                            $orderByRaw .= "CASE WHEN purchased_order = 1 THEN 0 ELSE 1 END ASC,";
                        }
                        break;
                    case '_2':
                        if (Session::has('is_customer')) {
                            $is_customer = Session::get('is_customer');
                            $orderByRaw .= "CASE WHEN products.state_id = $is_customer->state_id THEN 0 ELSE 1 END ASC, ";
                        }
                        break;
                    default:
                        $orderByRaw .= "CASE WHEN products.p_badge = '$badgeValue' THEN 0 ELSE 1 END ASC, ";
                        break;
                }
            }
        }


        $orderByRaw .= "products.id DESC";

        // Apply the ORDER BY clause
        $query->orderByRaw($orderByRaw);

        $filter_products = $query->paginate($pagination);

        $data['filter_products'] = $filter_products;

        // Save search the product name or tag which is user searching from text field ---------------

       $queryParameters =  $request->all();
        if (array_key_exists('country', $queryParameters) && empty($queryParameters['country'])) {
            unset($queryParameters['country']);
        }
        if (count($queryParameters) === 1 && array_key_exists('search_by', $queryParameters)) {
            if ($filter_products->isEmpty()) {
                $search_tags = new SearchTags();
                $search_tags->search_tags = $data['search_by'];
                $search_tags->save();
            }
        }

        $selected_filter = $this->selected_filter($data);

        $last_page = $filter_products->lastPage();
        $returnHTML = view('frontend/shop/filter-products',$data)->render();
        return response()->json(array('success' => true, 'querystring' => $querystring, 'last_page' => $last_page, 'html' => $returnHTML ,'selected_filter' => $selected_filter));
    }

    function selected_filter($data)
    {

        $selected_filter = '';

        if(isset($data['child_type']) AND count($data['child_type']) > 0 ) {
            if(count($data['child_type']) == 1) {
                $child_type = ProductType::find($data['child_type'][0]);
                $selected_filter .= "<li><div class='tfu-filter-tag-wrapper' ><span>".$child_type->type_name."</span> <a href='javascript:void(0)' class='cross_filter tfu_product_type'>x</a></div></li>";
            } else {
                $selected_filter .= "<li><div class='tfu-filter-tag-wrapper' ><span>Product type</span> <a href='javascript:void(0)' class='cross_filter tfu_product_type'>x</a></div></li>";
            }
        }

        if(isset($data['country']) AND !empty($data['country'])) {
            $country = Countries::find($data['country']);
            $selected_filter .= "<li><div class='tfu-filter-tag-wrapper' ><span>".$country->country_name."</span> <a href='javascript:void(0)' class='cross_filter tfu_country'>x</a></div></li>";
        }

        if(isset($data['state_id']) AND !empty($data['state_id'])) {
            $state = States::find($data['state_id']);
            $selected_filter .= "<li><div class='tfu-filter-tag-wrapper' ><span>".$state->state_name."</span> <a href='javascript:void(0)' class='cross_filter tfu_state'>x</a></div></li>";
        }

        if(isset($data['artists']) AND count($data['artists']) > 0) {
            if(count($data['artists']) == 1) {
                $artist_detail = Artist::find($data['artists'][0]);
                $selected_filter .= "<li><div class='tfu-filter-tag-wrapper' ><span>".$artist_detail->display_name."</span> <a href='javascript:void(0)'  class='cross_filter tfu_artist'>x</a></div></li>";
            } else {
                $selected_filter .= "<li><div class='tfu-filter-tag-wrapper' ><span>Featured artists</span> <a href='javascript:void(0)'  class='cross_filter tfu_artist'>x</a></div></li>";
            }
        }

        if(isset($data['product_style']) AND count($data['product_style']) > 0) {
            if(count($data['product_style']) == 1) {
                $product_style = ProductStyle::find($data['product_style'][0]);
                $selected_filter .= "<li><div class='tfu-filter-tag-wrapper' ><span>".$product_style->style_name."</span> <a href='javascript:void(0)' class='cross_filter tfu_style'>x</a></div></li>";
            } else {
                $selected_filter .= "<li><div class='tfu-filter-tag-wrapper' ><span>Product Styles</span> <a href='javascript:void(0)' class='cross_filter tfu_style'>x</a></div></li>";
            }
        }

        if(isset($data['customizable']) AND count($data['customizable']) > 0) {
            if(count($data['customizable']) == 1) {
                $product_customizable = ProductCustomizable::find($data['customizable'][0]);
                $selected_filter .= "<li><div class='tfu-filter-tag-wrapper' ><span>".$product_customizable->customizable_name."</span> <a href='javascript:void(0)' class='cross_filter tfu_customizable'>x</a></div></li>";
            } else {
                $selected_filter .= "<li><div class='tfu-filter-tag-wrapper' ><span>Customizable</span> <a href='javascript:void(0)' class='cross_filter tfu_customizable'>x</a></div></li>";
            }
        }

        if(isset($data['search_by']) AND !empty($data['search_by'])) {
            $selected_filter .= "<li><div class='tfu-filter-tag-wrapper' ><span>".$data['search_by']."</span> <a href='javascript:void(0)' class='cross_filter tfu_search_by'>x</a></div></li>";
        }

        if(!empty($selected_filter)) {
            $selected_filter ='<ul class="filter_search_ul">'.$selected_filter.'</ul>';
        }
        return $selected_filter;
    }

    function product_detail(Request $request,$slug)
    {
        $data = $request->all();
        $is_customer = Session::get('is_customer');
        $product = Products::join('product_prices', 'products.id', '=', 'product_prices.product_id')
            //->join('product_type', 'product_prices.pt_sub_id', '=', 'product_type.id')
            ->join('artist', 'products.artist_id', '=', 'artist.id')
            ->leftJoin('badges', 'badges.id', '=', 'products.p_badge')
            ->select('products.product_name','products.type','products.product_description','products.id as pid','products.product_slug','products.feature_image','products.product_customizable','products.product_sku','badges.badge','badges.color','artist.id as artist_id','products.customer_id','artist.first_name','artist.artist_slug','artist.last_name','artist.display_name' ,'product_prices.price', 'product_prices.pt_parent_id','product_prices.pt_sub_id')
            ->when(Session::has('is_customer'), function ($query)   {
                $is_customer = Session::get('is_customer');
                // Left Join for Wishlist
                $query->leftJoin('wishlist as wl', function ($join) use ($is_customer) {
                    $join->on('wl.product_id', '=', 'products.id')
                        ->where('wl.customer_id', $is_customer->id);
                })
                ->addSelect('wl.id as wid');

                // Left Join for Cart
                $query->leftJoin('cart', function ($join) use ($is_customer) {
                    $join->on('cart.product_id', '=', 'products.id')
                        ->where('cart.customer_id', $is_customer->id);
                })
                    ->addSelect('cart.id as cid','cart.quantity as cart_quantity');

                return $query;
            })
            ->where("products.status", "=", 1)
            ->where("artist.status", "=", 1)
            ->where("products.product_slug", "=", $slug)
            ->first();
        if (!$product) {
            abort(404);
        }

        $design_sku = '';
        if(isset($product->product_sku) AND !empty($product->product_sku)) {
            $design_number = explode('-', $product->product_sku);
            if (isset($design_number[1])) {
                $design_sku = $design_number[1];
            }
        }

        // Redirect them to 404 if private listing access not assigned to this customer
        if ($product->customer_id > 0) {
            if (Session::has('is_customer')) {
                if ($product->customer_id != $is_customer->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }
        }


        $product_name = $product->product_name;

        //---------------------------------------------------------------------------------------------------

        $product_galleries = ProductImages::where("product_id", "=", $product->pid)->orderBy('sorting', 'asc')->get();

        //---------------------------------------- Related Products ----------------------------------------------------
        $customer_id = $is_customer->id ?? 0; // Assuming $is_customer->id might be null
        $product_id = $product->pid;
        $related_products = Products::join('product_prices', 'products.id', '=', 'product_prices.product_id')
            ->join('artist', 'products.artist_id', '=', 'artist.id')
            ->select('products.product_name', 'products.id as pid', 'products.product_slug', 'products.product_customizable', 'products.feature_image', 'products.product_sku', 'product_prices.pt_parent_id', 'product_prices.pt_sub_id')
            ->where(function ($query) use ($design_sku, $customer_id) {
                $query->where('products.product_sku', 'LIKE', '%' . $design_sku . '%')
                   // ->where('products.id', '!=', $product->pid)
                    ->where(function ($subquery) use ($customer_id) {
                        $subquery->where('products.customer_id', 0)
                            ->orWhere('products.customer_id', $customer_id);
                    });
            })
            ->where('products.id', '!=', $product->pid)
            ->where("products.status", "=", 1)
            ->where("artist.status", "=", 1)
            ->where("products.artist_id", "=", $product->artist_id)
            ->take(8)
            ->get();

        //---------------------------------------------Products by this artist -----------------------------------------

        $product_by_artists = Products::join('product_prices', 'products.id', '=', 'product_prices.product_id')
            //->join('product_type', 'product_prices.pt_sub_id', '=', 'product_type.id')
            ->join('artist', 'products.artist_id', '=', 'artist.id')
            ->leftJoin('badges', 'badges.id', '=', 'products.p_badge')
            ->select('products.product_name','products.product_customizable','products.id as pid','products.product_slug','products.feature_image','products.product_sku','badges.badge','badges.color','artist.first_name','artist.last_name','artist.display_name' ,'artist.artist_slug','product_prices.price', 'product_prices.pt_parent_id','product_prices.pt_sub_id')
            ->where('products.id', '!=', $product->pid)
            ->where(function ($query) {
                $query->where("products.customer_id", "=", 0)
                    ->orWhere(function ($query) {
                        if (Session::has('is_customer')) {
                            $is_customer = Session::get('is_customer');
                            $query->where('products.customer_id', $is_customer->id);
                        }
                    });
            })
            ->where("products.status", "=", 1)
            ->where("artist.status", "=", 1)
            ->where("products.artist_id", "=", $product->artist_id)
            ->when(Session::has('is_customer'), function ($query)  {
                $is_customer = Session::get('is_customer');
                // Left Join for Wishlist
                $query->leftJoin('wishlist as wl', function ($join) use ($is_customer) {
                    $join->on('wl.product_id', '=', 'products.id')
                        ->where('wl.customer_id', $is_customer->id);
                })
                 ->addSelect('wl.id as wid');

                // Left Join for Cart
                $query->leftJoin('cart', function ($join) use ($is_customer) {
                    $join->on('cart.product_id', '=', 'products.id')
                        ->where('cart.customer_id', $is_customer->id);
                })
                ->addSelect('cart.id as cid','cart.quantity as cart_quantity');

                return $query;
            })
            ->orderBy('products.customer_id', 'DESC')
            //->orderBy('products.id', 'ASC')
            ->take(8)
            ->get();

        //--------------------------------- Get product type detail ----------------------------------------------------

        $getProductTypeDetail = array();
        if(isset($product->pt_sub_id) AND $product->pt_sub_id > 0)
            $getProductTypeDetail  =  $this->getProductTypeDetail($product->pt_sub_id);

        //-------------------------------   This will be used in seo title for unqiue----------------------------------

        $product_size = '';
        if($getProductTypeDetail) {
            $product_size .= ''.$getProductTypeDetail->child->type_name ?? '';
            $product_size .= ' '.$getProductTypeDetail->type_name ?? '';
        }

        //--------------------------------------- Below code only will be used for SEO purpose-------------------------

        $page_title = $product->product_name ?? '';
        $page_description = $product->product_description ?? '';
        if(empty($page_description)) {
                $page_description .= $page_title;
                $page_description .= ' '.$product_size;
                $page_description .= ' by ' .$product->display_name ?? '';
        }
        $page_description =  ucwords($this->generateMetaTitle($page_description,160));
        $page_title =        ucwords($this->generateMetaTitle($page_title.' by '.$product->display_name.' '.$product_size));
        $structuredData = $this->generateProductStructuredData($product, $page_title, $page_description);
        // This image will be used in head using og image for social media
        //echo "here vvv";exit;
        $og_image = '';
        if( !empty($product->feature_image) && \Storage::disk('uploads')->exists('/products/large-'.$product->feature_image)) {
            $og_image = url('uploads/products/large-'.$product->feature_image);
        }
        // End SEO -----------------------------------------------------------------------------------------------------
       // echo "here";exit;
        return view('frontend/shop/product-detail', compact('product','product_galleries','related_products','product_by_artists','getProductTypeDetail','page_title','page_description','structuredData','og_image'));

    }

    //-------------------------- Wishlist ------------------------------------------------------

    function add_wishlist(Request $request)
    {
        $data = $request->all();

        if(Session::has('is_customer') && !empty(Session::get('is_customer'))) {

            $validated = $request->validate([
                'productId' => 'required'
            ]);

            $is_customer = Session::get('is_customer');
            $productId = $request->productId;

            // Delete wishlist if there is already exist this will be work same like/dislike

            $wishlist_exists = Wishlist::where("product_id", $productId)->where('customer_id', $is_customer->id)->exists();
            if($wishlist_exists) {
                Wishlist::where('product_id', $request->productId)
                    ->where('customer_id', $is_customer->id)
                    ->delete();

                return response()->json([
                    'message' => 'Product Removed from wishlist',
                    'status' => 'success',
                    'whishlist_icon' => asset('/assets/frontend-assets/svg/whishlist-without-heart.svg')
                ]);

            }

            $product = Products::find($productId);
            $product_price = ProductPrices::select('*')->where("product_id", $productId)->first();

            $moq_case_pack = array();
            if(isset($product->product_customizable) AND isset($product_price->pt_sub_id))
                $moq_case_pack  = Helper::get_moq_case_pack($product->product_customizable,$product_price->pt_sub_id);

            $productQuantity = $moq_case_pack->minimum_order_quantity ?? 1;

            $wishlist = new Wishlist();
            $wishlist->customer_id = $is_customer->id;
            $wishlist->product_id = $productId;
            $wishlist->product_prices_id = $product_price->id;
            $wishlist->quantity = $productQuantity;
            $wishlist->save();

            return response()->json([
                'message' => 'Product added to wishlist',
                'status' => 'success',
                'product_id' => $productId,
                'wid' => $wishlist->id,
                'whishlist_icon' => asset('/assets/frontend-assets/svg/whishlist-heart.svg')
            ]);
        }
    }

    function wishlist(Request $request)
    {
        $data = $request->all();
        $is_customer = Session::get('is_customer');
        $wishlists = Products::join('product_prices', 'products.id', '=', 'product_prices.product_id')
            ->join('product_type', 'product_prices.pt_sub_id', '=', 'product_type.id')
            ->join('artist', 'products.artist_id', '=', 'artist.id')
            ->join('wishlist', 'wishlist.product_id', '=', 'products.id')
            ->select('products.product_name','products.id as pid','products.product_slug','products.product_customizable','products.feature_image','products.product_sku','artist.id as artist_id','artist.artist_slug','artist.first_name','artist.last_name','artist.display_name' ,'product_prices.price', 'product_type.type_name','wishlist.id as wid','wishlist.quantity as w_quantity','product_prices.pt_parent_id','product_prices.pt_sub_id')
            ->where("products.status", "=", 1)
            ->where("artist.status", "=", 1)
            ->where("wishlist.customer_id", "=", $is_customer->id)
            ->get();
        $page_title = 'Wishlist';
        return view('frontend/my-account/wishlist', compact('wishlists','page_title'));

    }

    function remove_wishlist(Request $request)
    {
        $data = $request->all();
        if(Session::has('is_customer') && !empty(Session::get('is_customer'))) {

            $is_customer = Session::get('is_customer');
            $wishlist_id = $request->wishlist_id;

            Wishlist::where('id', $wishlist_id)
                ->where('customer_id', $is_customer->id)
                ->delete();

            return response()->json([
                'message' => 'Product removed from wishlist',
                'status' => 'success',
                'wid' => $wishlist_id
            ]);
        }

    }

    function update_wishlist(Request $request)
    {
        $data = $request->all();

        if(Session::has('is_customer') && !empty(Session::get('is_customer'))) {

            $validated = $request->validate([
                'wid' => 'required'
            ]);

            $isCustomer = Session::get('is_customer');
            $wid = $request->wid;

            $wishlist = Wishlist::firstOrNew(['id' => $wid, 'customer_id' => $isCustomer->id]);

            //$existingQuantity = $wishlist->quantity;
            //$product = Products::find($wishlist->product_id);
            //$productQuantity = $product->case_pack;

            $product_price = ProductPrices::where('product_id',  $wishlist->product_id)->first();

            $wishlist->quantity =   (isset($request->quantity) && $request->quantity > 0) ? $request->quantity : 1;

            $wishlist->save();

            $total_price  = Wishlist::where('customer_id', $isCustomer->id)
                ->select('product_prices.price')
                ->join('product_prices', 'product_prices.id', '=', 'wishlist.product_prices_id')
                ->sum(DB::raw('product_prices.price * wishlist.quantity'));

            return response()->json([
                'message' => 'Update to cart',
                'status' => 'success',
                'item_quantity' => $wishlist->quantity,
                'price' => $total_price,
                //'item_quantity' => $cart->quantity,
            ]);
        }
    }

    function add_to_cart_all_wishlist_item(Request $request)
    {
        $data = $request->all();

        if(Session::has('is_customer') && !empty(Session::get('is_customer'))) {

            $isCustomer = Session::get('is_customer');
            $wishlists = Wishlist::where('customer_id' , $isCustomer->id)->get();
            if($wishlists) {
                foreach($wishlists as $wishlist) {
                    $productId = $wishlist->product_id;
                    $product = Products::find($productId);
                    $product_price = ProductPrices::where("product_id", $productId)->first();
                    $cart = Cart::firstOrNew(['product_id' => $productId, 'customer_id' => $isCustomer->id]);

                    $existingQuantity = $cart->exists ? $cart->quantity : 0;
                    $productQuantity = $wishlist->quantity;

                    $cart->fill([
                        'customer_id' => $isCustomer->id,
                        'product_id' => $productId,
                        'product_prices_id' => $product_price->id,
                        'quantity' => $existingQuantity + $productQuantity,
                    ])->save();
                }

                $totalQuantity = Cart::where('customer_id',  $isCustomer->id)->sum('quantity');
                return response()->json([
                    'message' => 'Product added to cart',
                    'status' => 'success',
                    'total_quantity' => $totalQuantity,
                ]);

            }
        }
    }

    //-------------------------- Cart ------------------------------------------------------

    function add_to_cart(Request $request)
    {
        $data = $request->all();

        if(Session::has('is_customer') && !empty(Session::get('is_customer'))) {

            $validated = $request->validate([
                'productId' => 'required'
            ]);

            $isCustomer = Session::get('is_customer');
            $productId = $request->productId;
            //echo $productId;exit;
            // Retrieve product and product price
            $product = Products::find($productId);
            $product_price = ProductPrices::where("product_id", $productId)->first();
           // print_r($product_price);exit;
            // If product quantity send in request then will update quanity in table the same value


            $moq_case_pack = array();
            if(isset($product->product_customizable) AND isset($product_price->pt_sub_id))
                $moq_case_pack  = Helper::get_moq_case_pack($product->product_customizable,$product_price->pt_sub_id);

            $cart = Cart::firstOrNew(['product_id' => $productId, 'customer_id' => $isCustomer->id]);

            $existingQuantity = $cart->exists ? $cart->quantity : 0; //isset($request->quantity) ? 0 : ($cart->exists ? $cart->quantity : 0);

            $productQuantity = isset($request->quantity) ? $request->quantity : ($cart->exists ? $moq_case_pack->case_pack : ($moq_case_pack->minimum_order_quantity ?? 1));

            $cart->fill([
                'customer_id' => $isCustomer->id,
                'product_id' => $productId,
                'product_prices_id' => $product_price->id,
                'quantity' => $existingQuantity + $productQuantity,
            ])->save();

            // Find total quantity from table
            $totalQuantity = Cart::where('customer_id',  $isCustomer->id)->sum('quantity');

            $case_pack = (isset($moq_case_pack->case_pack) && $moq_case_pack->case_pack > 0) ? $moq_case_pack->case_pack : 1;
            $calculted_price =  number_format($case_pack * $product_price->price, 2);
            $total_added_quantity = $existingQuantity + $productQuantity;
            $current_added_item_total_price = number_format($total_added_quantity * $product_price->price, 2);
            $only_current_quantity_price =  number_format( $request->quantity * $product_price->price, 2);

            return response()->json([
                'message' => 'Product added to cart',
                'status' => 'success',
                'product_id' => $productId,
                'total_quantity' => $totalQuantity,
                'only_current_quantity_price' => $only_current_quantity_price,
                'only_current_quantity' => $request->quantity,
                'case_pack' => $moq_case_pack->case_pack ?? 1,
                'calculted_price' => $calculted_price,
                'current_added_item_quantity' => $total_added_quantity,
                'current_added_item_total_price' => $current_added_item_total_price,
            ]);
        }
    }

    function cart(Request $request)
    {
        $data = $request->all();
        $is_customer = Session::get('is_customer');
        $cart_products = Products::join('product_prices', 'products.id', '=', 'product_prices.product_id')
            ->join('product_type', 'product_prices.pt_sub_id', '=', 'product_type.id')
            ->join('artist', 'products.artist_id', '=', 'artist.id')
            ->join('cart', 'cart.product_id', '=', 'products.id')
            ->select('products.product_name','products.id as pid','products.product_slug','products.product_customizable','products.feature_image','products.product_sku','artist.id as artist_id','artist.first_name','artist.last_name','artist.display_name' ,'artist.artist_slug' ,'product_prices.price','product_prices.pt_sub_id', 'product_type.type_name','cart.id as cid','cart.quantity as quantity')
            ->when(Session::has('is_customer'), function ($query)  {
                $is_customer = Session::get('is_customer');
                // Left Join for Wishlist
                $query->leftJoin('wishlist as wl', function ($join) use ($is_customer) {
                    $join->on('wl.product_id', '=', 'products.id')
                        ->where('wl.customer_id', $is_customer->id);
                })
                ->addSelect('wl.id as wid');
                return $query;
            })
            ->where("products.status", "=", 1)
            ->where("artist.status", "=", 1)
            ->where("cart.customer_id", "=", $is_customer->id)
            ->get();
        $page_title = 'Cart';

        return view('frontend/shop/cart', compact('cart_products','page_title'));

    }

    function remove_cart(Request $request)
    {
        $data = $request->all();
        if(Session::has('is_customer') && !empty(Session::get('is_customer'))) {

            $is_customer = Session::get('is_customer');
            $cid = $request->cid;

            Cart::where('id', $cid)
                ->where('customer_id', $is_customer->id)
                ->delete();

            return response()->json([
                'message' => 'Product removed from cart',
                'status' => 'success',
                'wid' => $cid
            ]);
        }
    }

    function update_cart(Request $request)
    {
        $data = $request->all();

        if(Session::has('is_customer') && !empty(Session::get('is_customer'))) {

            $validated = $request->validate([
                'cid' => 'required'
            ]);
            $siteManagement  = SiteManagements::getSiteManagment();

            $isCustomer = Session::get('is_customer');
            $cart_id = $request->cid;

            $cart = Cart::firstOrNew(['id' => $cart_id, 'customer_id' => $isCustomer->id]);

            $product_price = ProductPrices::where('product_id',  $cart->product_id)->first();
            $cart->quantity =   (isset($request->quantity) && $request->quantity > 0) ? $request->quantity : 1;

            $cart->save();

            // Find total quantity from table
           // $totalQuantity = Cart::where('customer_id',  $isCustomer->id)->sum('quantity');
            $item_total_price = $cart->quantity * $product_price->price;

            $total_price  = Cart::where('customer_id', $isCustomer->id)
                ->select('product_prices.price')
                ->join('product_prices', 'product_prices.id', '=', 'cart.product_prices_id')
                ->sum(DB::raw('product_prices.price * cart.quantity'));

            $results = Cart::where('customer_id', $isCustomer->id)
                ->join('product_prices', 'product_prices.id', '=', 'cart.product_prices_id')
                ->select([
                    DB::raw('SUM(product_prices.price * cart.quantity) as total_price'),
                    DB::raw('SUM(cart.quantity) as total_quantity'),
                ])
                ->first();

            $total_price = $results->total_price;
            $total_cart_quantity = $results->total_quantity; // Find total cart quantity

            $shipment_cost = 0.00;
            $final_price = $total_price + $shipment_cost;

            if($total_price <= $siteManagement->shipping_threshold) {
                $shipment_cost = $siteManagement->shipping_fee;
                $final_price = $total_price + $shipment_cost;
                //$place_order_text = 'Minimum order size $'.$siteManagement->minimum_order_amount;
            }

            // Change place order text according minimum_order_amount and total order amount
            $remove_disable_class = true;
            $place_order_text = 'Place Order';
            if((isset($siteManagement->minimum_order_amount) && $siteManagement->minimum_order_amount > $total_price ))
            {
                $remove_disable_class = false;
                $place_order_text = 'Minimum order size $'.$siteManagement->minimum_order_amount;
            }

            return response()->json([
                'message' => 'Update to cart',
                'status' => 'success',
                'cart_id' => $cart_id,
                'total_quantity' => $cart->quantity,
                'total_cart_quantity' => $total_cart_quantity,
                'price' => number_format($item_total_price, 2),
                'total_price' => number_format($total_price, 2),
                'final_price' => number_format($final_price, 2),
                'shipment_cost' => number_format($shipment_cost, 2),
                'place_order_text' => $place_order_text,
                'remove_disable_class' => $remove_disable_class,
            ]);
        }
    }

    function place_order(Request $request)
    {
        $data = $request->all();

        if(Session::has('is_customer') && !empty(Session::get('is_customer'))) {

            $siteManagement  = SiteManagements::getSiteManagment();

            //Check Customer profile missing fields valdaite first

            $is_customer = Session::get('is_customer');

            if(isset($data['shipping_address1']) && !empty(trim($data['shipping_address1']))) {
                $customer = Customer::select('*')->where("id", $is_customer->id)->first();
                $customer->shiping_address1 = $data['shipping_address1'];
                $customer->save();

                $customer->otp = 1;
                Session::forget("is_customer");
                Session::put("is_customer", $customer);
            }

            // Getting session because after update
            $is_customer = Session::get('is_customer');

            if((empty($is_customer->shiping_address1) && empty($is_customer->shiping_address2)) || empty($is_customer->company ))
            {
                Session::flash('error', 'Please complete your profile. This step is required to proceed with your order.');
                return response()->json([
                    'status' => 'success',
                    'redirect_url' => route('customer-profile')
                ]);
            }

            //------------ end customer valdation

            $cart_items = Cart::select('*')->where("customer_id", $is_customer->id)->get();

            if ($cart_items->isEmpty()) {
                return response()->json([
                    'message' => 'Cart is empty',
                    'status' => 'error'
                ]);
            }


            if($cart_items->isNotEmpty()) {
                $orders = new Orders();
                $orders->order_number = Orders::max('order_number') + 1;
                $orders->customer_id = $is_customer->id;

                $orders->status = 1;

                if(isset($siteManagement->estimated_ship_days) AND $siteManagement->estimated_ship_days > 0) {
                    $orders->estimated_ship_date = Carbon::now()->addDays($siteManagement->estimated_ship_days);
                }
                $orders->order_notes = $data['order_notes'] ?? NULL;
                $orders->save();
                $order_id = $orders->id;

                $order_total_amount = 0;

                foreach ($cart_items as $cart_item) {

                    $product_price  = ProductPrices::find($cart_item->product_prices_id);
                    $item_price = $product_price->price;

                    $order_total_amount += $cart_item->quantity * $item_price;

                    $orders_items = new OrderItems();
                    $orders_items->order_id =  $order_id;
                    $orders_items->product_id =  $cart_item->product_id;
                    $orders_items->product_prices_id =  $cart_item->product_prices_id;
                    $orders_items->quantity =  $cart_item->quantity;
                    $orders_items->price =  $item_price;
                    $orders_items->sale_price =  $item_price;
                    $orders_items->status =  1;
                    $orders_items->save();
                }

                // When order placed successfully then delete all item from cart table
                if($order_total_amount <=  $siteManagement->shipping_threshold) {
                    $orders->shipping_cost = $siteManagement->shipping_fee;
                    $orders->save();
                }

                Cart::where('customer_id', $is_customer->id)->delete();

                $order = Orders::find($order_id);
                Orders::order_notification_to_customer($order);
                Orders::order_notification_to_admin($order);
                $success_message = '<div class="tfu-popup-useraccount">
                            <p>Order placed successfully</p>
                            <div class="ftu-signin-popup-btn">
                                <a class="nav-link" href="' . route('home') . '">Home</a>
                            </div>
                        </div>';

                Session::flash('message', 'Order placed successfully');

                return response()->json([
                    'message' => $success_message,
                    'status' => 'success',
                    'redirect_url' => route('my-order')
                ]);
            }
        }
    }

    //-------------------------- My order ------------------------------------------------------

    function my_order(Request $request)
    {
        $data = $request->all();
        $is_customer = Session::get('is_customer');
        $my_order_qry = Orders::with('orderItems', 'customer')
            ->select('*')
            ->where('orders.customer_id', '=', $is_customer->id);
            if(isset($_GET['oid']) AND $_GET['oid'] > 0) {
                $my_order_qry->where('orders.id', '=', $_GET['oid']);
            }
            $my_order_qry->orderBy('orders.id', 'desc');
        $my_orders =    $my_order_qry->paginate(10);
        $page_title = 'My Order';
        return view('frontend/my-account/my-orders', compact('my_orders','page_title'));

    }

    function order_detail(Request $request,$id)
    {
        $data = $request->all();
        $order_id = $id;
        $order = Orders::find($order_id);
        $page_title = 'Order Detail';
        return view('frontend/my-account/order-detail', compact('order','page_title'));
    }

    function add_to_wishlist_all_ordered_item(Request $request)
    {
        $data = $request->all();

        if(Session::has('is_customer') && !empty(Session::get('is_customer'))) {

            $isCustomer = Session::get('is_customer');
            $order = Orders::find($data['order_id']);
            foreach($order->orderItems as $item) {

                $wishlist_exists = Wishlist::where("product_id", $item->product_id)->where('customer_id', $isCustomer->id)->exists();
                if(!$wishlist_exists) {
                    $product = Products::find($item->product_id);
                    $product_price = ProductPrices::select('*')->where("product_id", $item->product_id)->first();

                    $moq_case_pack = array();
                    if (isset($product->product_customizable) and isset($product_price->pt_sub_id))
                        $moq_case_pack = Helper::get_moq_case_pack($product->product_customizable, $product_price->pt_sub_id);

                    $productQuantity = $moq_case_pack->minimum_order_quantity ?? 1;

                    $wishlist = new Wishlist();
                    $wishlist->customer_id = $isCustomer->id;
                    $wishlist->product_id = $item->product_id;
                    $wishlist->product_prices_id = $product_price->id;
                    $wishlist->quantity = $productQuantity;
                    $wishlist->save();
                }
            }
            return response()->json([
                'message' => 'Product added to wishlist',
                'status' => 'success',
                'whishlist_icon' => asset('/assets/frontend-assets/svg/whishlist-heart.svg')
            ]);
        }
    }

    function add_to_cart_all_ordered_item(Request $request)
    {
        $data = $request->all();

        if(Session::has('is_customer') && !empty(Session::get('is_customer'))) {

            $isCustomer = Session::get('is_customer');
            $customer_id = $isCustomer->id;


            $siteManagement  = SiteManagements::getSiteManagment();

            $order = Orders::find($data['order_id']);
            foreach($order->orderItems as $item) {
                $productId = $item->product_id;
                $quantity = $item->quantity;
                // Retrieve product and product price
                $product = Products::where('status', '=', 1)->find($productId);
                if(!$product)
                    continue;
                $product_price = ProductPrices::where("product_id", $productId)->first();


                $moq_case_pack = array();
                if(isset($product->product_customizable) AND isset($product_price->pt_sub_id))
                    $moq_case_pack  = Helper::get_moq_case_pack($product->product_customizable,$product_price->pt_sub_id);

                $cart = Cart::firstOrNew(['product_id' => $productId, 'customer_id' => $isCustomer->id]);

                $existingQuantity = $cart->exists ? $cart->quantity : 0; //isset($request->quantity) ? 0 : ($cart->exists ? $cart->quantity : 0);

                $productQuantity = isset($quantity) ? $quantity : ($cart->exists ? $moq_case_pack->case_pack : ($moq_case_pack->minimum_order_quantity ?? 1));

                $cart->fill([
                    'customer_id' => $isCustomer->id,
                    'product_id' => $productId,
                    'product_prices_id' => $product_price->id,
                    'quantity' => $existingQuantity + $productQuantity,
                ])->save();

                // Find total quantity from table
                $totalQuantity = Cart::where('customer_id',  $isCustomer->id)->sum('quantity');

            }

            Session::flash('message', 'All Ordered item has been added to cart');

            return response()->json([
                'message' => 'Product added to cart',
                'status' => 'success',
                'total_quantity' => $totalQuantity,
                'redirect_url' => route('cart')
            ]);
        }
    }

    //------------------  Send me an e-mail when such designs are available -------------------------

    function search_tag_designs_are_available(Request $request)
    {
        $data = $request->all();

        if (Session::has('is_customer')) {
            $is_customer = Session::get('is_customer');
        }

        $ipAddress = $request->ip();
        list($browser, $os) = $this->parseUserAgent($request->header('User-Agent'));

        $search_tags = new SearchTags();
        $search_tags->search_tags = $data['search_by'];
        $search_tags->email = $data['contact_email'];
        $search_tags->is_contact = 1;
        $search_tags->ip_address = $ipAddress;
        $search_tags->browser = $browser;
        $search_tags->os = $os;
        $search_tags->save();

        return response()->json([
            'message' => 'NOTED - Thank you, we will contact you when such designs are available',
            'status' => 'success',
        ]);
    }

    //--------------------------------------- Delete customizer product by user ---------------------

    function delete_customizer_product_by_user(Request $request)
    {
        $data = $request->all();
        //echo "<pre>";print_r($data);exit;
        if(Session::has('is_customer') && !empty(Session::get('is_customer'))) {

            $product = Products::findOrFail($data['pid']);

            if ($product->type === 2) {
                if ($product->orderItems()->exists()) {
                    // Update the status to 2 (soft delete)
                    Products::where('id', $data['pid'])->update(['status' => 2]);
                    return response()->json([
                        'message' => 'Product has been deleted',
                        'status' => 'success',
                    ]);
                } else {

                    // Delete related images from the directory
                   // echo "<pre>";print_r($product->images);exit;
                    if($product->images) {
                        foreach ($product->images as $image) {
                            if (!empty($image->image_name)) {
                                $image_size = array('small','medium','large');
                                $imagePath = base_path('uploads/products/' . $image->image_name);
                                if (\File::exists($imagePath)) {
                                    unlink($imagePath);
                                }
                                foreach($image_size as $key => $size) {
                                    $imagePath = base_path('uploads/products/'.$size.'-'.$image->image_name);
                                    if (\File::exists($imagePath)) {
                                        unlink($imagePath);
                                    }

                                }
                            }
                        }
                    }

                    // Delete related records in other tables
                    $product->images()->delete();
                    $product->prices()->delete();
                    $product->tags2()->detach(); // Detach tags from pivot table

                    // Delete the product itself
                    $product->delete();

                    return response()->json([
                        'message' => 'Product has been deleted2',
                        'status' => 'success',
                    ]);
                }
            }
            else {
                return response()->json(['message' => 'Product type is not eligible for deletion.','status' => 'error'], 400);
            }
        }
    }

    //-----------------------------------------------------------------------------------------------

    public function parseUserAgent($userAgent)
    {
        $browser = "Unknown Browser";
        $os = "Unknown OS";

        // Check for browsers
        if (preg_match('/MSIE/i', $userAgent) || preg_match('/Trident/i', $userAgent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Chrome/i', $userAgent) && !preg_match('/Edge/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Safari/i', $userAgent) && !preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Edge/i', $userAgent)) {
            $browser = 'Edge';
        }

        // Check for OS
        if (preg_match('/Windows/i', $userAgent)) {
            $os = 'Windows';
        } elseif (preg_match('/Macintosh|Mac OS X/i', $userAgent)) {
            $os = 'Mac OS';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $os = 'Linux';
        } elseif (preg_match('/Android/i', $userAgent)) {
            $os = 'Android';
        } elseif (preg_match('/iPhone|iPad/i', $userAgent)) {
            $os = 'iOS';
        }

        return [$browser, $os];
    }

}
