<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo e(asset('/assets/frontend-assets/css/slick.css')); ?>"/>
<?php $__env->stopPush(); ?>

<?php // The will be used only for SEO purpose ?>
<?php $__env->startPush('structured_data_markup'); ?>
    <script type="application/ld+json">{
  "@context": "http://schema.org",
  "@type": "Person",
  "name": "<?php echo e($artist->display_name ?? ''); ?>",
  "url": "<?php echo e(url()->current()); ?>",
  "mainEntityOfPage": {
    "@type": "CreativeWork",
    "about": "<?php echo $artist->description ?? ''; ?>",
    "creator": {
      "@type": "Person",
      "name": "Sara Fitz",
      "sameAs": "<?php echo e(url()->current()); ?>"
    }
  },
  "worksFor": {
    "@type": "Organization",
    "name": "Trays4.us",
    "url": "<?php echo e(route('home')); ?>",
    "description": "An e-commerce site selling custom wooden trays featuring different artists",
    "sameAs": "<?php echo e(route('home')); ?>"
  },
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
          "name": "LICENSE ARTWORK",
          "item": "<?php echo e(route('license-artwork')); ?>"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "<?php echo e($artist->display_name ?? ''); ?>",
          "item": "<?php echo e(route('artist-detail',['slug' =>$artist->artist_slug ])); ?>"
        }
    ]
  }
}
</script>
<?php $__env->stopPush(); ?>


