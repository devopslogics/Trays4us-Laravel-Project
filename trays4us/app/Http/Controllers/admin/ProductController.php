<?php

namespace App\Http\Controllers\admin;

use App\Models\Artist;
use App\Models\Badges;
use App\Models\Customer;
use App\Models\CustomizableTypeRelation;
use App\Models\ProductImages;
use App\Models\Tags;
use App\Models\SearchTags;
use App\Models\ProductsTag;
use App\Models\TagSynonyms;
use App\Models\ProductCustomizable;
use Cassandra\Custom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\TempProducts;
use App\Models\TempProductImages;
use App\Models\ProductType;
use App\Models\Helper;
use App\Models\ProductPrices;
use App\Models\CustomizerProcessingTime;
use App\Models\ProductStyle;
use App\Models\Countries;
use App\Models\States;
use App\Exports\ProductExportExcel;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use Illuminate\Validation\Rule;
use App\Rules\UniqueProductSKU;
use Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;
use DB;
use View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function __construct()
    {
        //$this->middleware('inspector');
    }

    //------------------------------------------------------------------------------------------------------------------

    public function products_listing(Request $request){
        try {

            $data = $request->all();
            $pagination = optional(View::shared('site_management'))->backend_pagination_listing ?? 50;
            $filter_flag = false;
            $productName = isset($data['product_name']) ? $data['product_name'] : '';
            $products_qry = Products::select('products.*')
                ->leftJoin('artist', 'products.artist_id', '=', 'artist.id')
                ->leftJoin('customers', 'products.customer_id', '=', 'customers.id')
                ->leftJoin('badges', 'products.p_badge', '=', 'badges.id')
                ->leftJoin('product_style', 'products.style_id', '=', 'product_style.id')
                ->whereIn('products.status', [0, 1])
                ->when(!empty($productName), function ($query) use ($productName, &$filter_flag) {
                    $filter_flag = true;
                    return $query->where(function ($subquery) use ($productName) {
                        $subquery->where('product_name', 'LIKE', '%' . $productName . '%')
                            ->orWhereHas('artist', function ($artistSubquery) use ($productName) {
                                $artistSubquery->where('first_name', 'LIKE', '%' . $productName . '%')
                                    ->orWhere('last_name', 'LIKE', '%' . $productName . '%')
                                    ->orWhere('display_name', 'LIKE', '%' . $productName . '%');
                            });
                    });
                })
                ->when(isset($data['product_sku']), function ($query) use ($data, &$filter_flag) {
                    $filter_flag = true;
                    return $query->where('products.product_sku', 'LIKE', '%' . $data['product_sku'] . '%');
                })
                ->when(isset($data['artist_id']), function ($query) use ($data, &$filter_flag) {
                    $filter_flag = true;
                    return $query->where('products.artist_id', $data['artist_id']);
                })
                ->when(isset($data['customer_id']), function ($query) use ($data, &$filter_flag) {
                    $filter_flag = true;
                    return $query->where('products.customer_id', $data['customer_id']);
                });

                if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'order_by_pname') {
                    $products_qry->orderBy('product_name', $data['order']);
                } elseif (isset($_GET['sort_by']) && $_GET['sort_by'] == 'order_by_psku') {
                    $products_qry->orderBy('product_sku', $data['order']);
                } elseif (isset($_GET['sort_by']) && $_GET['sort_by'] == 'order_by_artist') {
                    $products_qry->orderBy('artist.display_name', $data['order']);
                } elseif (isset($_GET['sort_by']) && $_GET['sort_by'] == 'order_by_customer') {
                    $products_qry->orderBy('customers.first_name', $data['order']);
                } elseif (isset($_GET['sort_by']) && $_GET['sort_by'] == 'order_by_badge') {
                    $products_qry->orderBy('badges.badge', $data['order']);
                } elseif (isset($_GET['sort_by']) && $_GET['sort_by'] == 'order_by_theme') {
                    $products_qry->orderBy('product_style.style_name', $data['order']);
                } elseif (isset($_GET['sort_by']) && $_GET['sort_by'] == 'order_by_last_updated') {
                    $products_qry->orderBy('products.updated_at', $data['order']);
                } else {
                    $products_qry->orderBy('products.updated_at', 'desc');
                }

            $products = $products_qry->paginate($pagination);

            //---------------------------------------------------------------------------------------------------------

            $artists = Artist::select('*') ->wherein("status", array(0, 1)) ->orderBy('id', 'desc')->get();
            $customers = [];
            if(isset($data['customer_id']) && $data['customer_id'] > 0) {
                $customers = Customer::find($data['customer_id']);
            }

            return view('admin.products.listing', compact('products','filter_flag', 'artists','customers'));

        } catch (\Exception $exception) {
            return redirect(route("products"))->with("error", $exception->getMessage());
        }
    }

    public function generate_products_slug() {
        $products = Products::join('product_prices', 'products.id', '=', 'product_prices.product_id')
            ->join('artist', 'products.artist_id', '=', 'artist.id')
            ->leftJoin('badges', 'badges.id', '=', 'products.p_badge')
            ->select('products.product_name','products.id as pid','products.product_slug')
            ->wherein("products.status", array(0,1,2))
            ->where("artist.status", "=", 1)
            ->orderBy('products.id', 'desc')
            ->get();
        foreach ($products as $product) {

            $product_name = filter_var($product->product_name, FILTER_SANITIZE_STRING);

            $products_detail = Products::find($product->pid);

            $product_price = ProductPrices::select("*")
                ->where("product_id", "=", $product->pid)
                ->first();

            $pt_parent_id = ProductType::find($product_price->pt_parent_id);
            $pt_sub_id = ProductType::find($product_price->pt_sub_id);
            $generateSlugLastString = '';
            if(isset($pt_parent_id->type_name) && isset($pt_sub_id->type_name))
                $generateSlugLastString = \App\Traits\Definations::generateSlugLastString($pt_parent_id->type_name,$pt_sub_id->type_name);

            $product_slug = $product_name.' '.$generateSlugLastString;

            if($products_detail) {
                $products_detail->product_slug = $this->createSlug($product_slug);
                $products_detail->save();
            }
        }
    }

    public function add_product(Request $request){

        $parent_product_types = ProductType::select('*')
            ->where("status", 1)
            ->where('parent_id', '=',  0)
            ->get();

        $artists = Artist::select('*')
            ->wherein("status", array(1))
            ->get();

        $themes = ProductStyle::select('*')
            ->wherein("status", array(1))
            ->get();

        $tags = Tags::select('*')
            ->where("status", 1)
            ->get();

        $customizables = ProductCustomizable::select('*')
            ->where("status", 1)
            ->get();

        $badges = Badges::select('*')
            ->where("status", 1)
            ->get();

        $customers = Customer::select('*')
            ->where("status", 1)
            ->get();

        $countries = Countries::getCountries();

        return view('admin.products.add', compact('parent_product_types','artists','themes','customizables','tags','countries','badges','customers'));
    }

    public function product_submitted(Request $request){

            $data = $request->all();

            $validator = Validator::make($request->all(), [
                'product_name' => 'required',
                'product_sku' => ['required', new UniqueProductSKU],
                'parent_product_type' => 'required',
                'sub_product_type' => 'required',
                'artist_id' => 'required',
                //'feature_image' => 'required',
                'style_id' => 'required',
                //'country_id' => 'required',
                'design_type' => 'required',
                'price' => 'required|numeric',
                //'description' => 'required',
            ]);

            // Add validation for customer_id if badge is custom
            if (isset($data['badge']) && !empty($data['badge'])) {
                $badge = Badges::find($data['badge']);
                if($badge->custom > 0) {
                    $validator->addRules([
                        'customer_id' => 'required',
                    ]);
                }
            }

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()
                ]);
            }

            //Generate slug based on product attribute
            $parent_product_type = ProductType::find($request->parent_product_type);
            $sub_product_type = ProductType::find($request->sub_product_type);
            $generateSlugLastString = '';
            if(isset($parent_product_type->type_name) && isset($sub_product_type->type_name))
                $generateSlugLastString = \App\Traits\Definations::generateSlugLastString($parent_product_type->type_name,$sub_product_type->type_name);

            $product = new Products();
            $product_name = filter_var($request->product_name, FILTER_SANITIZE_STRING);
            $product->product_name = $product_name;
            $product_slug = $product_name.' '.$generateSlugLastString;
            $product->product_slug = $this->createSlug($product_slug);
            $product->product_sku = $request->product_sku;
            $product->artist_id = $request->artist_id;
            $product->style_id = $request->style_id;
            $product->product_customizable = $request->design_type ?? NULL;
            $product->product_description = $request->description ?? NULL;
            $product->country_id = $request->country_id ?? NULL;
            $product->state_id = $request->state_id ?? NULL;
            $product->p_badge = $request->badge ?? NULL;

            // When selected custom bedge then customer id will be saved in product table
            // This functionality is only working for Custom or private listing when needed
            $product->customer_id = 0;
            if(isset($request->customer_id) && $request->customer_id > 0 && !empty($request->customer_name)) {
                $product->customer_id = $request->customer_id;
            }

            $product->status = 1;
            $product->save();

            $product_id = $product->id;

            //-------------------------------------------------------------------------------------------

            if(isset($data['tag_ids']) AND !empty(rtrim($data['tag_ids'], ','))){
                    \Log::info('Tags before explode: '.$data['tag_ids']);
                    $tag_ids = explode(',', rtrim($data['tag_ids'], ','));
                    \Log::info('Tags after explode:', $tag_ids);
                    foreach ($tag_ids as $tag_id) {

                    $existingTag = Tags::where('id', $tag_id)
                        ->orWhereRaw('LOWER(tag_name) = ?', [strtolower($tag_id)])
                        ->first();

                    //\DB::enableQueryLog();
                    //\Log::debug(DB::getQueryLog());

                    if (!$existingTag) {
                        $newTag = new Tags();
                        $newTag->tag_name = $tag_id;
                        $newTag->save();
                        $tag_id = $newTag->id;
                        \Log::info('New Tag Id : '.$tag_id);
                    } else {
                        $tag_id = $existingTag->id;
                        \Log::info('Already Existing tag id : '.$tag_id);
                    }
                    $ProductsTag = new ProductsTag();
                    $ProductsTag->products_id = $product_id;
                    $ProductsTag->tags_id = $tag_id;
                    $ProductsTag->save();
                }
             }

            //-------------------------------------------------------------------------------------------

            if (isset($request->parent_product_type) and $request->parent_product_type > 0) {
                $productPrice = new ProductPrices();
                $productPrice->product_id = $product_id;
                $productPrice->pt_parent_id = $request->parent_product_type;
                $productPrice->pt_sub_id = $request->sub_product_type;
                $productPrice->price = $request->price;
                //$productPrice->msrp_price = $request->msrp_price;
                $productPrice->save();
            }

            Session::flash('success', "Product added successfully");

            return response()->json([
                'message' => 'Product created',
                'class_name' => 'alert alert-success',
                'status' => 'success',
                'product_id'=> $product_id,
                'redirect_url' =>  route('products-listing')
            ]);
    }

    function edit_product(Request $request)
    {
        try {
            $data = $request->all();
            $product_id = $request->id;
            //-----------------------------------------------------------------------------------------------

            $product = Products::query()
                ->where('id', '=', $product_id)
                ->first();

            //-------------------------------------------------------------------------------------------------

            $product_price = ProductPrices::select("*")
                ->where("product_id", "=", $product_id)
                ->first();
            $productTagIds = $product->tags->pluck('id');

            //-----------------------------------------------------------------------------------------------

            $tags = Tags::select('*')
                ->wherein("status", array(1))
                ->get();

            //-----------------------------------------------------------------------------------------------

            $parent_product_types = ProductType::select('*')
                ->wherein("status", array(0, 1))
                ->where('parent_id', '=', 0)
                ->get();

            $sub_types = Helper::get_sub_type_by_parent_id($product_price->pt_parent_id);

            //-----------------------------------------------------------------------------------------------

            $artists = Artist::select('*')
                ->wherein("status", array(0, 1))
                ->get();

            //-----------------------------------------------------------------------------------------------

            $themes = ProductStyle::select('*')
                ->wherein("status", array(0, 1))
                ->get();
            //-------------------------------------------------------------------------------------------------

            $customizables = ProductCustomizable::select('*')
                ->where("status", 1)
                ->get();

            //-------------------------------------------------------------------------------------------------

            $badges = Badges::select('*')
                ->where("status", 1)
                ->get();

            //-------------------------------------------------------------------------------------------------

            $countries = Countries::getCountries();
            $states = States::where('country_id', $product->country_id)->get();

            //------------------------------------------------------------------------------------------------

            $customers = Customer::select('*')
                ->where("status", 1)
                ->get();

            //------------------------------------------------------------------------------------------------

            $product_gallery = array();
            if($product->images->isNotEmpty()) {
                foreach ($product->images as $single_img) {
                    $product_gallery[] = [
                        'name' =>  $single_img->image_name,
                        'size' => null,
                        'type' => null,
                        'status' => null,
                        'id' => $single_img->id,
                        'url' => url('uploads/products/'.$single_img->image_name)
                    ];
                }
            }
            //------------------------------------------------------------------------------------------------


            return view('admin/products/edit', compact('product','product_price','parent_product_types','sub_types','artists','themes','tags','productTagIds','customizables','countries','states', 'product_gallery','badges','customers'));
        } catch (\Exception $exception) {
            return redirect(route('products-listing'))->withInput($request->all())->with('error', $exception->getMessage());
        }
    }

    public function edit_product_submitted(Request $request){
        $data = $request->all();
        $product_id = $request->product_id;
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'product_sku' => [
                'required',
                Rule::unique('products', 'product_sku')->where(function ($query) use ($product_id) {
                    $query->where('status', '!=', '2')->where('id', '!=', $product_id);
                }),
            ],
            'parent_product_type' => 'required',
            'sub_product_type' => 'required',
            'artist_id' => 'required',
            //'feature_image' => 'required',
            'style_id' => 'required',
            //'country_id' => 'required',
            'design_type' => 'required',
            'price' => 'required|numeric',
            //'description' => 'required',
        ]);

        // Add validation for customer_id if badge is custom
        if (isset($data['badge']) && !empty($data['badge'])) {
            $badge = Badges::find($data['badge']);
            if($badge->custom > 0) {
                $validator->addRules([
                    'customer_id' => 'required',
                ]);
            }
        }

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $product = Products::query()
            ->where('id', '=',  $product_id)
            ->first();
        $product_name = filter_var($request->product_name, FILTER_SANITIZE_STRING);
        $product->product_name = $product_name;
       // $product->product_slug =  Products::generateUniqueSlug($product_name,$product_id);
        $product->product_sku = $request->product_sku;
        $product->artist_id = $request->artist_id;
        $product->style_id = $request->style_id;
        $product->product_customizable = $request->design_type ?? NULL;
        $product->product_description = $request->description ?? NULL;
        $product->country_id = $request->country_id ?? NULL;
        $product->state_id = $request->state_id ?? NULL;
        $product->p_badge = $request->badge ?? NULL;

        // When selected custom bedge then customer id will be saved in product table
        // This functionality is only working for Custom or private listing when needed
        $product->customer_id = 0;
        if(isset($request->customer_id) && $request->customer_id > 0 && !empty($request->customer_name)) {
            $product->customer_id = $request->customer_id;
        }

        $product->updated_at = date('Y-m-d H:i:s');
        $product->save();


        //----------------------------------------------------------------------------------------------------------

        if(isset($data['tag_ids']) AND !empty(rtrim($data['tag_ids'], ','))){
            $tag_ids = explode(',', rtrim($data['tag_ids'], ','));
            ProductsTag::where('products_id', $product_id)->delete();
            foreach ($tag_ids as $tag_id) {
                $existingTag = Tags::where('id', $tag_id)
                    ->orWhereRaw('LOWER(tag_name) = ?', [strtolower($tag_id)])
                    ->first();
                if (!$existingTag) {
                    $newTag = new Tags();
                    $newTag->tag_name = $tag_id;
                    $newTag->save();
                    $tag_id = $newTag->id;
                } else {
                    $tag_id = $existingTag->id;
                }
                $ProductsTag = new ProductsTag();
                $ProductsTag->products_id = $product_id;
                $ProductsTag->tags_id = $tag_id;
                $ProductsTag->save();
            }
        }

        //----------------------------------------------------------------------------------------------------------

        if (isset($request->parent_product_type) and $request->parent_product_type > 0) {

            $productPrice = ProductPrices::select("*")
                ->where("product_id", "=", $product_id)
                ->first();

            $productPrice->product_id = $product_id;
            $productPrice->pt_parent_id = $request->parent_product_type;
            $productPrice->pt_sub_id = $request->sub_product_type ?? 0;
            $productPrice->price = $request->price;
            //$productPrice->msrp_price = $request->msrp_price;
            $productPrice->save();
        }

        //----------------------------------------------------------------------------------------------------------

        /*
        if($files=$request->file('product_gallery')) {
            $i = 0;
            foreach ($files as $image_file) {
                $file_name = "product-" . time() . $i . "." . $image_file->getClientOriginalExtension();
                $image_file->move('uploads/products', $file_name);
                $product_image = new ProductImages();
                $product_image->image_name = $file_name;
                $product_image->product_id = $product_id;
                $product_image->save();
                $i++;
            }
        } */

        if($request->sort_gallery) {
            $sort_gallery = json_decode($request->sort_gallery, true);
            foreach($sort_gallery as $sort_image) {
                $final_sort_gallery[$sort_image['id']] = $sort_image['name'];
            }
           // print_r($final_sort_gallery);exit;
            $sorting = 1;
            $firstImage2 = true;
            if(count($final_sort_gallery) > 0) {
                foreach($final_sort_gallery as $final_sort_image) {
                    $product_image = ProductImages::query()
                        ->where('image_name', '=', $final_sort_image)
                        ->first();
                    $product_image->sorting = $sorting;
                    $product_image->save();

                    if($firstImage2) {
                        $product_update = Products::query()
                            ->where('id', '=', $request->product_id)
                            ->first();
                        $product_update->feature_image = $final_sort_image;
                        $product_update->save();
                       // echo  $request->product_id.'-------';
                       // echo $final_sort_image;
                       // print_r($product_update);
                        $firstImage2 = false; // Update the variable to false after the first image
                    }
                    $sorting++;
                }
            }

        }

       // exit;
        //----------------------------------------------------------------------------------------------------------
        Session::flash('success', "Product updated successfully");
        return response()->json([
            'message' => 'Product Updated',
            'class_name' => 'alert alert-success',
            'status' => 'success',
            'product_id'=> $product_id,
            'redirect_url' =>  route('products-listing')
        ]);

    }

    function change_product_status(Request $request)
    {
        $data = $request->all();
        $id = base64_decode($request->id);
        $sid = explode(":", $id)[0];
        $status = explode(":", $id)[1];
        $message = '';
        if($status == 0 || $status == 1) {
            $products = Products::query()
                ->select("id", "status")
                ->where("id", "=", $sid)
                ->first();
            $products->status = $status;
            $products->save();
            $message =  "Product status changed successfully";
        }

        if($status == 2) {
            //$product = Products::find($sid);
           // $product->delete();

            $product = Products::find($sid);
            $isInCartOrOrder = $product->carts()->exists() || $product->orderItems()->exists();

            if ($isInCartOrOrder) {
                $product->status = 2;
                $product->save();
            } else {
                $product->delete();
            }

            $message =  "Product deleted successfully";
        }

        return redirect(route('products-listing'))->with('success', $message);
    }

    function customer_autocomplete(Request $request)
    {
        $query = $request->input('query');

        // Adjust the query to select both ID and name
        $customers = Customer::select('id','first_name','last_name','email','company')
            ->where('first_name', 'like', '%' . $query . '%')
            ->orwhere('last_name', 'like', '%' . $query . '%')
            ->orwhere('company', 'like', '%' . $query . '%')
            //->orwhere('customer_display_name', 'like', '%' . $query . '%')
            ->get();

        // Prepare data array to return
        $data = [];
        if($customers) {
            foreach ($customers as $customer) {
                $data[] = [
                    'id' => $customer->id,
                    'first_name' => $customer->first_name,
                    'last_name' => $customer->last_name,
                    'email' => $customer->email,
                    'company' => $customer->company,
                    //'customer_display_name' => $customer->customer_display_name,
                ];
            }
        }
        return response()->json($data);
    }

    public function get_autocomplete_product_tag(Request $request)
    {
        $data = $request->all();
        if(isset($data['tag']) AND strlen($data['tag']) > 2) {
            $tags = Tags::select('id', 'tag_name as name')
                ->where('status', 1)
                ->where('tag_name', 'LIKE', '%' . $data['tag'] . '%')
                ->limit(20)
                ->get();
            return response()->json($tags);
        }
    }

    public function customizer_processing_time(Request $request){
        try {

            $pagination = optional(View::shared('site_management'))->backend_pagination_listing ?? 50;
            $products_qry = CustomizerProcessingTime::select('customizer_processing_time.*')
                ->leftJoin('customers', 'customizer_processing_time.customer_id', '=', 'customers.id')
                ->orderBy('customizer_processing_time.id', 'DESC');
            $processing_times = $products_qry->paginate(10);

            return view('admin.products.customizer_processing_time', compact('processing_times'));

        } catch (\Exception $exception) {
            return redirect(route("products"))->with("error", $exception->getMessage());
        }
    }

    //------------------------------------ Mass upload -------------------------------------------

    public function store_product_gallery(Request $request)
    {

        if($files=$request->file('product_gallery')) {
            $final_sort_gallery = [];
            if($request->sort_gallery) {
                $sort_gallery = json_decode($request->sort_gallery, true);
               foreach($sort_gallery as $sort_image) {
                   $final_sort_gallery[$sort_image['id']] = $sort_image['name'];
               }
            }


            $i = 0;
            $firstImage = true;
            foreach ($files as $image_file) {
                $destinationPath =  base_path('uploads/products/');
                $file_name = "product-" . time() . $i . "." . $image_file->getClientOriginalExtension();
                $image_size = array(
                    'small' => array(
                        'width' => 128,
                        'height' => 128,
                    ),
                    'medium' => array(
                        'width' => 318,
                        'height' => 318,
                    ),
                    'large' => array(
                        'width' => 700,
                        'height' => 700,
                    ),
                );
                Helper::uploadTempImageWithSize($destinationPath, $image_file, $file_name, $image_size);

                $product_image = new ProductImages();
                $product_image->image_name = $file_name;
                $product_image->product_id = $request->product_id;
                if($request->add_gallery)
                    $product_image->sorting = $i;

               if($request->edit_gallery) {
                   $product_image->sorting = ProductImages::where('product_id', '=', $request->product_id)->max('sorting') + 1;
               }

                $product_image->save();

                // Set the first uploaded image as default
                if ($firstImage && $request->add_gallery) {
                    $product = Products::query()
                        ->where('id', '=', $request->product_id)
                        ->first();
                    $product->feature_image = $file_name;
                    $product->save();
                    $firstImage = false; // Update the variable to false after the first image
                }

                if(count($final_sort_gallery) > 0) {
                    $originalFileName = $image_file->getClientOriginalName();
                    $image_key = array_search($originalFileName, $final_sort_gallery);
                    $final_sort_gallery[$image_key] = $file_name;
                   // echo $file_name." aaaaaaaaaaaa";
                }

                $i++;
            }

            // final sorting images
            $sorting = 1;
            $firstImage2 = true;
           // $final_sort_gallery = [];
            if(count($final_sort_gallery) > 0) {
                foreach($final_sort_gallery as $final_sort_image) {
                   // echo $final_sort_image.' aaaaaaa <br>';
                    $product_image = ProductImages::query()
                        ->where('image_name', '=', $final_sort_image)
                        ->first();
                    $product_image->sorting = $sorting;
                    $product_image->save();

                    if($firstImage2) {
                        $product = Products::query()
                            ->where('id', '=', $request->product_id)
                            ->first();
                        $product->feature_image = $final_sort_image;
                        $product->save();
                        $firstImage2 = false; // Update the variable to false after the first image
                    }
                    $sorting++;
                }
            }

            if(isset($request->update)) {
                Session::flash('success', "Product updated successfully");
            } else {
                Session::flash('success', "Product added successfully");
            }
            return response()->json(['status' => "success" ,'redirect_url' =>  route('products-listing')]);
        }
    }

    public function delete_product_image(Request $request)
    {
        $id = $request->id;
       // echo $id;exit;
        $productsImage = ProductImages::query()
            ->where("id", "=", $id)
            ->first();
        //echo "<pre>";print_r($productsImage);exit;
        if ($productsImage) {
            Storage::disk('uploads')->delete("products/{$productsImage->feature_image}");

            $productsImage->delete();

            $product = Products::query()
                ->where('id', '=', $productsImage->product_id)
                ->first();
            if($product->feature_image == $productsImage->image_name) {
                $first_image =  ProductImages::query()
                    ->where("product_id", "=", $productsImage->product_id)
                    ->orderBy('sorting', 'asc')
                    ->first();
                $product->feature_image = $first_image->image_name;
                $product->save();
            }


            return response()->json([
                'status' => 'success',
            ]);
        }
    }

    public function product_mass_upload(Request $request){

        $parent_product_types = ProductType::select('*')
            ->wherein("status", array(1))
            ->where('parent_id', '=',  0)
            ->get();

        $artists = Artist::select('*')
            ->wherein("status", array(1))
            ->get();

        $themes = ProductStyle::select('*')
            ->wherein("status", array(1))
            ->get();

        $tags = Tags::select('*')
            ->where("status", 1)
            ->get();

        $customizables = ProductCustomizable::select('*')
            ->where("status", 1)
            ->get();

        $badges = Badges::select('*')
            ->where("status", 1)
            ->get();

        $customers = Customer::select('*')
            ->where("status", 1)
            ->get();


        $countries = Countries::getCountries();

        return view('admin.products.mass-upload', compact('parent_product_types','artists','themes','customizables','tags','countries','badges','customers'));
    }

    public function mass_upload_save(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                //'mass_upload' => 'required',
                'parent_product_type' => 'required',
                'sub_product_type' => 'required',
                'artist_id' => 'required',
                'style_id' => 'required',
                'product_customizable' => 'required',
                'price' => 'required|numeric',
               // 'description' => 'required',
            ]);

            // Add validation for customer_id if badge is custom
            if (isset($data['badge']) && !empty($data['badge'])) {
                $badge = Badges::find($data['badge']);
                if($badge->custom > 0) {
                    $validator->addRules([
                        'customer_id' => 'required',
                    ]);
                }
            }

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()
                ]);

            }

            if ($files = $request->file('mass_upload')) {
                TempProducts::query()->where('type', '=', 1)->delete();
                $del_folderPath = base_path('uploads/temp_products/');
                $del_files = \File::glob($del_folderPath . '/*');
                foreach ($del_files as $del_file) {
                   \File::delete($del_file);
                }

                $imageArray = [];
                $commonImages = [];
                $omitted_images = [];
                $omitted_images_name_arr = [];
                foreach($files as $file) {
                    $file_full_name  = $file->getClientOriginalName();
                    $imageName = pathinfo($file_full_name,PATHINFO_FILENAME);
                    $image_name_arr = explode('_', $imageName);
                    //print_r($image_name_arr);exit;
                    if (strpos($imageName, '_img') !== false) {
                        //echo "Additional :  ".$imageName."<br>";
                        $imageArray[$image_name_arr[2]]['additional'][] = $file;
                        //print_r($imageArray);
                    } elseif (strpos($imageName, '_back') !== false) {
                       // echo "Back :  ".$imageName."<br>";
                        $imageArray[$image_name_arr[2]]['back'][] = $file;
                        //print_r($imageArray);
                    } elseif (strpos($imageName, '_common') !== false) {
                        //echo "Common :   ".$imageName."<br>";
                        $commonImages[] = $file;
                        //print_r($commonImages);
                    } else {
                       // echo "Feature :   ".$imageName."<br>";
                        if(isset($image_name_arr[2]) && !empty($image_name_arr[2])) {
                            $imageArray[$image_name_arr[2]]['feature'][] = $file;
                        } else {
                            $omitted_images[] = $file;
                        }
                        //print_r($imageArray);
                    }

                }

                if(count($omitted_images) > 0) {
                    foreach ($omitted_images as $omitted_image) {
                        $omitted_images_name_arr[] = '<p>'.$omitted_image->getClientOriginalName().'</p>';
                    }
                    return response()->json(array('improper' => true, 'improper_name_html' => $omitted_images_name_arr));
                }

                // Assign common images to all SKUs
                foreach ($imageArray as &$skuImages) {
                    if (empty($skuImages['common']) && count($commonImages) > 0) {
                        $skuImages['common'] = $commonImages;
                    }
                }

                //echo "<pre>";print_r($imageArray);exit;

                foreach ($imageArray as $sku => $imageData) {
                    $product_id = 0;
                    $i = 1;
                    if(isset($imageData['feature'][0])) {

                        $file_full_name  = $imageData['feature'][0]->getClientOriginalName();
                        $imageName = pathinfo($file_full_name,PATHINFO_FILENAME);
                        $image_name_arr = explode('_', $imageName);
                        $product = new TempProducts();
                        $product->product_name =  $image_name_arr[1];
                        $product->product_sku =  $image_name_arr[2];
                        $product->artist_id = $request->artist_id;

                        // When selected custom bedge then customer id will be saved in product table
                        // This functionality is only working for Custom or private listing when needed
                        $product->customer_id = 0;
                        if(isset($request->customer_id) && $request->customer_id > 0 && !empty($request->customer_name)) {
                            $product->customer_id = $request->customer_id;
                        }

                        $product->style_id = $request->style_id;
                        $product->product_customizable = $request->product_customizable ?? NULL;
                        $product->product_description = $request->description ?? null;
                        $product->pt_parent_id = $request->parent_product_type;
                        $product->pt_sub_id = $request->sub_product_type;
                        $product->price = $request->price;
                        $product->country_id = $request->country_id;

                        if(isset($request->state_id) AND $request->state_id > 0 AND $request->state_id != null)
                            $product->state_id = $request->state_id;
                        else
                            $product->state_id = NULL;

                        $product->p_badge = $request->badge ?? NULL;
                        $product->minimum_order_quantity = $request->minimum_order_quantity ?? 1;
                        $product->case_pack = $request->case_pack ?? 1;
                        $product->tags = $request->tag_ids ?? NULL;
                        $product->status = 1;

                        if(isset($image_name_arr[2]) && !empty($image_name_arr[2])) {
                            /* $already_sku = Products::query()
                                ->where('product_sku', '=', $image_name_arr[2])
                                ->first(); */

                            $already_sku = DB::table('products')
                                ->where('product_sku', $image_name_arr[2])
                                ->where('status', '!=', '2')
                                ->first();

                            if($already_sku) {
                                $product->status = 2;
                            }
                        }

                        $product->type = 1;
                        $product->save();
                        $product_id = $product->id;
                        $product_name = $product->product_name;
                    }
                    //echo "<pre>";print_r($imageData);exit;
                    if($product_id > 0) {
                        foreach ($imageData as $type => $images) {
                            foreach ($images as $image) {
                                $filter_name = Helper::filter_filename($product_name);
                                $file_name = $filter_name.'-'.time().$i.rand().".".$image->getClientOriginalExtension();
                                $file_full_name  = $image->getClientOriginalName();
                                $destinationPath = base_path('uploads/temp_products/');
                                //echo " Generated : ".$file_name."--------- Product id : ".$product_id."-------------- Org : ".$file_full_name."<br>";
                                $image_size = array(
                                    'small' => array(
                                        'width' => 128,
                                        'height' => 128,
                                    ),
                                    'medium' => array(
                                        'width' => 318,
                                        'height' => 318,
                                    ),
                                    'large' => array(
                                        'width' => 700,
                                        'height' => 700,
                                    ),
                                );
                                Helper::uploadTempImageWithSize($destinationPath, $image, $file_name, $image_size);

                                $product_image = new TempProductImages();
                                $product_image->image_name = $file_name;
                                $product_image->temp_product_id = $product_id;
                                $product_image->sorting = $i;
                                $product_image->save();

                                if(isset($type) AND $type == "feature") {
                                    $product = TempProducts::query()
                                        ->where('id', '=', $product_id)
                                        ->first();
                                    $product->feature_image = $file_name;
                                    $product->fetaure_image_orginal_name = $file_full_name;
                                    $product->save();
                                }
                                $i++;
                            }
                        }
                    }
                }
                $data['fail_products'] = TempProducts::select('*')->where('status', '=', 2)->where('type', '=', 1)->orderBy('id', 'desc')->get();
                $data['products'] = TempProducts::select('*')->where('status', '=', 1)->where('type', '=', 1)->orderBy('id', 'desc')->get();
                $returnHTML = view('admin/products/preview-mass-upload',$data)->render();
                return response()->json(array('success' => true, 'html' => $returnHTML));
            }

        } catch (\Exception $e) {
            // Handle the exception here, you can log it or return an error response.
            return response()->json(['catch_error' => $e->getMessage()]);
        }
    }

    public function sortable_mass_upload_images(Request $request)
    {
        $data = $request->all();
        if(isset($data['sortedItems']) && count($data['sortedItems']) > 0) {
            foreach($data['sortedItems'] as $key => $sorted_item_id) {
                $tempProductImages = TempProductImages::query()
                    ->where('id', '=', $sorted_item_id)
                    ->first();
                if($tempProductImages) {
                    $tempProductImages->sorting = $key;
                    $tempProductImages->save();
                }
            }
        }
    }

    public function create_product_from_mass_upload(Request $request){

        $data = $request->all();
        //print_r($data);exit;
        $temp_products = TempProducts::select('*')->where('type', '=', 1)->orderBy('id', 'desc')->get();
        $totalRecords = 0;
        if($temp_products) {
            $tag_ids_str = $data['tag_ids'] ?? '';
            $product_names_arr = $data['product_names'] ?? '';
            $totalRecords = $temp_products->count();
            foreach($temp_products as $temp_product) {
                //$product_already_exist = Products::query()->where('product_sku', $temp_product->product_sku)->exists();
                $product_already_exist = DB::table('products')
                    ->where('product_sku', $temp_product->product_sku)
                    ->where('status', '!=', '2')
                    ->doesntExist();
                if ($product_already_exist) {
                    $product = new Products();
                    $product_name = (
                        isset($product_names_arr[$temp_product->product_sku]) &&
                        !empty($product_names_arr[$temp_product->product_sku])
                    ) ? $product_names_arr[$temp_product->product_sku] : $temp_product->product_name ?? null;


                    // Append product type with product slug at last
                    $parent_product_type = ProductType::find($temp_product->pt_parent_id);
                    $sub_product_type = ProductType::find($temp_product->pt_sub_id);
                    $generateSlugLastString = '';
                    if(isset($parent_product_type->type_name) && isset($sub_product_type->type_name))
                        $generateSlugLastString = \App\Traits\Definations::generateSlugLastString($parent_product_type->type_name,$sub_product_type->type_name);

                    $product_name = filter_var($product_name, FILTER_SANITIZE_STRING);
                    $product_slug = $product_name.' '.$generateSlugLastString;
                    $product->product_name = $product_name;
                    $product->product_slug = $this->createSlug($product_slug);
                    $product->product_sku = $temp_product->product_sku;
                    $product->artist_id = $temp_product->artist_id;
                    // When selected custom bedge then customer id will be saved in product table
                    // This functionality is only working for Custom or private listing when needed
                    if(isset($temp_product->customer_id) && $temp_product->customer_id > 0) {
                        $product->customer_id = $temp_product->customer_id;
                    }
                    $product->style_id = $temp_product->style_id;
                    $product->product_customizable = $temp_product->product_customizable ?? NULL;
                    $product->product_description = $temp_product->product_description ?? NULL;
                    $product->feature_image = $temp_product->feature_image ?? NULL;
                    $product->country_id = $temp_product->country_id ?? NULL;
                    $product->state_id = $temp_product->state_id ?? NULL;
                    $product->p_badge = $temp_product->p_badge ?? NULL;
                    //$product->minimum_order_quantity = $temp_product->minimum_order_quantity ?? 1;
                    //$product->case_pack = $temp_product->case_pack ?? 1;
                    $product->status = 1;
                    $product->save();

                    $product_id = $product->id;

                    //-------------------------------------------------------------------------------------------

                    if (isset($tag_ids_str[$temp_product->product_sku]) and !empty(rtrim($tag_ids_str[$temp_product->product_sku], ','))) {
                        \Log::info('Tags before explode: '.$tag_ids_str[$temp_product->product_sku]);
                        $tag_ids = explode(',', rtrim($tag_ids_str[$temp_product->product_sku], ','));
                        \Log::info('Tags after explode:', $tag_ids);
                        foreach ($tag_ids as $tag_id) {

                            $existingTag = Tags::where('id', $tag_id)
                                ->orWhereRaw('LOWER(tag_name) = ?', [strtolower($tag_id)])
                                ->first();

                            //\DB::enableQueryLog();
                            //\Log::debug(DB::getQueryLog());

                            if (!$existingTag) {
                                $newTag = new Tags();
                                $newTag->tag_name = $tag_id;
                                $newTag->save();
                                $tag_id = $newTag->id;
                                \Log::info('New Tag Id : '.$tag_id);
                            } else {
                                $tag_id = $existingTag->id;
                                \Log::info('Already Existing tag id : '.$tag_id);
                            }
                            $ProductsTag = new ProductsTag();
                            $ProductsTag->products_id = $product_id;
                            $ProductsTag->tags_id = $tag_id;
                            $ProductsTag->save();
                        }
                    }

                    //-------------------------------------------------------------------------------------------

                        if (isset($temp_product->pt_parent_id) and $temp_product->pt_parent_id > 0) {
                            $productPrice = new ProductPrices();
                            $productPrice->product_id = $product_id;
                            $productPrice->pt_parent_id = $temp_product->pt_parent_id;
                            $productPrice->pt_sub_id = $temp_product->pt_sub_id;
                            $productPrice->price = $temp_product->price;
                            $productPrice->save();
                        }

                        if($temp_product->images) {
                            foreach ($temp_product->images as $gallery_image) {
                                $product_image = new ProductImages();
                                $product_image->image_name = $gallery_image->image_name;
                                $product_image->product_id = $product_id;
                                $product_image->sorting = $gallery_image->sorting;
                                $product_image->save();
                            }
                        }
                    }
                }

                // Copy images from temprory product table to real product folder

                $sourcePath = base_path('uploads/temp_products/');
                $destinationPath = base_path('uploads/products/');

                $files = \File::allFiles($sourcePath);

                \Log::info('Number of files: ' . count($files));

               // foreach ($files as $file) {
                   // $fileName = $file->getFilename();
                   // \Log::info('Copying file: ' . $fileName);
                   // \File::copy($sourcePath . '/' . $fileName, $destinationPath . '/' . $fileName);
               // }

               \Log::info('Copying file ',$files);
               \File::copyDirectory($sourcePath, $destinationPath);

                // Delete images and data from database because this is temprory

                TempProducts::query()->where('type', '=', 1)->delete();
                $del_folderPath = base_path('uploads/temp_products/');
                $del_files = \File::glob($del_folderPath . '/*');
                foreach ($del_files as $del_file) {
                    \File::delete($del_file);
                }
                Session::flash('success', $totalRecords.' new products have been created.');
                return response()->json([
                    'message' => $totalRecords.' mass product has been created',
                    'class_name' => 'alert alert-success',
                    'status' => 'success',
                    'redirect_url' =>  route('products-listing')
                ]);

            }

            return response()->json([
                'message' => 'No record found',
                'class_name' => 'alert alert-error',
                'status' => 'error'
            ]);
    }

    //--------------------------------------------------------------------------------------------

    public function tag_listing(Request $request){
        try {

            $data = $request->all();
            $filter_flag = false;
            $pagination = optional(View::shared('site_management'))->backend_pagination_listing ?? 50;
            $tags = Tags::select('*')
                ->whereIn('status', [0, 1])
                ->when(isset($data['search_by']), function ($query) use ($data, &$filter_flag) {
                    $filter_flag = true;
                    return $query->where('tag_name', 'LIKE', '%' . $data['search_by'] . '%');
                })
                ->orderBy('id', 'desc')
                ->paginate($pagination);

            return view('admin.product-tags.listing', compact('tags','filter_flag'));

        } catch (\Exception $exception) {
            return redirect(route("tags"))->with("error", $exception->getMessage());
        }
    }

    public function add_tag(Request $request){

        return view('admin.product-tags.add');
    }

    public function add_tag_submitted(Request $request){
        if($request->IsMethod("post")){
            $data = $request->all();
           // echo "<pre>";
           // print_r($data);exit;
            $validated = $request->validate([
                'tag_name' => 'required',
            ]);


            $tag = new Tags();
            $tag->tag_name = $request->tag_name;
            $tag->status = 1;
            $tag->save();
            $tag_id = $tag->id;
            if(isset($data['synonyms']) AND !empty($data['synonyms'])) {
                $synonyms = explode(',', $data['synonyms']);
                foreach($synonyms as $synonym) {
                    $tagSynonym = new TagSynonyms();
                    $tagSynonym->tag_id = $tag_id;
                    $tagSynonym->synonym = $synonym;
                    $tagSynonym->save();
                }
            }

            return redirect(route('tags'))->with('success', "Tag Added");
        }
    }

    public function edit_tag(Request $request)
    {
        try {
            $data = $request->all();
            $tag_id = $request->id;
            //-----------------------------------------------------------------------------------------------

            $tag = Tags::query()
                ->where('id', '=',  $tag_id)
                ->first();

            $synonym = $tag->synonyms->pluck('synonym');
            //echo "<pre>";print_r($synonym);exit;

            //------------------------------------------------------------------------------------------------

            return view('admin/product-tags/edit', compact('tag','synonym'));
        } catch (\Exception $exception) {
            return redirect(route('tags'))->withInput($request->all())->with('error', $exception->getMessage());
        }
    }

    public function edit_tag_submitted(Request $request){
        if($request->IsMethod("post")){
            $data = $request->all();
            $tag_id = $request->tag_id;

            $validated = $request->validate([
                'tag_name' => 'required'
            ]);

            $tag = Tags::query()
                ->where('id', '=',  $tag_id)
                ->first();
            //print_r($data);exit;
            $tag->tag_name = $data['tag_name'];
            $tag->save();


            if(isset($data['synonyms']) AND !empty($data['synonyms'])) {
                TagSynonyms::where('tag_id', $tag_id)->delete();
                $synonyms = explode(',', $data['synonyms']);
                foreach($synonyms as $synonym) {
                    $tagSynonym = new TagSynonyms();
                    $tagSynonym->tag_id = $tag_id;
                    $tagSynonym->synonym = $synonym;
                    $tagSynonym->save();
                }
            }


            return redirect(route('tags'))->with('success', "Tag updated");
        }
    }

    public function change_tag_status(Request $request)
    {
        $data = $request->all();
        $id = base64_decode($request->id);
        $sid = explode(":", $id)[0];
        $status = explode(":", $id)[1];
        $message = '';

        if($status == 0 || $status == 1) {
            $tag = Tags::query()
                ->select("id", "status")
                ->where("id", "=", $sid)
                ->first();
            $tag->status = $status;
            $tag->save();
            $message =  "Tag status changed successfully";
        }

        if($status == 2) {
            $tag = Tags::find($sid);
            $tag->status = $status;
            $tag->save();
            $message =  "Tag deleted successfully";
        }

        return redirect(route('tags'))->with('success', $message);
    }

    public function bulk_tag_manager(Request $request){

        $artists = Artist::select('*')
            ->wherein("status", array(1))
            ->get();

        $tags = Tags::select('*')
            ->where("status", 1)
            ->get();
        return view('admin.product-tags.bulk-tag-manager', compact('artists','tags'));
    }

    public function bulk_tag_manager_submitted(Request $request){

        $query = $request->get('query', '');  // The search query
        $selectedProductIds = $request->get('selected_products', '');  // Get selected products (empty string if not provided)
        $artistId = $request->get('artist_id');  // Get artist_id from the request
        $tag_ids = $request->get('tag_ids');

        // Initialize the query
        $productsQuery = DB::table('products')
            ->select('product_name', 'product_sku', 'id');

        // If selected_products is provided, filter by those product IDs
        if (!empty($selectedProductIds)) {
            $selectedProductIds = explode(',', $selectedProductIds);  // Convert to array if it isn't empty
            $productsQuery->whereIn('id', $selectedProductIds);
        }

        // If artist_id is provided, filter by artist_id
        if ($artistId) {
            $productsQuery->where('artist_id', $artistId);
        }

        // Execute the query and get the results
        $products = $productsQuery->get();
        if($products) {
            $tag_ids = explode(',', rtrim($tag_ids, ','));
            foreach ($tag_ids as $tag_id) {

                $existingTag = Tags::where('id', $tag_id)
                    ->orWhereRaw('LOWER(tag_name) = ?', [strtolower($tag_id)])
                    ->first();
                if (!$existingTag) {
                    $newTag = new Tags();
                    $newTag->tag_name = $tag_id;
                    $newTag->save();
                    $tag_id = $newTag->id;
                } else {
                    $tag_id = $existingTag->id;
                }

                foreach($products as $product) {
                    $existingRecord = ProductsTag::where('products_id', $product->id)
                        ->where('tags_id', $tag_id)
                        ->exists();
                    if (!$existingRecord) {
                        $ProductsTag = new ProductsTag();
                        $ProductsTag->products_id = $product->id;
                        $ProductsTag->tags_id = $tag_id;
                        $ProductsTag->save();
                    }
                }
            }
        }

        return redirect(route('tags'))->with('success', "Tags updated for products");

    }

    public function get_products_by_autocomplete(Request $request)
    {
        $query = $request->get('query', '');
        $selectedProductIds = $request->get('selected_product_ids', []);   // Get the selected SKUs from the request

        // Only proceed if there's a query to search
        if ($query) {
            // Fetch products from the database where name or sku matches the query
            $products = DB::table('products')
                ->select('product_name', 'product_sku', 'id')
                ->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('product_name', 'like', "%{$query}%")
                        ->orWhere('product_sku', 'like', "%{$query}%");
                });

            // Filter out the products that have already been selected (from the selected SKUs)
            if (!empty($selectedProductIds)) {
                $products = $products->whereNotIn('id', $selectedProductIds);  // Exclude selected products
            }

            $products = $products->limit(15)  // Limit the number of results for performance
            ->get();

            // Prepare the result in the correct format for jQuery UI autocomplete
            $result = $products->map(function ($product) {
                return [
                    'label' => "{$product->product_name}({$product->product_sku})",  // Display product name and SKU
                    'value' => $product->product_sku,
                    'product_id' => $product->id,
                ];
            });
        } else {
            $result = [];
        }

        return response()->json([
            'result' => $result,
            'message' => "Product search completed successfully."
        ]);
    }

    public function delete_bluk_product(Request $request)
    {
        $ids = $request->ids;
        //Products::whereIn('id',explode(",",$ids))->delete();
        Products::whereIn('id',explode(",",$ids))->update(['status' => 2]);
        return response()->json(['status'=>true,'message'=>"Product successfully removed."]);
    }

    public function get_search_tag_listing(Request $request){

        $pagination = optional(View::shared('site_management'))->backend_pagination_listing ?? 50;

        $isContactFilter = request()->query('is_contact');


        $all_tags = SearchTags::count();

        $to_be_contacted = SearchTags::where('is_contact', '=', 1)->count();
        $contacted = SearchTags::where('is_contact', '=', 2)->count();
        $just_not_found = SearchTags::where('is_contact', '=', 0)->count();


        $query = SearchTags::select('search_tags.*', 'customers.id as customer_id')
            ->leftJoin('customers', 'search_tags.email', '=', 'customers.email')
            ->whereIn('search_tags.status', [0, 1])
            ->orderBy('search_tags.id', 'desc');


        if ($isContactFilter !== null) {
            $query->where('is_contact', $isContactFilter);
        }


        $searchTags = $query->paginate($pagination);
        $searchTags->appends(request()->query());

        return view('admin.product-tags.search-tag-listing', compact('searchTags','all_tags','to_be_contacted','contacted','just_not_found'));
    }

    function change_search_tag_status(Request $request)
    {
        $data = $request->all();
        if (isset($data['stid']) AND $data['stid'] > 0)
        {
            $searchTags = SearchTags::query()
                ->where("id", "=", $data['stid'])
                ->first();
            $searchTags->is_contact = $data['is_contacted'];
            $searchTags->save();

            $to_be_contacted = SearchTags::where('is_contact', '=', 1)->count();
            $contacted = SearchTags::where('is_contact', '=', 2)->count();

            return response()->json(['status'=>true,'to_be_contacted'=>$to_be_contacted,'contacted'=>$contacted]);
        }
        $id = base64_decode($request->id);
        $sid = explode(":", $id)[0];
        $status = explode(":", $id)[1];

        $searchTags = SearchTags::query()
            ->select("id", "status")
            ->where("id", "=", $sid)
            ->first();
        $searchTags->status = $status;
        $searchTags->save();
        return redirect(route('get-search-tag-listing'))->with('success', "Status Changed");

    }

    //------------------------------------------------------------------------------------------------------------------

    public function get_sub_product_type_by_id(Request $request)
    {
        $parentId = $request->input('parent_id');
        $subProductTypes = ProductType::where('parent_id', $parentId)->where("status", 1)->get();
        return response()->json($subProductTypes);
    }

    //------------------------------------------------------------------------------------------------------------------

    public function get_case_pack_by_types(Request $request)
    {
        $type_id = $request->input('type_id');
        $subProductTypes = ProductType::where('id', $type_id)->first();
        return response()->json($subProductTypes);
    }
    //------------------------------------------------------------------------------------------------------------------


    public function get_minimum_order_quantity_by_design(Request $request)
    {
        $type_id = $request->input('type_id');
        $customizable_id = $request->input('customizable_id');
        $customizable_type_relation = CustomizableTypeRelation::where('product_customizable_id', $customizable_id)->where('product_type_id', $type_id)->first();
        return response()->json($customizable_type_relation);
    }

    //------------------------------------------------------------------------------------------------------------------

    public function get_state_by_country_id(Request $request)
    {
        $country_id = $request->input('country_id');
        $states = States::where('country_id', $country_id)->where('status', 1)->get();
        return response()->json($states);
    }

    //------------------------------------------------------------------------------------------------------------------

    public function product_badges_listing(Request $request){
        $pagination = optional(View::shared('site_management'))->backend_pagination_listing ?? 50;
        $badges = Badges::select('*')
            ->wherein("status", array(0, 1))
            ->orderBy('id', 'desc')
            ->paginate($pagination);
        return view('admin.product-badges.listing', compact('badges'));
    }

    public function add_badge(Request $request){
        return view('admin.product-badges.add');
    }

    public function add_badge_submitted(Request $request){
        if($request->IsMethod("post")){
            $validated = $request->validate([
                'badge' => 'required',
                'color' => 'required',
            ]);

            $badge = new Badges();
            $badge->badge = $request->badge;
            $badge->color = $request->color;
            $badge->save();
            return redirect(route('product-badges'))->with('success', "Badge Added");
        }
    }

    function edit_badge(Request $request)
    {
        try {
            $data = $request->all();
            $id = $request->id;
            $badge = Badges::query()
                ->where('id', '=',  $id)
                ->first();
            return view('admin/product-badges/edit', compact('badge'));
        } catch (\Exception $exception) {
            return redirect(route('product-badges'))->withInput($request->all())->with('error', $exception->getMessage());
        }
    }

    public function edit_badge_submitted(Request $request){
        if($request->IsMethod("post")){
            $validated = $request->validate([
                'badge' => 'required',
                'color' => 'required',
            ]);

            $id = $request->id;
            $badge = Badges::query()
                ->where('id', '=',  $id)
                ->first();

            $badge->badge = $request->badge;
            $badge->color = $request->color;
            $badge->save();
            return redirect(route('product-badges'))->with('success', "Badge updated");
        }
    }

    function change_badge_status(Request $request)
    {
        $data = $request->all();
        $id = base64_decode($request->id);
        $sid = explode(":", $id)[0];
        $status = explode(":", $id)[1];

        $badge = Badges::query()
            ->select("id", "status")
            ->where("id", "=", $sid)
            ->first();
        $badge->status = $status;
        $badge->save();
        return redirect(route('product-badges'))->with('success', "Status Changed");

    }

    //-----------------------------------------------------Export Product ----------------------------------------------

    public function export_product()
    {
        return Excel::download(new ProductExportExcel, 'exported_data.xlsx');
    }

    public function createSlug($title, $id = 0)
    {
        // Normalize the title
        $slug = Str::slug($title, '-');

        // Fetch all related slugs
        $allSlugs = Products::select('product_slug')
            ->where('product_slug', 'LIKE', "$slug%")
            ->where('id', '<>', $id)
            //->where('status', '!=', 2)
            ->pluck('product_slug');

        // If we haven't used it before then we are all good
        if (!$allSlugs->contains($slug)) {
            return $slug;
        }

        // Create a new slug by appending a number until we find an unused one
        $i = 1;
        while (true) {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains($newSlug)) {
                return $newSlug;
            }
            $i++;
        }

        throw new \Exception('Cannot create a unique slug');
    }

    public function generate_pdf_customizer_product(Request $request)
    {
        $data = $request->all();
        $product = Products::find($data['id']);
        $product_type = DB::table('product_type')
            ->join('product_prices', 'product_type.id', '=', 'product_prices.pt_sub_id')
            ->where('product_prices.product_id', $data['id'])
            ->select('product_type.*') // Select desired columns
            ->first();
        $page_type = 'A4 landscape';
        if (strpos($product->product_sku, 'R157') !== false)
            $page_type = '210mm 210mm';
        $customer = Customer::find($product->customer_id);


        $filename = $product->feature_image;
        $prefix = 'customer-';

        // Check if the string starts with the prefix
        if (strpos($filename, $prefix) === 0) {
            $filename = substr($filename, strlen($prefix));
        }

        $source_path_logo = base_path('uploads/users/'.$product->user_logo);


        $image = Image::make($source_path_logo);

        $width = $image->width();

        // return view('admin/products/custom-product-pdf',
        //     compact('product','customer','product_type','page_type'));
        //echo $product_type->id;exit;
        /*
        if ($product_type->fx == 1) {
             return view('admin/products/custom-product-pdf',
                 compact('product','customer','product_type','page_type'));
        } else {
             return view('admin/products/custom-product-pdf-4x4',
                 compact('product','customer','product_type','page_type'));
        } */

        if ($product_type->fx == 1) {
            $width_mm = ($product_type->width/300)*25.4;
            $height_mm = ($product_type->height/300)*25.4;

            $width_points = $width_mm / 25.4 * 72;
            $height_points = $height_mm / 25.4 * 72;

            if(isset($data['html']) && $data['html'] == 1) {
                return view('admin/products/custom-product-pdf',
                    compact('product', 'customer', 'product_type', 'page_type'));
            }

            $options = [
                'isPhpEnabled' => true,  // Enable PHP execution within the PDF (if required)
                'dpi' => 300,             // Adjust DPI to match client's image scaling
                //'defaultFont' => 'Helvetica', // Optional: specify a default font
                'isRemoteEnabled' => true,
            ];


            $pdf = Pdf::loadView('admin/products/custom-product-pdf', compact('product', 'customer', 'product_type', 'page_type'))
                ->setOptions($options); // Correctly pass options as an array

            $pdf->setPaper([0, 0, $width_points, $height_points]);

            //return $pdf->stream('custom-product.pdf'); // or save as needed
        } else {
            $width_mm = 459.91;
            $height_mm = 949.96;
            $width_points = $width_mm / 25.4 * 72;
            $height_points = $height_mm / 25.4 * 72;

            if(isset($data['html']) && $data['html'] == 1) {
                return view('admin/products/custom-product-pdf-4x4',
                    compact('product','customer','product_type','page_type'));
            }
            $options = [
                'isPhpEnabled' => true,  // Enable PHP execution within the PDF (if required)
                'dpi' => 300,             // Adjust DPI to match client's image scaling
                //'defaultFont' => 'Helvetica', // Optional: specify a default font
                'isRemoteEnabled' => true,
            ];


            $pdf = Pdf::loadView('admin/products/custom-product-pdf-4x4', compact('product', 'customer', 'product_type', 'page_type'))
                ->setOptions($options); // Correctly pass options as an array

            $pdf->setPaper([0, 0, $width_points, $height_points ]);
        }
        $file_name =  $customer->company ?? $customer->first_name;
        //$file_name .=  '-'.$customer->last_name ?? '';
        $file_name .=  '_'.$product->product_name ?? '';
        $file_name .=  '_'.$product->product_sku ?? '';
        // Return the PDF as a stream to the browser
        return $pdf->stream(trim($file_name, '_-') . '.pdf', ['Attachment' => false]);

    }

}
