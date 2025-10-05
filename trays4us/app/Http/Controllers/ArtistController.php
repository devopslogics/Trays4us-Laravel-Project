<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Customer;
use App\Models\CustomizableTypeRelation;
use App\Models\Helper;
use App\Models\ProductImages;
use App\Models\ProductPrices;
use App\Models\Products;
use App\Models\ProductsTag;
use App\Models\ProductType;
use App\Models\SiteManagements;
use App\Models\Tags;
use App\Models\TempProductImages;
use App\Models\TempProducts;
use App\Models\CustomizerProcessingTime;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\ImageManagerStatic as Image2;
use Carbon\Carbon;
use View;

class ArtistController extends Controller
{

    public function create_custom(Request $request)
    {
        $page_title = 'Create Custom with Minimums of 10 Trays';
        $page_description = 'Let us create custom decorative wooden trays for you—naturally with your logos. The trays are finished with a premium matte finish.';
        return view('frontend/artist/create-custom', compact('page_title','page_description'));
    }

    public function license_artwork(Request $request)
    {
        $artists = Artist::whereHas('limited_products', function ($query) {
            //$query->where('is_feature', 1);
            $query->where("artist.status", "=", 1);
            $query->where("artist.is_visible", "=", 1);
        })->has('limited_products')->orderBy('artist.sort_order', 'asc')->get();

        if (request()->ajax()) {
            $record_found = 'yes';
            if ($artists->isEmpty()) {
                $record_found = 'no';
            }

            $returnHTML = view('frontend/artist/ajax-load-more-artists', compact('artists'))->render();
            return response()->json(array('success' => true, 'record_found' => $record_found, 'html' => $returnHTML));
        }
        $page_title = 'License Your Artwork';
        $page_description = 'License your artwork and join the network of amazing artists. Contact us to learn more.';
        return view('frontend/artist/license-artwork', compact('artists','page_title','page_description'));
    }

    public function artist_detail(Request $request,$slug)
    {
        $data = $request->all();
        $siteManagement  = SiteManagements::getSiteManagment();
        $artist = Artist::select('*')
            ->where('artist_slug', $slug)
            ->first();

        $query = Products::join('product_prices', 'products.id', '=', 'product_prices.product_id')
            //->join('product_type', 'product_prices.pt_sub_id', '=', 'product_type.id')
            ->join('artist', 'products.artist_id', '=', 'artist.id')
            ->leftJoin('badges', 'badges.id', '=', 'products.p_badge')
            ->select('products.product_name','products.id as pid','products.product_slug','products.product_customizable','products.feature_image','products.product_sku','badges.badge','badges.color','artist.first_name','artist.last_name','artist.display_name' ,'product_prices.price', 'product_prices.pt_parent_id','product_prices.pt_sub_id')
            ->where("products.status", "=", 1)
            ->where('products.customer_id', 0)
            //->where("artist.status", "=", 1)
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
            ->where("artist.artist_slug", "=", $slug);


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

        $query->orderByRaw($orderByRaw);

        $product_by_artists = $query->get();

        $page_title = $artist->display_name ?? '';

        $page_description = $artist->description ?? '';

        // This image will be used in head using og image for social media
        $og_image = '';
        if( !empty($artist->artist_photo) && \Storage::disk('uploads')->exists('/users/' .$artist->artist_photo)){
            $og_image = url('uploads/users/'.$artist->artist_photo);
        }

        return view('frontend/artist/artist-detail', compact('artist','product_by_artists','page_title','page_description','og_image'));
    }

    public function upload_your_work(Request $request)
    {

        $page_title = 'Upload Your Artwork';
        $page_description = 'Let us create custom decorative wooden trays for you—naturally with your logos. The trays are finished with a premium matte finish.';
        $product_types = ProductType::select('id','type_name','parent_id')->where("status", 1)->where("parent_id", 0)->orderBy('id', 'ASC')->get();

        $is_customer = Session::get('is_customer');
		if(isset($is_customer->id))
			$is_customer = Customer::find($is_customer->id);
        return view('frontend/artist/upload-aritst-work', compact('page_title','page_description','product_types','is_customer'));
    }

