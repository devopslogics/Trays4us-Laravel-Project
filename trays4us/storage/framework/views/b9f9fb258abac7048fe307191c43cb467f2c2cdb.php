<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" type="text/css" media="all" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css"/>
    <style>
      .tfu-dropdown {
          position: relative;
          display: inline-block;
        }

        .tfu-dropdown-toggle {
            position: relative;
          background: none;
          border: none;
          font-size: 20px;
          z-index: 999999;
          cursor: pointer;
        }

        .tfu-dropdown-menu {
            display: none;
            position: absolute;
            top: 0;
            list-style-type: none;
            right: 0;
            background: white;
            border: 1px solid #ccc;
            padding: 32px 0px 24px 16px;
            width: 180px;
            z-index: 99999;
        }

        a.tfu_add_wish_list {
            padding: 4px 8px;
        }
        ul.tfu-dropdown-menu li {
            font-family: 'Noto Sans';
            font-weight: 400;
            color: #000;
            font-size: 21px;
            padding: 2px 0;
        }
        .tfu-dropdown li a {
    color: #000;
    text-decoration: none;
}
@media  only screen and (max-width: 1200px ) {
    .tfu-card-img-overlay {
    top: 4px;
    right: 6px;
}
}
@media  only screen and (max-width: 576px ) {
.tfu-dropdown-menu {
    top: 6px;
    padding: 28px 0px 18px 12px;
    width: 100px;
}
.tfu-card-img-overlay {
        top: -2px;
    }
    .tfu-card-header {
    padding: 10px 0px;
    }
}

    </style>
<?php $__env->stopPush(); ?>

