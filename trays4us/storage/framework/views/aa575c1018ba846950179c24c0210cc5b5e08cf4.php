<?php if($filter_products->isNotEmpty()): ?>
    <?php $__currentLoopData = $filter_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

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
                    <?php if($product->badge && $product->color): ?>
                        <div class="tfu-card-product-ribbon"  >
                            <div class="tfu-ribbon tfu-ribbon-top-left"><span style = "background:<?php echo e($product->color); ?>;" ><?php echo e($product->badge); ?></span></div>
                        </div>
                    <?php endif; ?>
                    <a href="<?php echo e(route('product-detail',['slug' => $product->product_slug ])); ?>">
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
                        <h3 class="tfu-card-title"> <?php echo Str::limit($product->product_name, 20, ' ...'); ?></h3>
                    </a>

                    <h4 class="tfu-card-subtitle" ><?php echo $product->display_name; ?></h4>

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
    <?php else: ?>
        <div class="col-md-12 col-sm-12 col-12">
            <p style="text-align: center;font-weight: bold; color: #F60;font-family: Bitter;">Products not found</p>
        </div>
<?php endif; ?>

<?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/frontend/shop/filter-products.blade.php ENDPATH**/ ?>