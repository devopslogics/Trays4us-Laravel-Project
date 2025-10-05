<?php

namespace App\Http\Controllers\admin;

use App\Models\CustomizableTypeRelation;
use App\Models\Helper;
use App\Models\ProductPrices;
use App\Models\Products;
use App\Models\SiteManagements;
use Illuminate\Http\Request;
use App\Models\HomepageSlider;
use App\Models\ProductType;
use App\Models\ProductCustomizable;
use App\Models\ProductStyle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Validator;
use Storage;
use DB;
use View;

class AdminGeneralController extends Controller
{
    // Homepage slider

    public function slider_listing(Request $request){
        $pagination = optional(View::shared('site_management'))->backend_pagination_listing ?? 50;
        $homepage_sliders = HomepageSlider::select('id', 'slider_image', 'slider_title','status','created_at')
            ->wherein("status", array(0, 1))
            ->orderBy('sort_order', 'ASC')
            ->paginate($pagination);
        return view('admin.homepage_slider.listing', compact('homepage_sliders'));
    }

    public function add_homepage_slider(Request $request){
        return view('admin.homepage_slider.add');
    }

    public function add_homepage_slider_submitted(Request $request){
        if($request->IsMethod("post")){

            $validator = Validator::make($request->all(), [
                'slider_title' => 'required',
                //'slider_title_link' => 'required',
                'slider_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=1916,min_height=550',
            ]);



            if ($validator->fails()) {

                return response()->json([
                    'error' => $validator->errors()->all()
                ]);

            }


            $homepageSlider = new HomepageSlider();
            $homepageSlider->slider_direction = $request->slider_direction;
            $homepageSlider->title_size = $request->title_size ?? 32;
            $homepageSlider->title_color = $request->title_color ?? '#000000';
            $homepageSlider->title_box_color = $request->title_box_color ?? '';


            $homepageSlider->slider_title = $request->slider_title;
            $homepageSlider->slider_title_link = $request->slider_title_link;
            $homepageSlider->slider_title_visibility = $request->slider_title_visibility ?? 1;

            $homepageSlider->shop_btn_text = $request->shop_btn_text;
            $homepageSlider->shop_now_link = $request->shop_now_link;

            $homepageSlider->label_text_size = $request->label_text_size ?? 32;
            $homepageSlider->label_color = $request->label_color ?? '#000000';
            $homepageSlider->label_box_color = $request->label_box_color ?? '#FFF';

            $homepageSlider->first_label = $request->first_label;
            $homepageSlider->first_link = $request->first_link;
            $homepageSlider->second_label = $request->second_label;
            $homepageSlider->second_link = $request->second_link;
            $homepageSlider->third_label = $request->third_label;
            $homepageSlider->third_link = $request->third_link;

            $homepageSlider->entire_banner_link = $request->entire_banner_link;

            if($request->file("slider_image")) {
                $slider_image = $request->file("slider_image");
                $destinationPath =  base_path('uploads/sliders/');
                $file_name = "slider-".time()."." . $slider_image->getClientOriginalExtension();
                $image_size = array(
                    'medium' => array(
                        'width' => 1300,
                        'height' => 460,
                    )
                );
                Helper::uploadTempImageWithSize($destinationPath, $slider_image, $file_name, $image_size);
                $homepageSlider->slider_image = $file_name;
            }


            $homepageSlider->status = 1;
            $homepageSlider->save();

            Session::flash('success', "Homepage Slider Added");
            return response()->json([
                'message' => 'Homepage Slider Added',
                'class_name' => 'alert alert-success',
                'status' => 'success',
                'redirect_url' =>  route('homepage-slider')
            ]);

        }
    }

    function edit_homepage_slider(Request $request)
    {
        try {
            $data = $request->all();
            $id = $request->id;
            $homepage_slider = HomepageSlider::query()
                ->where('id', '=',  $id)
                ->first();
            return view('admin/homepage_slider/edit', compact('homepage_slider'));
        } catch (\Exception $exception) {
            return redirect(route('tfubacksecurelogin'))->withInput($request->all())->with('error', $exception->getMessage());
        }
    }