<?php // The will be used only for SEO purpose ?>
<?php $__env->startPush('structured_data_markup'); ?>
  <script type="application/ld+json">{
  "@context": "https://schema.org",
   "@type": "Organization",
    "url":"<?php echo e(url()->current()); ?>",
    "name":"<?php echo e($page_title); ?>",
    "description":"<?php echo e($page_description); ?>",
    "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "<?php echo e(url()->current()); ?>",
    "breadcrumb": {
      "@type": "BreadcrumbList",
      "itemListElement": [
          {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "<?php echo e(route('home')); ?>"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Products",
          "item": "<?php echo e(route('frontend.products')); ?>"
        }
      ]
    }
  }
}
 </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<section  class="ftu-shop-wholesale-wrapper">
    <div class="container-fluid">

        <?php if($search_flag): ?>
            <div class="row">
                <div class="col-xl-12" >
                    <div class="alert alert-danger alejrt-block">
                        <button type="button" class="close" data-bs-dismiss="alert" style="margin-top: -4px;">×</button>
                        <strong>Search "<?php echo e($_GET['search_by']); ?>" not found </strong>
                    </div>
                    <div class="tfu-alert tfu-alert-success" id="contact_email_wrapper">
                        <strong>Submit a request and we will get back to you with a few different designs.</strong>
                        <form class="row tfu-email-design-form" action="">
                            <div class="col-8 col-sm-6  col-md-5  col-lg-3 p-1">
                              <input type="email" id="contact_email" value="<?php echo e(Session::get('is_customer')->email ?? ''); ?>" class="form-control" id="tfu-email-design-input" placeholder="myemail@web.com">
                            </div>
                            <div class="col-4 col-sm-4 col-md-3 col-lg-2 p-1">
                              <button type="button" class="btn tfu-email-btn" id="contact_email_btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="tfu-general-breadcumb-wrapper" >
            
            <div class="tfu-general-heading" >
                <h1>Products</h1>
            </div>
        </div>

        <div class="tfu-general-breadcumb-wrapper" >
            <ul class="shop-breadcrumb">
                <li><a href="<?php echo e(route('home')); ?>" >Home</a></li>
                <li><a href="#" >Products</a></li>
            </ul>
        </div>

         <div class="row">
            <div class="col-xl-12" >

              <div class="tfu-shop-filter-wrapper" >

                <div class="tfu-shop-filter-btn" >
                  <button class="tfu-btn-filter">Search Filter <span><img src="<?php echo e(asset('/assets/frontend-assets/svg/down_arrow.svg')); ?>" data-up="<?php echo e(asset('/assets/frontend-assets/svg/up_arrow.svg')); ?>" data-down="<?php echo e(asset('/assets/frontend-assets/svg/down_arrow.svg')); ?>"  alt="down-arrow.svg" /></span></button>
                  <a href="<?php echo e(route('frontend.products')); ?>" class="reset-btn-filter">Reset</a>
                  <div id="selected_filter">
                    <?php echo $selected_filter; ?>

                  </div>
                </div>
                <div id="tfu-shop-filter-handler" class="tfu-shop-filter-popup" >
                  <div class="tfu-shop-filter-content">

                     <form action="#"  method="get" class="tfu-filter-search-form" id="tfu_filter_search_form">
                        <div class="row">
                          <div class="col-xl-12" >
                              <div class="row m-0  d-flex justify-content-between ">

                                <div class="col-xl-2 p-0">
                                  <div class="tfu-filter-check-box-handler tfu_product_type">
                                    <h3>Product type</h3>
                                      <?php if($product_types->isNotEmpty()): ?>
                                          <?php $__currentLoopData = $product_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <div class="form-check parent_ptype">
                                                  <input class="form-check-input tfu_parent_ptype" type="checkbox" name="parent_type[]" value="<?php echo e($product_type->id); ?>" id="pt_id_<?php echo e($product_type->id); ?>" <?php echo e((isset($_GET['parent_type']) && in_array($product_type->id,$_GET['parent_type'])) ? 'checked' : ''); ?>>
                                                  <label class="form-check-label fw-600" for="pt_id_<?php echo e($product_type->id); ?>"><?php echo e($product_type->type_name); ?></label>
                                              </div>
                                              <?php $__currentLoopData = $product_type->childTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                  <div class="form-check child_ptype parent_<?php echo e($product_type->id); ?>">
                                                      <input class="form-check-input tfu_child_type" type="checkbox" name="child_type[]" data-parent-type="<?php echo e($product_type->id); ?>" value="<?php echo e($childType->id); ?>" id="pt_id_<?php echo e($childType->id); ?>" <?php echo e((isset($_GET['child_type']) && in_array($childType->id,$_GET['child_type'])) ? 'checked' : ''); ?>>
                                                      <label class="form-check-label ms-3" for="pt_id_<?php echo e($childType->id); ?>"><?php echo e($childType->type_name); ?></label>
                                                  </div>
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      <?php endif; ?>
                                  </div>
                                </div>

                                <?php
                                    $country_id = 231;
                                    if(isset($_GET['country']) && $_GET['country'] > 0) {
                                        $country_id = $_GET['country'];
                                    }
                                ?>

                                <div class="col-xl-3  p-0">
                                    <div class="tfu-filter-check-box-handler" >
                                        <h3>Location</h3>
                                        <div class="form-check-select tfu_country">
                                            <div class="form-check">
                                               <?php /* <input class="form-check-input" type="checkbox" value="1" name="country_ck" id="country_ck" {{(isset($_GET['country_ck']) && $_GET['country_ck'] == 1) ? 'checked' : ''}}> */ ?>
                                                <label class="form-check-label" for="country_ck">Country</label>
                                            </div>
                                            <select class="form-select"   name="country" id="country">
                                                <option value="">Select Country</option>
                                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($country->id); ?>"><?php echo e($country->country_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="form-check-select tfu_state">
                                            <div class="form-check">
                                                <?php /* <input class="form-check-input" type="checkbox" value="1" name="state_ck" id="state_ck" {{(isset($_GET['state_ck']) && $_GET['state_ck'] == 1) ? 'checked' : ''}}> */ ?>
                                                <label class="form-check-label" for="state_ck">State</label>
                                            </div>
                                            <select class="form-select" name="state_id" id="state_id">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <?php if($artists->isNotEmpty()): ?>
                                    <div class="col-xl-2  p-0">
                                        <div class="tfu-filter-check-box-handler" >
                                            <h3>Stock Artists</h3>
                                            <div class="tfu_artist">

                                                <?php /*
                                                    <input class="form-check-input" type="checkbox" name="artists[]" value="{{$artists->id}}" id="aritst_id_{{$artists->id}}" {{(isset($_GET['artists']) && in_array($artists->id,$_GET['artists'])) ? 'checked' : ''}}>
                                                    <label class="form-check-label" for="aritst_id_{{$artists->id}}">{{$artists->display_name}}</label>
                                                */ ?>

                                                <select class="artists" id="aritst_id" data-placeholder="Stock Artists" multiple="true" name="artists[]" style="width:200px;">
                                                    <?php $__currentLoopData = $artists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $artists): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($artists->id); ?>" <?php echo e((isset($_GET['artists']) && in_array($artists->id,$_GET['artists'])) ? 'selected' : ''); ?>><?php echo e($artists->display_name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if($product_styles->isNotEmpty()): ?>
                                  <div class="col-xl-2  p-0">
                                        <div class="tfu-filter-check-box-handler" >
                                            <h3>Style</h3>
                                            <?php $__currentLoopData = $product_styles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_style): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="form-check tfu_style">
                                                    <input class="form-check-input" type="checkbox" name="product_style[]" value="<?php echo e($product_style->id); ?>" id="pr_style_<?php echo e($product_style->id); ?>" <?php echo e((isset($_GET['product_style']) && in_array($product_style->id,$_GET['product_style'])) ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="pr_style_<?php echo e($product_style->id); ?>"><?php echo e($product_style->style_name); ?></label>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if($customizables->isNotEmpty()): ?>
                                    <div class="col-xl-2  p-0">
                                        <div class="tfu-filter-check-box-handler" >
                                            <h3>Minimums</h3>
                                            <?php $__currentLoopData = $customizables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customizable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="form-check tfu_customizable">
                                                    <input class="form-check-input" type="checkbox" name="customizable[]" value="<?php echo e($customizable->id); ?>" id="pr_customizable_<?php echo e($customizable->id); ?>" <?php echo e((isset($_GET['customizable']) && in_array($customizable->id,$_GET['customizable'])) ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="pr_customizable_<?php echo e($customizable->id); ?>"><?php echo e($customizable->customizable_name); ?></label>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                              </div>
                           </div>

                           <div class="col-xl-12" >
                                 <div class="tfu-shop-search-form">
                                    <div class="form-group">
                                      <span class="tfu-icon-input-filter-search">
                                        <img src="<?php echo e(asset('/assets/frontend-assets/svg/search-icon.svg')); ?>" alt="filter search">
                                      </span>
                                      <input type="text" class="form-control filter-search tfu_search_by" name="search_by" id="search_by" placeholder="Search..." value=" <?php echo e((isset($_GET['search_by']) && !empty($_GET['search_by'])) ? $_GET['search_by'] : ''); ?>">
                                    </div>
                                    <div class="form-filter-btn">
                                            <button type="button" class="ftu-btn-block" id="tfu_copy_url" style="display: none">Copy</button>
                                            <button type="button" class="ftu-btn-block ftu-filter-search-submit" id="tfu_search_apply" >Apply</button>
                                    </div>
                                </div>
                          </div>

                       </div>
                    </form>

                  </div>
                </div>

               </div>

            </div>
        </div>

        <div class="row">
                 <?php if($products->isNotEmpty()): ?>
                   <div id="load_product_ajax">
                       <div class="row load_product_row" id="">
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                               <?php
                                   $getProductTypeDetail = array();
                                   if(isset($product->pt_sub_id) AND $product->pt_sub_id > 0)
                                     $getProductTypeDetail  = \App\Traits\Definations::getProductTypeDetail($product->pt_sub_id);

                                    // Get minimam order quantity and case pack from customizable_type_relation table
                                    $moq_case_pack = array();
                                    if(isset($product->product_customizable) AND isset($product->pt_sub_id))
                                        $moq_case_pack  = \App\Models\Helper::get_moq_case_pack($product->product_customizable,$product->pt_sub_id);


                                    // This code only will work on customizer means if customer upload from front end their custom images
                                     $html_class  = $tray_type_html_class = '';
                                    if($product->type == 2) {
                                        $tray_type_html_class = 'tray-type-'.$getProductTypeDetail->child->sku;
                                        $html_class  = 'rectangle_image';
                                        if(isset($product->product_sku) AND !empty($product->product_sku))
                                          $html_class  = \App\Traits\Definations::getCustomProductHtmlClass($product->product_sku);
                                    }

                               ?>

                                <div class="col-lg-3 col-sm-4 col-6" id="product_<?php echo e($product->pid); ?>">
                                    <div class="tfu-card-wrapper">

                                        <div class="tfu-card-header">
                                            <a href="<?php echo e(route('product-detail',['slug' => $product->product_slug ])); ?>">
                                                <?php if($product->badge && $product->color): ?>
                                                    <div class="tfu-card-product-ribbon"  >
                                                        <div class="tfu-ribbon tfu-ribbon-top-left"><span style = "background:<?php echo e($product->color); ?>;" ><?php echo e($product->badge); ?></span></div>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="tfu-product-card-img">
                                                    <img class="card-img" src="<?php echo e(url('uploads/products/medium-'.$product->feature_image)); ?>" alt="<?php echo e($product->product_name); ?>">
                                                </div>
                                             </a>
                                            <div class="tfu-card-img-overlay d-flex justify-content-end">
                                                <?php if(Session::has('is_customer') && !empty(Session::get('is_customer'))): ?>
                                                    <?php
                                                        $alreadyInWishlist = isset($product->wid) && ($product->wid > 0);
                                                        $wishlist_icon_name = 'whishlist-without-heart.svg';
                                                        if($alreadyInWishlist)
                                                            $wishlist_icon_name = 'whishlist-heart.svg';
                                                    ?>

                                                    <?php if(isset($product->type) && ($product->type == 2)): ?>
                                                        <div class="tfu-dropdown">
                                                            <button rel="nofollow" class="tfu-dropdown-toggle" >
                                                                <img src="<?php echo e(asset('/assets/frontend-assets/svg/tfu-product-dropdown-icon.svg')); ?>" />
                                                            </button>
                                                            <ul class="tfu-dropdown-menu">
                                                                <li><a href="javascript:void(0)"  rel="nofollow" class="tfu_delete_custom_product" data-pid="<?php echo e($product->pid); ?>">Delete</a></li>
                                                                <?php /*
                                                                <li>Copy</li>
                                                                <li>Edit</li>
                                                                <li>Make Public</li>
                                                                <li>Copy link</li> */ ?>
                                                            </ul>
                                                        </div>
                                                     <?php endif; ?>

                                                    <a href="javascript:void(0)"  rel="nofollow" class="tfu_add_wish_list <?php echo e($alreadyInWishlist ? 'already_wish_list' : ''); ?>" data-pid="<?php echo e($product->pid); ?>">
                                                        <img src="<?php echo e(asset('/assets/frontend-assets/svg/'.$wishlist_icon_name)); ?>" alt="whishlist-heart.svg">
                                                    </a>
                                                <?php else: ?>
                                                    <a href="javascript:void(0)"  rel="nofollow" class="tfu_add_wish_list_popup">
                                                        <img src="<?php echo e(asset('/assets/frontend-assets/svg/whishlist-without-heart.svg')); ?>" alt="whishlist-without-heart.svg">
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="card-body">

                                            <a href="<?php echo e(route('product-detail',['slug' => $product->product_slug ])); ?>">
                                                <h3 class="tfu-card-title" title="<?php echo $product->product_name; ?>"> <?php echo Str::limit($product->product_name, 26, ' ...'); ?></h3>
                                            </a>

                                            <a href="<?php echo e(route('artist-detail',['slug' => $product->artist_slug ])); ?>"><h4 class="tfu-card-subtitle" ><?php echo $product->display_name; ?></h4></a>

                                            <div class="row" >

                                                <div class="col-xl-12">
                                                    <h6 class="tfu-card-subtitle-span "><?php echo e($getProductTypeDetail->child->type_name ?? ''); ?>  <?php echo e($getProductTypeDetail->type_name ?? ''); ?><br> <span><?php echo e($product->product_sku); ?></span></h6>
                                                    <?php if(Session::has('is_customer') && !empty(Session::get('is_customer'))): ?>
                                                        <div class="tfu-buy-cart-price">
                                                            <?php

                                                                $isAddedToCart = ($product->cid ?? 0) > 0;
                                                                $quantity =  $calculted_price = $already_in_cart_price =  0;
                                                                $add_to_cart_string =  $cart_quantity =  $already_in_cart_item_str = '';
                                                                if($isAddedToCart) {
                                                                     $quantity = (isset($moq_case_pack->case_pack) && $moq_case_pack->case_pack > 0) ? $moq_case_pack->case_pack : 1;
                                                                     $calculted_price = number_format($quantity * $product->price, 2);
                                                                     $add_to_cart_string = 'Add '.$quantity.' more to Cart ($'.$calculted_price.')';
                                                                     $cart_quantity = $product->cart_quantity;
                                                                     $already_in_cart_price =  number_format($cart_quantity * $product->price, 2);
                                                                     $already_in_cart_item_str = $cart_quantity.' items in Cart ($'.$already_in_cart_price.')';
                                                                } else {
                                                                     $quantity = (isset($moq_case_pack->minimum_order_quantity) && $moq_case_pack->minimum_order_quantity > 0) ? $moq_case_pack->minimum_order_quantity : 1;
                                                                     $calculted_price = number_format($quantity * $product->price, 2);
                                                                     $add_to_cart_string = 'Add '.$quantity.' to Cart ($'.$calculted_price.')';
                                                                }

                                                            ?>

                                                              <div class="tfu-product-price "><h5>$<?php echo e($product->price); ?> <span><?php echo e((isset($site_management->msrp_price) && $site_management->msrp_price > 0 ) ? 'MSRP $'.number_format(ceil($site_management->msrp_price * $product->price),2)  : ''); ?></span></h5></div>
                                                              <button data-pid="<?php echo e($product->pid); ?>" style="<?php echo e($isAddedToCart ? 'color: #fff; background-color: #FF6600;' : 'color: #FF6600; background-color: #fff;'); ?>" class="add_to_cart"><?php echo e($add_to_cart_string); ?> </button>
                                                               <div class="tfu-product-cart-alert">
                                                                 <p class="already_item_cart"><?php echo e($already_in_cart_item_str); ?></p>
                                                                 <?php /*
                                                                   <div class="tfu-product-popup-cart" >
                                                                    <a href="javascript:void(0)" class="tfu_add_cart_div" >
                                                                        <img src="{{ asset('/assets/frontend-assets/svg/cart_menu_popup.svg') }}" alt="Vans">
                                                                    </a>
                                                                    <span>Added 12 items to Cart ($238.80)</span>
                                                                 </div> */ ?>
                                                               </div>
                                                        </div>
                                                    <?php else: ?>
                                                        <h4 class="tfu-cart-product-msrp" ><?php echo e((isset($site_management->msrp_price) && $site_management->msrp_price > 0 ) ? 'MSRP $'.number_format(ceil($site_management->msrp_price * $product->price),2)  : ''); ?></h4>
                                                    <?php endif; ?>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                       </div>
                   </div>

                    <div class="col-xl-12" >
                        <button class="tfu-product-load-more" id="load_more_btn" style="display: <?php echo e(($last_page > 1) ? 'block' : 'none'); ?>">See More...</button>
                    </div>
                 <?php else: ?>
                     <div class="col-md-12 col-sm-12 col-12">
                         <p style="text-align: center;font-weight: bold; color: #F60;font-family: Bitter;">Products not found</p>
                     </div>
                 <?php endif; ?>
             </div>

     </div>

</section>



<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.js"></script>
    <script type="text/javascript">
        var autoplaySpeed = <?php echo e($site_management->slider_delay); ?>;
        var autoplay = <?php echo e((isset($site_management->slider_auto) && ($site_management->slider_auto == 1)) ? 'true' : 'false'); ?>;
        var ENDPOINT = "<?php echo e(route('filter-products')); ?>";
        var page = 1;

        jQuery(document).ready(function(){

            $("#aritst_id").chosen( { width: '100%' });

            $('#tfu_search_apply').click(function () {
                $.ajax({
                    type: 'get',
                    url: "<?php echo e(route('filter-products')); ?>",
                    data: $('#tfu_filter_search_form').serialize(),
                    success: function (data) {
                        page = 1;
                        if(data.last_page > 1) {
                            $('#load_more_btn').show();
                        } else {
                            $('#load_more_btn').hide();
                        }
                        $('#tfu-shop-filter-handler').hide();
                        $('#load_product_ajax .load_product_row').html(data.html);
                        $('#selected_filter').html(data.selected_filter);
                        if(data.querystring) {
                            window.history.replaceState(null, null, '?' + data.querystring);
                        } else {
                            var uri = window.location.href.toString();
                            if (uri.indexOf("?") > 0) {
                                var clean_uri = uri.substring(0, uri.indexOf("?"));
                                window.history.replaceState({}, document.title, clean_uri);
                            }
                        }
                    },
                    error: function (data) {
                        // Handle errors here.
                    }
                });
            });
            //----------------------------------------------------------------------------------------------------------

            $(document).on("click",".cross_filter",function() {

                if($(this).hasClass('tfu_customizable')) {
                    $('.tfu_customizable input:checkbox').prop('checked', false);
                }
                if($(this).hasClass('tfu_style')) {
                    $('.tfu_style input:checkbox').prop('checked', false);
                }

                if($(this).hasClass('tfu_artist')) {
                    //$('.tfu_artist input:checkbox').prop('checked', false);
                    //$(".tfu_artist #aritst_id").chosen("destroy");
                    $('.tfu_artist #aritst_id').val('');
                    $('.tfu_artist #aritst_id').val('').trigger("chosen:updated");
                }

                if($(this).hasClass('tfu_product_type')) {
                    $('.tfu_product_type input:checkbox').prop('checked', false);
                }

                if($(this).hasClass('tfu_state')) {
                    $('#state_id option:selected').remove();
                }

                if($(this).hasClass('tfu_country')) {
                    $('#country option:selected').remove();
                }

                if($(this).hasClass('tfu_search_by')) {
                    $('.tfu_search_by').val('');
                }

                $(this).closest('.filter_search_ul').find('li').remove();

                $('#tfu_search_apply').trigger('click');
            });

            //----------------------------------------------------------------------------------------------------------

            $(document).on("click",".tfu_parent_ptype",function() {
                var parent_ptype = $(this).val();
                $('.parent_'+parent_ptype+' input[type=checkbox]').not(this).prop('checked', this.checked);
            });

            $(document).on("click",".tfu_child_type",function() {
                var parent_type_id = $(this).attr('data-parent-type');
                var allChecked = $('.parent_'+parent_type_id+' .tfu_child_type').filter(':checked').length == $('.parent_'+parent_type_id+' .tfu_child_type').length;
                $('#pt_id_'+parent_type_id).prop('checked', allChecked);
            });


            //----------------------------------------------------------------------------------------------------------

            $("#load_more_btn").click(function(){
                page++;
                infinteLoadMore(page);
            });

            function infinteLoadMore(page) {
                $.ajax({
                    url: ENDPOINT + "?page=" + page,
                    data: $('#tfu_filter_search_form').serialize(),
                    type: "get",
                    beforeSend: function () {
                        $('.auto-load').show();
                    }
                })
                .done(function (response) {
                    $('.auto-load').hide();
                    if(page <= response.last_page) {
                        $('#load_product_ajax .load_product_row').append(response.html);
                        if(page == response.last_page) {
                            $('#load_more_btn').hide();
                        }
                    }
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
            }

            //----------------------------------------------------------------------------------------------------------

            $("#contact_email_btn").click(function(){
                var emailValue = $('#contact_email').val().trim();

                // Remove existing error message and validate email format
                $('.error-message').remove();
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue)) {
                    $('#contact_email').after('<span class="error-message" style="color: red;margin-top: 11px !important;display: block;">Please enter a valid email address</span>');
                    return;
                }

                $.ajax({
                    url: "<?php echo e(route('search-tag-designs-are-available')); ?>",
                    data: {
                        contact_email: emailValue,
                        search_by: $('#search_by').val(),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    type: "POST",
                    beforeSend: function () {
                        $('.auto-load').show();
                    }
                })
                .done(function (response) {
                    $('.auto-load').hide();
                    $('.success-message').remove();
                    $('#contact_email_wrapper strong').text(response.message);
                    setTimeout(function() {
                        $('#contact_email_wrapper').hide();
                        $('.ftu-shop-wholesale-wrapper .close').trigger('click');
                    }, 5000);

                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
            });

            $(".ftu-shop-wholesale-wrapper .close").click(function(){
                $('#contact_email_wrapper').hide();
            });

            //----------------------------------------------------------------------------------------------------------
            var country_id = $('#country').val();
            if (country_id > 0) {
                get_state_by_country_id(country_id);
            }

            $('#country').change(function () {
                var country_id = $(this).val();
                if (country_id) {
                    get_state_by_country_id(country_id);
                } else {
                    $('#state_id').empty().hide();
                }
            });

            function get_state_by_country_id(country_id) {
                $.ajax({
                    url: "<?php echo e(route('get-state-by-country-id')); ?>",
                    type: 'GET',
                    data: { country_id: country_id },
                    dataType: 'json',
                    success: function (data) {
                        $('#state_id').empty().show();
                        $('#state_id').append('<option value="">Select State</option>');
                        $.each(data, function (key, value) {
                            $('#state_id').append('<option value="' + value.id + '">' + value.state_name + '</option>');
                        });

                        var selectedCity = '<?php echo e(old('state')); ?>';
                        if ($('#state_id option[value="' + selectedCity + '"]').length > 0) {
                            $('#state_id').val(selectedCity);
                        } else {
                            $('#state_id').val('');
                        }
                    }
                });
            }

            //----------------------------------------------------------------------------------------------------------

        });


        document.addEventListener("click", function (event) {
  const dropdown = event.target.closest(".tfu-dropdown");
  const dropdownMenu = dropdown?.querySelector(".tfu-dropdown-menu");

  // Check if the click is inside a dropdown menu
  const isClickInsideMenu = event.target.closest(".tfu-dropdown-menu");

  // Close other open dropdowns unless the click is inside the current menu
  if (!isClickInsideMenu) {
    document.querySelectorAll(".tfu-dropdown-menu").forEach((menu) => {
      if (menu !== dropdownMenu) menu.style.display = "none";
    });
  }

  if (dropdown && dropdownMenu && !isClickInsideMenu) {
    // Toggle dropdown visibility
    dropdownMenu.style.display =
      dropdownMenu.style.display === "block" ? "none" : "block";
  } else if (!dropdown) {
    // Close dropdown if clicked outside
    document.querySelectorAll(".tfu-dropdown-menu").forEach((menu) => {
      menu.style.display = "none";
    });
  }
});


    </script>

<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/frontend/shop/shop-in-wholesale.blade.php ENDPATH**/ ?>