<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Cart;
use App\Models\Countries;
use App\Models\Customer;
use App\Models\HomepageSlider;
use App\Models\ProductCustomizable;
use App\Models\Products;
use App\Models\ProductStyle;
use App\Models\ProductType;
use App\Models\SiteManagements;
use App\Models\States;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SiteController extends Controller
{
    function home(Request $request)
    {
        try {
            // get all active slider
            $homepage_sliders = HomepageSlider::select('*')
                ->where("status", 1)
                ->orderBy('sort_order', 'ASC')
                ->get();

            //------------------------------ Get feature arist ------------------------------------------------
            $artists = Artist::whereHas('products', function ($query) {
                $query->where('is_feature', 1);
            })->has('products')->take(4)->get();

            //-------------------------- get all products ------------------------------------------------------

            $products = Products::join('product_prices', 'products.id', '=', 'product_prices.product_id')
                //->join('product_type', 'product_prices.pt_sub_id', '=', 'product_type.id')
                ->join('artist', 'products.artist_id', '=', 'artist.id')
                ->leftJoin('badges', 'badges.id', '=', 'products.p_badge')
                ->select('products.product_name','products.id as pid', 'products.product_slug', 'products.product_customizable','products.feature_image','products.product_sku','badges.badge','badges.color','artist.first_name','artist.last_name','artist.display_name' ,'artist.artist_slug' ,'product_prices.price', 'product_prices.pt_parent_id','product_prices.pt_sub_id')
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

                ->where("products.status", "=", 1)
                ->where('products.customer_id', 0)
                ->where("artist.status", "=", 1)
                ->orderBy('products.id', 'desc')
                ->paginate(10);
                //echo "<pre>";print_r($products);exit;
            //--------------------------------------------------------------------------------------------------
            $page_title = 'Wholesale Custom Wooden Trays and Coasters';
            $page_description = 'Create your own custom tray by applying your artwork or map. Place your logo on the back. Low minimums and 3-4 week delivery. Create collections from over 600+ predefined designs. Ships from New Hampshire and handcrafted in Finland.';
            return view('frontend/site/home', compact('products','homepage_sliders','artists','page_title','page_description'));
        } catch (\Exception $exception) {
            echo "dsadsa";exit;
            return redirect(route('home'))->withInput($request->all())->with('error', $exception->getMessage());
        }
    }

    function ajax_home_more_products(Request $request)
    {
        $data = $request->all();
        $products = Products::join('product_prices', 'products.id', '=', 'product_prices.product_id')
            //->join('product_type', 'product_prices.pt_sub_id', '=', 'product_type.id')
            ->join('artist', 'products.artist_id', '=', 'artist.id')
            ->leftJoin('badges', 'badges.id', '=', 'products.p_badge')
            ->select('products.product_name','products.id as pid', 'products.product_slug','products.product_customizable','products.feature_image','products.product_sku','badges.badge','badges.color','artist.first_name','artist.last_name','artist.display_name' ,'artist.artist_slug' ,'product_prices.price', 'product_prices.pt_parent_id','product_prices.pt_sub_id')
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
            ->where('products.customer_id', 0)
            ->where("products.status", "=", 1)
            ->where("artist.status", "=", 1)
            ->orderBy('products.id', 'desc')
            ->paginate(10);

        $data['filter_products'] = $products;
        $lastPage = $products->lastPage();
        $returnHTML = view('frontend/site/ajax-load-more-products',$data)->render();
        return response()->json(array('success' => true,'last_page' => $lastPage, 'html' => $returnHTML));
    }

    function create_custom(Request $request)
    {
        $page_title = 'Create custom';
        $page_description = '';
        return view('frontend/artist/create-custom', compact('page_title'));
    }

    public function term_condition()
    {
        $page_title = 'Term condition';
        $page_description = '';
        return view('frontend/customers/term-condition', compact('page_title'));
    }

    public function privacy_policy()
    {
        $page_title = 'Privacy Policy';
        $page_description = '';
        return view('frontend/customers/privacy-policy', compact('page_title'));
    }

    public function contact_us()
    {
        $page_title = 'Contact Us';
        $page_description = 'Let us know how we can help you. Call us (603) 498-6283.';
        return view('frontend/site/contact-us', compact('page_title','page_description'));
    }

    public function sitemap()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/'))
            ->add(Url::create('/products'))
            ->add(Url::create('/create-custom'))
            ->add(Url::create('/artists'))
            ->add(Url::create('/contact-us'))
           // ->add(Url::create('/wishlist'))
           // ->add(Url::create('/my-order'))
           // ->add(Url::create('/my-account'))
            ->add(Url::create('/sign-in'))
            ->add(Url::create('/sign-up'));

        $artists =  Artist::select('id','artist_slug')
                    ->where("artist.status", "=", 1)
                    ->where("artist.is_visible", "=", 1)
                    ->orderBy('artist.sort_order', 'asc')->get();

        foreach($artists as $artist) {
            $sitemap->add(Url::create('/artists/'.$artist->artist_slug));
        }

        $products = Products::join('product_prices', 'products.id', '=', 'product_prices.product_id')
            ->join('artist', 'products.artist_id', '=', 'artist.id')
            ->leftJoin('badges', 'badges.id', '=', 'products.p_badge')
            ->select('products.product_name','products.id as pid','products.product_slug')
            ->where("products.status", "=", 1)
            ->where("artist.status", "=", 1)
            ->where('products.customer_id', 0)
            ->orderBy('products.id', 'desc')
            ->get();

        foreach($products as $product) {
            $sitemap->add(Url::create('/product/'.$product->product_slug));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
        return "Sitemap created successfully";
    }

}