<?php $__env->startSection('content'); ?>
    <section class="tfu-artist-detial-header" >
        <div class="container-fluid">
            <div class=" tfu-general-breadcumb-wrapper" >

                <div class="tfu-artist-detail-heading" >
                    <h1><?php echo e($artist->display_name); ?></h1>
                </div>

               <ul class="shop-breadcrumb">
                   <li><a href="<?php echo e(route('home')); ?>" >Home</a></li>
                   <li><a href="<?php echo e(route('license-artwork')); ?>" >License Artwork </a></li>
                   <li><?php echo e($artist->display_name); ?></li>
               </ul>

            </div>



            <?php /*

            <div class="tfu-shop-filter-btn" >

                <button class="tfu-btn-filter">Filter<span><img src="{{ asset('/assets/frontend-assets/svg/filter-plus.svg') }}" /></span></button>

            </div> */ ?>
        </div>

    </section>


    <section class="tfu-artist-detial-wrapper" >

        <div class="container-fluid">

            <div class="row">

                <div class="col-xl-12">

                    <div class="tfu-artwork-slider-handler" >

                        <div class="tfu-artwork-slider-for">

                            <div class="row tfu-slider-artwork-handler">

                                <div class=" col-12 col-sm-6  col-md-5 col-lg-4  col-xl-4  col-xxl-3">


                                <div class="licence_author_img">

                                        <?php if( !empty($artist->artist_photo) && \Storage::disk('uploads')->exists('/users/' .$artist->artist_photo)): ?>

                                            <img src="<?php echo e(url('uploads/users/'.$artist->artist_photo)); ?>" alt="<?php echo e($artist->artist_photo ?? ''); ?>"/>

                                        <?php else: ?>

                                            <img src="<?php echo e(asset('/assets/frontend-assets/images/no-image.png')); ?>" alt="no-image.png" />

                                        <?php endif; ?>

                                    </div>


                                </div>

                                <div class="col-12 col-sm-6  col-md-7  col-lg-8 col-xl-8  col-xxl-9 tfu-artist-d-col ">

                                  <div class="licence_author_logo">

                                      <?php if( !empty($artist->artist_logo) && \Storage::disk('uploads')->exists('/users/' .$artist->artist_logo)): ?>

                                          <img src="<?php echo e(url('uploads/users/'.$artist->artist_logo)); ?>" alt="<?php echo e($artist->artist_logo ?? ''); ?>" class="author-logo-handler"/>

                                      <?php endif; ?>

                                  </div>

                                   <div class="licence_author_content">

                                       <?php /*<h2>{{ $artist->first_name }} {{ $artist->last_name }}</h2> */ ?>

                                      <p><?php echo $artist->description ?? ''; ?></p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>



    <section class="tfu-artist-detial-products" >

        <div class="container-fluid">
            <div class="tfu-artist-design-author" >
                <h2 class="tfu-catalog-product-title" >CATALOG</h2>
              <p>Products by this artist:</p>
            </div>
            <?php if($product_by_artists->isNotEmpty()): ?>

            <div class="row load_product_row" id="">



                <?php $__currentLoopData = $product_by_artists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php
                        $getProductTypeDetail = array();
                        if(isset($product->pt_sub_id) AND $product->pt_sub_id > 0)
                          $getProductTypeDetail  = \App\Traits\Definations::getProductTypeDetail($product->pt_sub_id);

                         // Get minimam order quantity and case pack from customizable_type_relation table
                         $moq_case_pack = array();
                         if(isset($product->product_customizable) AND isset($product->pt_sub_id))
                            $moq_case_pack  = \App\Models\Helper::get_moq_case_pack($product->product_customizable,$product->pt_sub_id);
                    ?>

                    <div class="col-lg-3 col-sm-4  col-6" id="product_<?php echo e($product->pid); ?>">

                        <div class="tfu-card-wrapper">
                            <div class="tfu-card-header">
                                <a href="<?php echo e(route('product-detail',['slug' => $product->product_slug ])); ?>">
                                <?php if($product->badge && $product->color): ?>
                                    <div class="tfu-card-product-ribbon"  >
                                        <div class="tfu-ribbon tfu-ribbon-top-left"><span style = "background:<?php echo e($product->color); ?>;" ><?php echo e($product->badge); ?></span></div>
                                    </div>
                                <?php endif; ?>

                                    <div class="tfu-product-card-img">
                                        <img class="card-img" src="<?php echo e(url('uploads/products/medium-'.$product->feature_image)); ?>" alt="<?php echo e($product->feature_image ?? ''); ?>">
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
                                        <a href="javascript:void(0)"  rel="nofollow" class="tfu_add_wish_list <?php echo e($alreadyInWishlist ? 'already_wish_list' : ''); ?>" data-pid="<?php echo e($product->pid); ?>">
                                            <img src="<?php echo e(asset('/assets/frontend-assets/svg/'.$wishlist_icon_name)); ?>" alt="<?php echo e($wishlist_icon_name ?? ''); ?>">
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
                                    <h3 class="tfu-card-title"> <?php echo Str::limit($product->product_name, 20, ' ...'); ?></h3>
                                </a>

                                <h4 class="tfu-card-subtitle" ><?php echo e($product->display_name); ?></h4>

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
                <?php /*

                <div class="col-xl-12" >

                    <button class="tfu-product-load-more" id="load_more_btn">See More...</button>

                </div> */ ?>
            </div>
            <?php else: ?>
                <p>Record not found</p>
            <?php endif; ?>
        </div>
    </section>
    <?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('/assets/frontend-assets/js/slick.min.js')); ?>"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){

        $('.tfu-slider-nav-license-artwork').slick({

            slidesToShow: 8,

            slidesToScroll: 1,

            arrows: true,

            infinite: true,

            focusOnSelect: true,

            responsive: [

                {

                  breakpoint: 1024,

                  settings: {

                    slidesToShow: 5,

                    slidesToScroll: 1,

                  },

                },

                {

                  breakpoint: 768,

                  settings: {

                    slidesToShow: 3,

                    slidesToScroll: 1,

                  },

                },

                {

                  breakpoint: 576,

                  settings: {

                    slidesToShow: 2,

                    slidesToScroll: 1,

                  },

                },

              ],

            prevArrow: $('.custom-prev-arrow-artwork'),
            nextArrow: $('.custom-next-arrow-artwork')
        });
    });
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/frontend/artist/artist-detail.blade.php ENDPATH**/ ?>