    public function edit_homepage_slider_submitted(Request $request){
        if($request->IsMethod("post")){
            $validator = Validator::make($request->all(), [
                'slider_title' => 'required',
                //'slider_title_link' => 'required',
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'error' => $validator->errors()->all()
                ]);

            }

          $id = $request->id;
          $homepage_slider = HomepageSlider::query()
              ->where('id', '=',  $id)
              ->first();

          $homepage_slider->slider_direction = $request->slider_direction ?? 'center';
          $homepage_slider->title_size = $request->title_size ?? 32;
          $homepage_slider->title_color = $request->title_color ?? '#000000';
          $homepage_slider->title_box_color = $request->title_box_color ?? '';


          $homepage_slider->slider_title = $request->slider_title;
          $homepage_slider->slider_title_link = $request->slider_title_link;
          $homepage_slider->slider_title_visibility = $request->slider_title_visibility ?? 1;

          $homepage_slider->shop_btn_text = $request->shop_btn_text;
          $homepage_slider->shop_now_link = $request->shop_now_link;

          $homepage_slider->label_text_size = $request->label_text_size ?? 32;
          $homepage_slider->label_color = $request->label_color ?? '#000000';
          $homepage_slider->label_box_color = $request->label_box_color ?? '';

          $homepage_slider->first_label = $request->first_label;
          $homepage_slider->first_link = $request->first_link;
          $homepage_slider->second_label = $request->second_label;
          $homepage_slider->second_link = $request->second_link;
          $homepage_slider->third_label = $request->third_label;
          $homepage_slider->third_link = $request->third_link;

          $homepage_slider->entire_banner_link = $request->entire_banner_link;

          if($request->file("slider_image")) {
              $slider_image = $request->file("slider_image");
              $destinationPath =  base_path('uploads/sliders/');
              $file_name = "slider-".time()."." . $slider_image->getClientOriginalExtension();
              $image_size = array(
                  'medium' => array(
                      'width' => 1300,
                      'height' => 975,
                  )
              );
              Helper::uploadTempImageWithSize($destinationPath, $slider_image, $file_name, $image_size);
              $homepage_slider->slider_image = $file_name;
          }

        $homepage_slider->save();

          Session::flash('success', "Homepage slider updated");
          return response()->json([
              'message' => 'Homepage slider updated',
              'class_name' => 'alert alert-success',
              'status' => 'success',
              'redirect_url' =>  \url()->previous()
          ]);
        }
    }

    function change_slider_status(Request $request)
    {
        $data = $request->all();
        $id = base64_decode($request->id);
        $sid = explode(":", $id)[0];
        $status = explode(":", $id)[1];

        if ($status == 1) {
            $homepageSlider = HomepageSlider::query()
                ->select("id", "status")
                ->where("id", "=", $sid)
                ->first();
            $homepageSlider->status = $status;
            $homepageSlider->save();
            return redirect(route('homepage-slider'))->with('success', "Status Changed");

        } else if ($status == 0) {
            $homepageSlider = HomepageSlider::query()
                ->select("id", "status")
                ->where("id", "=", $sid)
                ->first();
            $homepageSlider->status = $status;
            $homepageSlider->save();
            return redirect(route('homepage-slider'))->with('success', "Status Changed");
        } else if ($status == 2) {
            DB::table('homepage_slider')->where('id', $sid)->delete();
            return redirect(route('homepage-slider'))->with('success', "Homepage slider deleted");
        }

    }

    function sort_homepage_slider(Request $request)
    {
        $data = $request->all();
        $homepage_sliders = HomepageSlider::select('id','slider_title','slider_image')
            ->where("status", "!=", 2)
            ->orderBY('sort_order')
            ->get();
        $returnHTML = view('admin/homepage_slider/sort-homepage-slider',compact('homepage_sliders'))->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }

    function sortHomepageSliderSubmitted(Request $request)
    {
        $data = $request->all();
        $sliders = $request->pass_array;
        foreach ($sliders as $key => $id) {
            HomepageSlider::query()->where('id','=',$id)->update(['sort_order' => $key]);
        }

        return response()->json([
            'message'   =>  'Successfully sorted',
            'class_name'  => 'alert alert-success',
            'status'  => 'success',
        ]);
    }

    public function slider_setting()
    {
        $site_managements = SiteManagements::query()
            ->where('id', '=',  1)
            ->first();
        return view('admin/homepage_slider/slider-setting', compact('site_managements'));
    }

    public function slider_setting_submitted(Request $request)
    {
        $data = $request->all();
        $site_management = SiteManagements::where("id", "=", 1)->first();

        $site_management->slider_auto = $data['slider_auto'] ?? 0;
        $site_management->slider_delay = $data['slider_delay'] ?? 0;
        $site_management->save();

        return redirect(route('slider-setting'))->with('success', "Slider Setting Updated");
    }

    // Product themes ----------------------------------------------------------------------------------

    public function product_style_listing(Request $request){
        $pagination = optional(View::shared('site_management'))->backend_pagination_listing ?? 50;
        $themes = ProductStyle::select('*')
            ->wherein("status", array(0, 1))
            ->orderBy('id', 'desc')
            ->paginate($pagination);
        return view('admin.product-style.listing', compact('themes'));
    }

    public function add_product_style(Request $request){
        return view('admin.product-style.add');
    }

    public function add_product_style_submitted(Request $request){
        if($request->IsMethod("post")){
            $validated = $request->validate([
                'style_name' => 'required',
            ]);

            $themes = new ProductStyle();
            $themes->style_name = $request->style_name;
            $themes->status = 1;
            $themes->save();
            return redirect(route('product-style'))->with('success', "Theme Added");
        }
    }

    function edit_product_style(Request $request)
    {
        try {
            $data = $request->all();
            $id = $request->id;
            $themes = ProductStyle::query()
                ->where('id', '=',  $id)
                ->first();
            return view('admin/product-style/edit', compact('themes'));
        } catch (\Exception $exception) {
            return redirect(route('product-style'))->withInput($request->all())->with('error', $exception->getMessage());
        }
    }

    public function edit_product_style_submitted(Request $request){
        if($request->IsMethod("post")){
            $validated = $request->validate([
                'style_name' => 'required',
            ]);

            $id = $request->id;
            $themes = ProductStyle::query()
                ->where('id', '=',  $id)
                ->first();

            $themes->style_name = $request->style_name;
            $themes->save();
            return redirect(route('product-style'))->with('success', "Theme updated");
        }
    }

    function change_product_style_status(Request $request)
    {
        $data = $request->all();
        $id = base64_decode($request->id);
        $sid = explode(":", $id)[0];
        $status = explode(":", $id)[1];

        $themes = ProductStyle::query()
            ->select("id", "status")
            ->where("id", "=", $sid)
            ->first();
        $themes->status = $status;
        $themes->save();
        return redirect(route('product-style'))->with('success', "Status Changed");

    }

    //------------------------------------------------------------------------------------------------------------------

    public function product_customizable_listing(Request $request){
        $pagination = optional(View::shared('site_management'))->backend_pagination_listing ?? 50;
        $customizables = ProductCustomizable::select('*')
            ->wherein("status", array(0, 1))
            ->orderBy('id', 'desc')
            ->paginate(10);

        $product_types = ProductType::with('childTypes')
            ->where('parent_id', '=',  0)
            ->paginate($pagination);

        return view('admin.product-customizable.listing', compact('customizables','product_types'));
    }

    public function add_product_customizable(Request $request){
        return view('admin.product-customizable.add');
    }

    public function add_product_customizable_submitted(Request $request){
        if($request->IsMethod("post")){
            $validated = $request->validate([
                'design_type' => 'required',
            ]);

            $customizable = new ProductCustomizable();
            $customizable->customizable_name = $request->design_type;
            $customizable->status = 1;
            $customizable->save();
            return redirect(route('product-customizable'))->with('success', "Product design type added");
        }
    }

    function edit_product_customizable(Request $request)
    {
        try {
            $data = $request->all();
            $id = $request->id;
            $customizable = ProductCustomizable::query()
                ->where('id', '=',  $id)
                ->first();
            return view('admin/product-customizable/edit', compact('customizable'));
        } catch (\Exception $exception) {
            return redirect(route('product-customizable'))->withInput($request->all())->with('error', $exception->getMessage());
        }
    }

    public function edit_product_customizable_submitted(Request $request){
        if($request->IsMethod("post")){
            $validated = $request->validate([
                'design_type' => 'required',
            ]);

            $id = $request->id;
            $customizable = ProductCustomizable::query()
                ->where('id', '=',  $id)
                ->first();

            $customizable->customizable_name = $request->design_type;
            $customizable->save();
            return redirect(route('product-customizable'))->with('success', "Product design type updated");
        }
    }

    public function save_customizable_type_relation(Request $request){

        $data = $request->all();
        //print_r($data);exit;
        if(isset($data['minimum_order_quantity']) AND count($data['minimum_order_quantity']) > 0) {
            $customize_idd = '';
            foreach($data['minimum_order_quantity'] as $customize_id => $product_types) {
                foreach($product_types as $product_type_id => $minimum_order_quantity) {
                    if(isset($minimum_order_quantity) AND $minimum_order_quantity > 0) {
                        $customizable_type_relation_obj = CustomizableTypeRelation::query()
                            ->where('product_customizable_id', '=', $customize_id)
                            ->where('product_type_id', '=', $product_type_id)
                            ->first();
                        if (!$customizable_type_relation_obj)
                            $customizable_type_relation_obj = new CustomizableTypeRelation();

                        $customizable_type_relation_obj->minimum_order_quantity = $minimum_order_quantity;
                        $customizable_type_relation_obj->set_price = $data['set_price'][$customize_id][$product_type_id] ?? NULL;
                        $customizable_type_relation_obj->product_customizable_id = $customize_id;
                        $customizable_type_relation_obj->product_type_id = $product_type_id;
                        $customizable_type_relation_obj->save();

                        // Fetch all products with related prices and based on the provided product_customizable and product_type_id
                        $products = Products::where('product_customizable', $customize_id)
                            ->whereHas('price_single', function ($query) use ($product_type_id) {
                                $query->where('pt_sub_id', $product_type_id);
                            })
                            ->where('status', 1)
                            ->where('type', 2)
                            ->with(['price_single' => function ($query) use ($product_type_id) {
                                $query->where('pt_sub_id', $product_type_id);
                            }])
                            ->get();

                        // Loop through the fetched products and update prices
                        foreach ($products as $product) {
                            if ($product->price_single) { // Ensure the price relation exists
                                $product_price = $product->price_single;
                                $new_price = $data['set_price'][$customize_id][$product_type_id] ?? null; // Use null coalescing to avoid undefined index errors

                                if ($new_price !== null) {
                                    $product_price->price = $new_price;
                                    $product_price->save();
                                } else {
                                    // Handle the case where price is not set
                                    Log::warning("Price not set for product ID: {$product->id}, customizable ID: {$customize_id}, product_type_id: {$product_type_id}");
                                }
                            } else {
                                // Handle the case where price relation is not found
                                Log::warning("Price relation not found for product ID: {$product->id}, customizable ID: {$customize_id}, product_type_id: {$product_type_id}");
                            }
                        }
                    }
                    $customize_idd = $customize_id;
                }
            }

            $product_customizable = ProductCustomizable::query()
                ->where('id', '=', $customize_idd)
                ->first();

            $product_customizable->customizable_name = $data['product_customizable'];
            $product_customizable->save();
        }

        return response()->json([
            'message'   =>  'Design Type Updated',
            'class_name'  => 'alert alert-success',
            'status'  => 'success',
        ]);

    }

    function change_product_customizable_status(Request $request)
    {
        $data = $request->all();
        $id = base64_decode($request->id);
        $sid = explode(":", $id)[0];
        $status = explode(":", $id)[1];

        $customizable = ProductCustomizable::query()
            ->select("id", "status")
            ->where("id", "=", $sid)
            ->first();
        $customizable->status = $status;
        $customizable->save();
        return redirect(route('product-style'))->with('success', "Status Changed");

    }

    // Product Types

    public function product_types_listing(Request $request){
        $pagination = optional(View::shared('site_management'))->backend_pagination_listing ?? 50;
        $product_types = ProductType::with('childTypes')
            ->where('parent_id', '=',  0)
            ->paginate($pagination);
        return view('admin.product_type.listing', compact('product_types'));
    }

    public function add_product_type(Request $request){
        $parent_types = ProductType::select('*')
            ->wherein("status", array(0, 1))
            ->where('parent_id', '=',  0)
            ->get();
        return view('admin.product_type.add', compact('parent_types'));
    }

    public function product_type_submitted(Request $request){
        if($request->IsMethod("post")){
            $validated = $request->validate([
                'type_name' => 'required',
            ]);

            $product_type = new ProductType();
            $product_type->type_name = $request->type_name;
            $product_type->type_description = $request->type_description;
            $product_type->parent_id = $request->parent_id ?? 0;
            //$product_type->minimum_order_quantity = $request->minimum_order_quantity ?? 1;
            $product_type->case_pack = $request->case_pack ?? 1;
            $product_type->status = 1;


            if($request->file("type_image")) {
                $type_image = $request->file("type_image");
                $destinationPath =  base_path('uploads/products/');
                $file_name = 'product-type-'. time() . "." . $type_image->getClientOriginalExtension();
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
                Helper::uploadTempImageWithSize($destinationPath, $type_image, $file_name, $image_size);
                $product_type->type_image = $file_name;
            }


            $product_type->save();
            return redirect(route('product-types'))->with('success', "Product type Added");
        }
    }

    function edit_product_type(Request $request)
    {
        try {
            $data = $request->all();
            $id = $request->id;

            $product_type = ProductType::query()
                ->where('id', '=',  $id)
                ->first();

            $parent_types = ProductType::select('*')
                ->wherein("status", array(0, 1))
                ->where('parent_id', '=',  0)
                ->get();

            return view('admin/product_type/edit', compact('product_type','parent_types'));
        } catch (\Exception $exception) {
            return redirect(route('product-types'))->withInput($request->all())->with('error', $exception->getMessage());
        }
    }

    public function edit_product_type_submitted(Request $request){
        if($request->IsMethod("post")){
            $validated = $request->validate([
                'type_name' => 'required',
            ]);

            $id = $request->id;
            $product_type = ProductType::query()
                ->where('id', '=',  $id)
                ->first();

            $product_type->type_name = $request->type_name;
            $product_type->type_description = $request->type_description;
            $product_type->parent_id = $request->parent_id ?? 0;
           // $product_type->minimum_order_quantity = $request->minimum_order_quantity ?? 1;
            $product_type->case_pack = $request->case_pack ?? 1;

            if($request->hasFile("type_image")) {
                $type_image = $request->file("type_image");
                $destinationPath =  base_path('uploads/products/');
                $file_name = 'product-type-' . time() . "." . $type_image->getClientOriginalExtension();
                $image_size = array(
                    'small' => array(
                        'width' => 200,
                        'height' => 150,
                    ),
                    'medium' => array(
                        'width' => 500,
                        'height' => 500,
                    )
                );
                Helper::uploadTempImageWithSize($destinationPath, $type_image, $file_name, $image_size);
                $product_type->type_image = $file_name;
            }

            $product_type->save();
            return redirect(route('product-types'))->with('success', "Product type updated");
        }
    }

    function change_product_type_status(Request $request)
    {
        $data = $request->all();
        $id = base64_decode($request->id);
        $sid = explode(":", $id)[0];
        $status = explode(":", $id)[1];

        $product_type = ProductType::query()
            ->select("id", "status")
            ->where("id", "=", $sid)
            ->first();
        $product_type->status = $status;
        $product_type->save();
        return redirect(route('product-types'))->with('success', "Status Changed");

    }

    public function delete_product_type_photo(Request $request){

        $id = $request->product_type_id;
        $product_type = ProductType::query()
            ->where('id', '=',  $id)
            ->first();

        $product_type->type_image = '';
        $product_type->save();

        return response()->json([
            'message'   =>  'Artist updated',
            'class_name'  => 'alert alert-success',
            'status'  => 'success',
        ]);
    }

    function save_case_pack(Request $request)
    {
        $data = $request->all();
        $case_pack = $request->case_pack;
        $type_id = $request->type_id;
        if($case_pack > 0) {
            $product_type = ProductType::query()
                ->select("id", "status")
                ->where("id", "=", $type_id)
                ->first();
            $product_type->case_pack = $case_pack;
            $product_type->save();

            return response()->json([
                'message' => 'Case Pack Updated',
                'class_name' => 'alert alert-success',
                'status' => 'success',
            ]);
        }
        return response()->json([
            'message' => 'Error',
            'status' => 'error',
        ]);
    }


    //-----------------------------

}