    public function save_artist_work(Request $request)
    {
        $data = $request->all();

        $startTime = microtime(true);
        $rules = [
            'tray_image' => 'required',
            'product_name' => 'required',
        ];

        // Actullay logo saved against the user so not required every time to upload. If any user come first them
        // then user will not logo so we update the logo
        if ($request->new_logo == 0) {
            $rules['artist_logo'] = 'required|image|mimes:jpeg,png,jpg|max:1024';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $productTypeIds = explode(',', $data['product_types']);
        $product_types = ProductType::select('id','type_name','parent_id')->where("status", 1)->where("parent_id", 0)->orderBy('id', 'ASC')->get();
        //print_r($product_types);exit;
        $is_customer = Session::get('is_customer');
        $customer_id = $is_customer->id;

        // Delete the previous uploaded images and their record
        TempProducts::query()->where('customer_id', '=', $customer_id)->delete();

        $customer = Customer::find($customer_id);
        $artist_logo_file_name = $customer->customer_logo;

        if($artist_logo = $request->file('artist_logo')) {
            $usersDestinationPath = base_path('uploads/users/');
            $customer = Customer::find($customer_id);
            $image = Image::make($artist_logo);

            $pngImage = $image->encode('png');
            $artist_logo_file_name ='-logo-'.time().'-'.rand().$customer_id.'.png';
            $pngImage->save($usersDestinationPath.'original'.$artist_logo_file_name);

            $modify_image = Image::make($artist_logo);
            // Get original width and height
            $width = $modify_image->width();
            $height = $modify_image->height();

            // Check if width or height is greater than 1000px
            if ($width > 1000 || $height > 1000) {
                if ($width > $height) {
                    // If width is greater, set width to 1000 and height auto
                    $modify_image->resize(1000, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } else {
                    // If height is greater, set height to 1000 and width auto
                    $modify_image->resize(null, 1000, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
            }

            $modifypngImage = $modify_image->encode('png');
            $modifypngImage->save($usersDestinationPath.'custom'.$artist_logo_file_name);
            \App\Traits\Definations::remove_background_from_image($usersDestinationPath,'custom'.$artist_logo_file_name);
            $customer->customer_logo = 'custom'.$artist_logo_file_name;
            $customer->save();

            $artist_logo_file_name = 'custom'.$artist_logo_file_name;
        }

        $siteManagement = SiteManagements::getSiteManagment();

        $tempProductIds = [];

        if ($file = $request->file('tray_image')) {
            if ($product_types->isNotEmpty()) {

                $destinationPath = base_path('uploads/customizer-products/');
                $orginal_file_name = 'original-' . time() . rand() . ".png";

                // Initial conversion to PNG
                $image = new \Imagick($file->getRealPath());
                $image->setImageFormat('png');
                $image->writeImage($destinationPath . $orginal_file_name);

                // Clear resources
                $image->clear();
                $image->destroy();

                foreach ($product_types as $key => $product_type) {
                    foreach ($product_type->child_types_having_criteria as $childType) {
                        if(!in_array($childType->id,$productTypeIds))
                            continue;
                        //-------------------------------*************************--------------------------------------
                        $customizable_type_relation = CustomizableTypeRelation::where('product_customizable_id', $siteManagement->customizer_minimums)->where('product_type_id', $childType->id)->first();
                        $case_pack = $childType->case_pack;
                        $border_radius = $childType->border_radius;
                        $bedge = $siteManagement->customizer_bedge;
                        $artist_id = $siteManagement->customizer_artist_id;
                        $style_id = $siteManagement->customizer_style_id;
                        $price = $customizable_type_relation->set_price ?? 14;
                        $customizer_minimums = $siteManagement->customizer_minimums ?? 4;

                        $product = new TempProducts();
                        $product->product_name = $data['product_name'];
                        $product->product_sku = $childType->sku . '-' . ($siteManagement->sku_number + 1);
                        $product->artist_id = $artist_id;
                        // When selected custom bedge then customer id will be saved in product table
                        // This functionality is only working for Custom or private listing when needed
                        $product->customer_id = $customer_id;
                        $product->style_id = $style_id;
                        $product->product_customizable = $customizer_minimums; //NULL;
                        $product->product_description = NULL;
                        $product->pt_parent_id = $childType->parent_id;
                        $product->pt_sub_id = $childType->id;
                        $product->price = $price;
                        $product->country_id = 231;
                        $product->state_id = NULL;
                        $product->p_badge = $bedge;
                        $product->minimum_order_quantity = 1;
                        $product->user_logo = $artist_logo_file_name ?? NULL;
                        $product->case_pack = 1;
                        $product->tags = NULL;
                        $product->status = 1;
                        $product->type = 2;
                        $product->save();

                        $product_id = $product->id;

                        $tempProductIds[] = $product_id;

                        //-------------------------------*************************--------------------------------------

                        $siteManagement->sku_number = $siteManagement->sku_number + 1;
                        $siteManagement->save();

                        $file_name1 = $childType->sku . '-' . time() . rand() . ".";
                        $file_name = $file_name1 . 'png';
                        //-------------------------------*************************--------------------------------------

                        if($childType->sku == 'R157') {

                            $customerImagePath = $destinationPath . 'customer-' . $file_name;
                            $originalImagePath = $destinationPath . $orginal_file_name;
                            $processedImagePath = $destinationPath . $file_name;

                            $image = new \Imagick($originalImagePath);
                            $image->cropThumbnailImage(5079, 5079);
                           // $image->roundCorners(2539.5, 2539.5);
                            $image->writeImage($processedImagePath);
                            $image->clear();
                            $image->destroy();


                            $image = Image::make($processedImagePath)->resize(1500, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });

                            $width =  $image->width();
                            $height = $image->height();

                            $cropWidthAmount = ($width - $childType->custom_download_width) / 2;
                            $cropHeightAmount = ($height - $childType->custom_download_hight) / 2;

                            $newWidth = $width - 2 * $cropWidthAmount;  // 1370
                            $newHeight = $height - 2 * $cropHeightAmount; // 660
                            $image->crop($newWidth, $newHeight, round($cropWidthAmount), round($cropHeightAmount));
                            $image->save($customerImagePath);


                            $image2 = new \Imagick($customerImagePath);
                            $image2->cropThumbnailImage(1392, 1392);
                            $image2->roundCorners(round($childType->custom_download_width/2), round($childType->custom_download_hight/2));
                            $image2->writeImage($customerImagePath);
                            $image2->clear();
                            $image2->destroy();

                            // Create a canvas and insert images using Intervention Image
                            $frame = Image::canvas(1500, 1500, [0, 0, 0, 0]);
                            $image = Image::make($customerImagePath);
                            $fx = Image::make($destinationPath . 'fx/R157-1500-fx.png');
                            $frame->insert($image, 'center');
                            $frame->insert($fx, 'center');
                            $frame->save($customerImagePath);


                        } else {

                            $orginal_img = Image::make($destinationPath . $orginal_file_name);

                            $orginal_img->fit(
                                $childType->width,
                                $childType->height,
                                function ($constraint) {
                                    $constraint->aspectRatio();
                                    $constraint->upsize();
                                }
                            );

                            $orginal_img->save($destinationPath.$file_name);

                            $customer_file_name = 'customer-' . $file_name1 . 'png';
                            $fx_name = $childType->sku . '-1500-fx.png';

                            if ($childType->fx == 1) {

                                $image = Image::make($destinationPath.$file_name)->resize(1500, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                });

                                $width =  $image->width();
                                $height = $image->height();

                                $cropWidthAmount = ($width - $childType->custom_download_width) / 2;
                                $cropHeightAmount = ($height - $childType->custom_download_hight) / 2;

                                $newWidth = $width - 2 * $cropWidthAmount;  // 1370
                                $newHeight = $height - 2 * $cropHeightAmount; // 660
                               // echo $childType->sku.'------'.$newWidth.'---------'.$newHeight.'<hr>';
                                $image->crop($newWidth, $newHeight, round($cropWidthAmount), round($cropHeightAmount));

                                $image->save($destinationPath.$customer_file_name);

                                Helper::imageCreateCorners($destinationPath.$customer_file_name,$border_radius);

                                $frame = Image::canvas(1500, 1500, [0, 0, 0, 0]);
                                $tray_image = Image::make($destinationPath . $customer_file_name);
                                $fx = Image::make($destinationPath . 'fx/' . $fx_name);
                                $frame->insert($tray_image, 'center');
                                $frame->insert($fx, 'center');
                                $frame->save($destinationPath . $customer_file_name);
                            }

                            // This is special case for coasters

                            if ($childType->fx == 0 ) {
                                $orginal_img_customer_download = Image::make($destinationPath . $orginal_file_name);

                                $orginal_img_customer_download->fit(
                                    $childType->custom_download_width,
                                    $childType->custom_download_hight,
                                    function ($constraint) {
                                        $constraint->aspectRatio();
                                        $constraint->upsize();
                                    }
                                );

                                $orginal_img_customer_download->save($destinationPath.$customer_file_name);

                                Helper::imageCreateCorners($destinationPath.$customer_file_name,$border_radius);
                                $this->create_4x4_image($customer_file_name);
                            }
                        }

                        $product = TempProducts::query()->where('id', '=', $product_id)->first();
                        $product->feature_image = $file_name;
                        $product->fetaure_image_orginal_name = $orginal_file_name;
                        $product->crop_image = $file_name;
                        $product->save();

                    }
                }
            }

            $redirect = route('preview-your-work');


            // End timing the process
            $endTime = microtime(true);
            $processingTime = round($endTime - $startTime, 2); // Processing time in seconds

            // Save processing time data in customizer_processing_time table

            $customizerProcessingTime = new CustomizerProcessingTime();
            $customizerProcessingTime->product_name = $data['product_name'];
            $customizerProcessingTime->product_ids = implode(',', $tempProductIds);
            $customizerProcessingTime->customer_id = $customer_id;
            $customizerProcessingTime->image_name = $orginal_file_name;
            $customizerProcessingTime->upload_processing_time = $processingTime;
            $customizerProcessingTime->created_at = Carbon::now();
            $customizerProcessingTime->updated_at = Carbon::now();
            $customizerProcessingTime->save();

            return response()->json(['success' => 'Image uploaded successfully','status' => 1,'redirect' => $redirect]);
        }
    }

    public function preview_your_work(Request $request)
    {
        /*
        $framePath = base_path('uploads/customizer-products/');
        $customerImagePath = $framePath . 'customer.png';
        $orginal_path = $framePath . '1612-17246544561874890888.png';

        $image = Image::make($orginal_path)->resize(1500, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $width =  $image->width();
        $height = $image->height();

        $cropWidthAmount = ($width - 1396) / 2;
        $cropHeightAmount = ($height - 672) / 2;

        $newWidth = $width - 2 * $cropWidthAmount;  // 1370
        $newHeight = $height - 2 * $cropHeightAmount; // 660
        // echo $childType->sku.'------'.$newWidth.'---------'.$newHeight.'<hr>';
        $image->crop($newWidth, $newHeight, round($cropWidthAmount), round($cropHeightAmount));

        $image->save($customerImagePath);

        Helper::imageCreateCorners($customerImagePath,156);

        $frame = Image::canvas(1500, 1500, [0, 0, 0, 0]);
        $tray_image = Image::make($customerImagePath);
        $fx = Image::make($framePath . 'fx/1105-1500-fx.png');
        $frame->insert($tray_image, 'center');
        $frame->insert($fx, 'center');
        $frame->save($framePath . 'customer.png');
        exit; */

        $page_title = 'Preview Your Artwork';
        $page_description = 'Let us create custom decorative wooden trays for you—naturally with your logos. The trays are finished with a premium matte finish.';
        $is_customer = Session::get('is_customer');
        $customer = Customer::find($is_customer->id);
        $temp_products = TempProducts::select('*')->where('customer_id', '=', $is_customer->id)->where('type', '=', 2)->orderBy('id', 'desc')->get();
        if($temp_products->isEmpty()) {
            return redirect(route('upload-your-work'));
        }
        return view('frontend/artist/preview-aritst-work', compact('page_title','page_description','temp_products','customer'));
    }

    public function save_preview_your_work(Request $request){

        $data = $request->all();

        if(isset($data['product_id']) && count($data['product_id']) > 0) {

            $startTime = microtime(true); // Start timing

            $is_customer = Session::get('is_customer');
            $customer_id = $is_customer->id;

            $temp_products = TempProducts::select('*')
                ->whereIn('id', $data['product_id'])
                ->where('customer_id', '=', $customer_id)
                ->where('type', '=', 2)
                ->orderBy('id', 'desc')
                ->get();

            $siteManagement = SiteManagements::getSiteManagment();

            $totalRecords = 0;
            if ($temp_products) {

                foreach ($temp_products as $key => $temp_product) {
                    $product_already_exist = DB::table('products')
                        ->where('product_sku', $temp_product->product_sku)
                        ->doesntExist();
                    if ($product_already_exist) {
                        $product = new Products();
                        // Append product type with product slug at last
                        $product_name = $temp_product->product_name;
                        $parent_product_type = ProductType::find($temp_product->pt_parent_id);
                        $sub_product_type = ProductType::find($temp_product->pt_sub_id);
                        $generateSlugLastString = '';
                        if (isset($parent_product_type->type_name) && isset($sub_product_type->type_name))
                            $generateSlugLastString = \App\Traits\Definations::generateSlugLastString($parent_product_type->type_name, $sub_product_type->type_name);

                        $product_name = filter_var($product_name, FILTER_SANITIZE_STRING);
                        $product_slug = $product_name . ' ' . $generateSlugLastString;
                        $product->product_name = $product_name;
                        $product->product_slug = $this->createSlug($product_slug);
                        $product->product_sku = $temp_product->product_sku;
                        $product->artist_id = $temp_product->artist_id;
                        // When selected custom bedge then customer id will be saved in product table
                        // This functionality is only working for Custom or private listing when needed
                        if (isset($temp_product->customer_id) && $temp_product->customer_id > 0) {
                            $product->customer_id = $temp_product->customer_id;
                        }
                        $product->style_id = $temp_product->style_id ?? NULL;
                        $product->product_customizable = $temp_product->product_customizable ?? NULL;
                        $product->product_description = $temp_product->product_description ?? NULL;
                        $product->feature_image = 'customer-'.$temp_product->crop_image ?? NULL;
                        $product->country_id = $temp_product->country_id ?? NULL;
                        $product->state_id = $temp_product->state_id ?? NULL;
                        $product->p_badge = $temp_product->p_badge ?? NULL;
                        $product->status = 1;
                        $product->type = 2;
                        $product->customer_uploaded_image = $temp_product->fetaure_image_orginal_name;
                        $product->user_logo = $temp_product->user_logo;
                        $product->save();

                        $product_id = $product->id;

                        // The orginal image which customer uploaded from front end save for usage
                        $sourcePath = base_path('uploads/customizer-products/' .$temp_product->fetaure_image_orginal_name);
                        $destinationPath = base_path('uploads/products/' . $temp_product->fetaure_image_orginal_name);

                        if (\File::exists($sourcePath)) {
                            $img = Image::make($sourcePath);
                            $img->save($destinationPath);
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

                        if ($temp_product->feature_image) {

                            $sourcePath = base_path('uploads/customizer-products/' .$temp_product->crop_image);
                            $destinationPath = base_path('uploads/products/' . $temp_product->crop_image);

                            $customer_images_sourcePath = base_path('uploads/customizer-products/customer-'.$temp_product->crop_image);
                            $customer_images_destinationPath = base_path('uploads/products/customer-'.$temp_product->crop_image);

                            //foreach ($temp_product->images as $gallery_image) {
                            $product_image = new ProductImages();
                            $product_image->image_name = 'customer-'.$temp_product->crop_image;
                            $product_image->product_id = $product_id;
                            $product_image->sorting = 0;
                            $product_image->save();

                            // Back code will start here this code is only work for tray back images and add logo
                            // to the back tray of the customer
                            if($sub_product_type->fx == 1) {
                                $tray_blank_image = $sub_product_type->tray_blank_image;
                                $back_image_path = base_path('assets/images/');

                                $back_trays_destination_path = base_path('uploads/products/');
                                $back_file_name = $sub_product_type->sku . '-tray-back-' . '-' . time() . rand() . $tray_blank_image;

                                $is_customer = Session::get('is_customer');
                                $customer_id = $is_customer->id;

                                $usersDestinationPath = base_path('uploads/users/');
                                $customer = Customer::find($customer_id);

                                $base_image = Image::make($back_image_path . $tray_blank_image);
                                $customer_logo = Image::make($usersDestinationPath . $customer->customer_logo);

                                $max_width = $sub_product_type->logo_width; // Set your desired maximum width
                                $max_height = $base_image->height(); // Set this to a percentage or fixed height if needed

                                $customer_logo->resize($max_width, null, function ($constraint) use ($max_height) {
                                    $constraint->aspectRatio();
                                    $constraint->upsize();
                                });

                                if ($customer_logo->height() > $max_height) {
                                    $customer_logo->resize(null, $sub_product_type->logo_height, function ($constraint) {
                                        $constraint->aspectRatio();
                                        $constraint->upsize();
                                    });
                                }
                                $base_image->insert($customer_logo, 'center');
                                $base_image->save($back_trays_destination_path . $back_file_name)->encode('png');

                                $product_image = new ProductImages();
                                $product_image->image_name = $back_file_name;
                                $product_image->product_id = $product_id;
                                $product_image->sorting = 1;
                                $product_image->save();
                            }

                            // END of the tray back image

                            if (\File::exists($sourcePath)) {

                                \File::copy($sourcePath, $destinationPath);

                                \File::copy($customer_images_sourcePath, $customer_images_destinationPath);

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


                                $file_original_name = 'customer-'.$temp_product->crop_image;

                                if(!empty($image_size)) {

                                    foreach ($image_size as $key => $size) {
                                        $small_img = Image::make($customer_images_destinationPath);
                                        $small_img->fit(
                                            $size['width'],
                                            $size['height'],
                                            function ($constraint) {
                                                $constraint->upsize();
                                            }
                                        );
                                        $small_img->save(base_path('uploads/products/') . $key . '-' . $file_original_name);
                                    }

                                    $img = Image::make($destinationPath);

                                    $img->save(base_path('uploads/products/').'-'.$file_original_name);

                                    // This code is special to create back images for trays
                                    if($sub_product_type->fx == 1) {
                                        foreach ($image_size as $back_key => $size) {
                                            $small_img = Image::make($back_trays_destination_path . $back_file_name);
                                            $small_img->fit(
                                                $size['width'],
                                                $size['height'],
                                                function ($constraint) {
                                                    $constraint->upsize();
                                                }
                                            );
                                            $small_img->save(base_path('uploads/products/') . $back_key . '-' . $back_file_name);
                                        }
                                    }
                                }

                                TempProducts::query()->where('id', '=', $temp_product->id)->where('type', '=', 2)->delete();
                                \File::delete($sourcePath);
                                \File::delete($customer_images_sourcePath);
                            }
                            //}
                        }

                        if(isset($product_id) AND isset($siteManagement->customizer_tag_id)) {
                            $ProductsTag = new ProductsTag();
                            $ProductsTag->products_id = $product_id;
                            $ProductsTag->tags_id = $siteManagement->customizer_tag_id;
                            $ProductsTag->save();
                        }
                    }
                }

                // Save processing time in database NIklas want to how customer experience
                $endTime = microtime(true);
                $processingTime = $endTime - $startTime;

                $processing_time_modal = CustomizerProcessingTime::where('customer_id', $customer_id)
                ->latest()
                ->first();
                $processing_time_modal->orig_prod_proc_time =$processingTime;
                $processing_time_modal->save();


                Session::flash('message','Your products have been successfully created. You can now place your order.');

                return response()->json([
                    'message' => 'Your products have been successfully created. You can now place your order.',
                    'class_name' => 'alert alert-success',
                    'status' => 'success',
                    'redirect_url' => route('products')
                ]);

            }

            return response()->json([
                'message' => 'No record found',
                'class_name' => 'alert alert-error',
                'status' => 'error'
            ]);

        } else {
            return response()->json([
                'message' => 'Please choose at least one product.',
                'class_name' => 'alert alert-error',
                'status' => 'error'
            ]);
        }
    }

    public function is_real_product_create(Request $request)
    {
        $data = $request->all();
        $product = TempProducts::query()->where('id', '=', $data['product_id'])->first();
        $product->is_create = $data['status'];
        $product->save();
        echo "done";
    }

    public function download_product(Request $request,$temp_id)
    {
        $data = $request->all();
        $temp_product = TempProducts::find($temp_id);
        $product_type = ProductType::find($temp_product->pt_sub_id);
        $sourcePath = base_path('uploads/customizer-products/' . $temp_product->crop_image);
        $frame_path = base_path('uploads/customizer-products/');

        $dynamicFilename = $temp_product->product_name.'_'.$product_type->sku . '.png';

        $originalSourcePath = $sourcePath; // Path to your original image

        // Define the temporary directory and file path
        $temporaryDirectory = storage_path('app/temp/');
        $temporarySourcePath = $temporaryDirectory . Str::random(40) . '.png';

        // Ensure the temporary directory exists
        if (!\File::exists($temporaryDirectory)) {
            \File::makeDirectory($temporaryDirectory, 0755, true);
        }

        // Copy the original image to the temporary location
        copy($originalSourcePath, $temporarySourcePath);

        $command = 'magick "' . $temporarySourcePath . '" -alpha Set -channel A -evaluate Multiply 0.60 "' . $temporarySourcePath . '" 2>&1';
        $output = [];
        $return_var = 0;
        exec($command, $output, $return_var);


        if($product_type->sku == 'R157') {

            // Define the original paths
            $fx_name = $product_type->sku . '-1500-fx.png';

            // Process the temporary image
            $frame = Image::make($frame_path . 'fx/' . $fx_name);
            $image = Image::make($temporarySourcePath);
            $image->resize(1378, 1378);
            $frame->insert($image, 'center');

        } else {

            Helper::imageCreateCorners($temporarySourcePath,$product_type->border_radius);

            $fx_name = $product_type->sku.'-1500-fx.png';

            if ($product_type->fx == 1 && \File::exists($frame_path . 'fx/' . $fx_name)) {
                $frame = Image::make($frame_path . 'fx/' . $fx_name);
                $image = Image::make($temporarySourcePath);
                $frame->insert($image, 'center');
            }
            // This is special case for coasters
            if ($product_type->fx == 0 ) {

                $frame = Image::canvas(1500, 1500, [0, 0, 0, 0]); // Create a 1500x1500 transparent canvas

                $frame_path = base_path('uploads/customizer-products/');

                $is_customer = Session::get('is_customer');
                $customer_id = $is_customer->id;

                $usersDestinationPath = base_path('uploads/users/');
                $customer = Customer::find($customer_id);


                // Load your images
                $image1 = Image::make($temporarySourcePath);
                $image2 = Image::make($frame_path.'fx/wood.png');
                $image3 = Image::make($temporarySourcePath);
                $image4 = Image::make($temporarySourcePath);
                $image5 = Image::make($usersDestinationPath.$customer->customer_logo);

                // Resize images as needed
                $image1->resize(590, 590);
                $image5->resize(200, 200);
                $image3->resize(590, 590);
                $image4->resize(590, 590);

                // Apply transformations (e.g., rotation)
                //$image1->rotate(10);
                // $image2->rotate(-10);
                $image3->rotate(-15);
                $image4->rotate(-20);

                // Overlay images on the transparent base image
                $frame->insert($image1, 'top-left', 150, 50);
                $frame->insert($image2, 'top-right', 150, 50);
                $frame->insert($image5, 'top-right', 350, 250);
                $frame->insert($image3, 'bottom-left', 150, 50);
                $frame->insert($image4, 'bottom-right', 150, 50);
            }
        }


        $imageData = $frame->encode('png');

        // Delete the temporary file after processing

        // Prepare the response with appropriate headers for downloading
        return \Response::make($imageData, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="'.$dynamicFilename.'"',
        ]);

    }

    public function edit_product(Request $request,$id)
    {
        $data = $request->all();

        $page_title = '';

        $page_description = '';

        $is_customer = Session::get('is_customer');

        $customer_id = $is_customer->id;

        $customer = Customer::find($customer_id);

        $temp_product = TempProducts::select('*')->where('type', '=', 2)->where('id', '=', $id)->where('customer_id', '=', $customer_id)->first();
        $temp_product->is_create = 1;
        $temp_product->save();

        return view('frontend/artist/edit-product', compact('page_title','page_description','temp_product','customer'));
    }

    public function save_edit_product(Request $request)
    {

        $data = $request->all();
        if(isset($_POST['image']))
        {
            $orginal_image_name = $request->input('image_name');
            $product_id = $request->input('product_id');

            $temp_product = TempProducts::find($product_id);
            $product_type = ProductType::find($temp_product->pt_sub_id);
            $border_radius = $product_type->border_radius;

            $data = $_POST['image'];

            $image_array_1 = explode(";", $data);

            $image_array_2 = explode(",", $image_array_1[1]);

            $data = base64_decode($image_array_2[1]);

            $destinationPath = base_path('uploads/customizer-products/');

            $customer_image_path = $destinationPath.'customer-' .$orginal_image_name;

            file_put_contents($destinationPath. $orginal_image_name, $data);

            $customer_download_size = Image::make($data)->encode('png');

            if($product_type->sku == 'R157') {
                $customer_download_size->fit(
                    5079,
                    5079,
                    function ($constraint) {
                        $constraint->aspectRatio();
                    }
                );

                $customer_download_size->save($orginal_image_name)->encode('png');

                $image = Image::make($orginal_image_name)->resize(1500, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $width =  $image->width();
                $height = $image->height();

                $cropWidthAmount = ($width - $product_type->custom_download_width) / 2;
                $cropHeightAmount = ($height - $product_type->custom_download_hight) / 2;

                $newWidth = $width - 2 * $cropWidthAmount;  // 1370
                $newHeight = $height - 2 * $cropHeightAmount; // 660
                $image->crop($newWidth, $newHeight, round($cropWidthAmount), round($cropHeightAmount));
                $image->save($customer_image_path);

                $image = new \Imagick($customer_image_path);

                $image->cropThumbnailImage(1392, 1392);

                $image->roundCorners(round($product_type->custom_download_width/2), round($product_type->custom_download_hight/2));

                $image->setImageFormat("png");

                $image->writeImage($customer_image_path);

                $image->clear();
                $image->destroy();

                $fx_name = $product_type->sku.'-1500-fx.png';


                $frame = Image::canvas(1500, 1500, [0, 0, 0, 0]);
                $image = Image::make($customer_image_path);
                $fx = Image::make($destinationPath . 'fx/'.$fx_name);
                // $image->resize(1378, 1378);
                $frame->insert($image, 'center');
                $frame->insert($fx, 'center');
                $frame->save($customer_image_path)->encode('png');

            } else {

                $customer_download_size->fit(
                    $product_type->width,
                    $product_type->height,
                    function ($constraint) {
                        $constraint->aspectRatio();
                    }
                );

                $customer_download_size->save($destinationPath.$orginal_image_name)->encode('png');

                $fx_name = $product_type->sku . '-1500-fx.png';

                if ($product_type->fx == 1 && \File::exists($destinationPath . 'fx/' . $fx_name)) {

                    $image = Image::make($destinationPath.$orginal_image_name)->resize(1500, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $width =  $image->width();
                    $height = $image->height();

                    $cropWidthAmount = ($width - $product_type->custom_download_width) / 2;
                    $cropHeightAmount = ($height - $product_type->custom_download_hight) / 2;

                    $newWidth = $width - 2 * $cropWidthAmount;  // 1370
                    $newHeight = $height - 2 * $cropHeightAmount; // 660
                    // echo $childType->sku.'------'.$newWidth.'---------'.$newHeight.'<hr>';
                    $image->crop($newWidth, $newHeight, round($cropWidthAmount), round($cropHeightAmount));

                    $image->save($customer_image_path);

                    $image->destroy();

                    Helper::imageCreateCorners($customer_image_path, $border_radius);

                    $frame = Image::canvas(1500, 1500, [0, 0, 0, 0]);
                    $tray_image = Image::make($customer_image_path);
                    $fx = Image::make($destinationPath . 'fx/' . $fx_name);
                    $frame->insert($tray_image, 'center');
                    $frame->insert($fx, 'center');
                    //$frame->insert($fx, null, 0, 400);
                    $frame->save($customer_image_path)->encode('png');

                    // Clear memory
                    $tray_image->destroy();
                    $fx->destroy();
                    $frame->destroy();

                }

                // This is special case for coasters
                if ($product_type->fx == 0) {
                    $orginal_img_customer_download = Image::make($destinationPath . $orginal_image_name);

                    $orginal_img_customer_download->fit(
                        $product_type->custom_download_width,
                        $product_type->custom_download_hight,
                        function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        }
                    );

                    $orginal_img_customer_download->save($customer_image_path);
                    Helper::imageCreateCorners($customer_image_path, $border_radius);
                    $this->create_4x4_image('customer-' . $orginal_image_name);
                }
            }


            $temp_product = TempProducts::find($product_id);
            $temp_product->crop_image =  $orginal_image_name;
            $temp_product->save();

            Session::flash('message','Your image has been cropped');

            return response()->json([
                'message' => 'Your products have been successfully created. You can now place your order.',
                'class_name' => 'alert alert-success',
                'status' => 'success',
                'redirect_url' => route('preview-your-work')
            ]);
        }
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

    public function create_4x4_image($image_name)
    {

        $baseImage = Image::canvas(1500, 1500, [0, 0, 0, 0]); // Create a 1500x1500 transparent canvas

        $frame_path = base_path('uploads/customizer-products/');
        $is_customer = Session::get('is_customer');
        $customer_id = $is_customer->id;

        $usersDestinationPath = base_path('uploads/users/');
        $customer = Customer::find($customer_id);

        $image1 = Image::make($frame_path.$image_name);
        $image2 = Image::make($frame_path.'fx/wood.png');
        $image3 = Image::make($frame_path.$image_name);
        $image4 = Image::make($frame_path.$image_name);
        $image5 = Image::make($usersDestinationPath.$customer->customer_logo);

        $image1->resize(590, 590);
        $image5->resize(173, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image3->resize(590, 590);
        $image4->resize(590, 590);

        $image3->rotate(-15);
        $image4->rotate(-20);

        $logoX = (590 - $image5->width()) / 2;
        $logoY = (590 - $image5->height()) / 2;

        $image2->insert($image5, 'top-left', round($logoX), round($logoY));

        $baseImage->insert($image1, 'top-left', 130, 50);
        $baseImage->insert($image2, 'top-right', 130, 50); // Now contains the centered logo
        $baseImage->insert($image3, 'bottom-left', 130, 50);
        $baseImage->insert($image4, 'bottom-right', 130, 50);

        // Save or output the final image
        $baseImage->save($frame_path.$image_name)->encode('png');

        // Clear memory
        $image1->destroy();
        $image2->destroy();
        $image3->destroy();
        $image4->destroy();
        $image5->destroy();
        $baseImage->destroy();

    }

}
