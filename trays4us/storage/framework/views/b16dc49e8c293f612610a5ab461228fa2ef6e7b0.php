<?php $__env->startSection('content'); ?>

    <section class="ftu-whishlist-menu-wrapper">
        <div class=" tfu-general-breadcumb-wrapper">
            
            <div class="tfu-general-heading">
                <h1>MY ACCOUNT</h1>
            </div>
        </div>


        <div class="row   tfu-dashboard-handler" >

            <ul class="tfu-dashboard-menu-link">

                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="<?php echo e(route('my-account')); ?>" >Details</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="<?php echo e(route('wishlist')); ?>"  >Wishlists</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="<?php echo e(route('my-order')); ?>" class="tfu-active"  style="font-weight:800;" >Orders</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="<?php echo e(route('cart')); ?>" >Cart</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>

            </ul>

        </div>

        

        <?php if($my_orders->isNotEmpty()): ?>
            <?php $__currentLoopData = $my_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $my_order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $order_total_price = 0;
                    $order_status  = \App\Traits\Definations::getOrderStatusClass($my_order->status);
                    $shiping_fee = $my_order->shipping_cost;
                    $totalAmount = $my_order->orderItems->sum(function ($item) {
                        return $item->sale_price * $item->quantity;
                    });


                ?>
                <div class="tfu-order-table-handler" id="order_<?php echo e($my_order->id); ?>">

                    <div class="row">
                        <div class="col-8 col-sm-7 col-md-8 col-lg-8 col-xl-8">
                            <div class="tfu-order-information" >
                                <h6>Order Number : <span><?php echo e($my_order->order_number); ?></span></h6>
                                <h5>Tracking id: <span><?php echo e($my_order->tracking_id ? $my_order->tracking_id : 'Not available yet'); ?></span></h5>

                                <table class="table table-borderless tfu-order-track-info" >
                                    <tr class="tfu-order-table-heading">
                                        <td>Shipping Date</td>
                                        <td>Total </td>
                                        <td>Shipping cost</td>
                                    </tr>
                                    <tr>
                                        <td> <p>  <?php echo e(date('m/d/Y', strtotime($my_order->estimated_ship_date))); ?>  </p></td>
                                        <td>  <h4 class="tfu-order-bold-price" > <span> $<?php echo e(number_format($totalAmount + $shiping_fee, 2)); ?></span></h4></td>
                                        <td> <h4 class="tfu-order-unbold-price" >  <span> $<?php echo e(number_format($shiping_fee, 2)); ?> </span></h4></td>
                                    </tr>
                                </table>
                                <?php /*<h5>{{ date('d/m/Y', strtotime($my_order->estimated_ship_date)) }}</h5> */ ?>
                                <h4>Status : <span><?php echo e($order_status[1]  ?? ''); ?></span></h4>

                            </div>
                        </div>

                        <div class="col-4 col-sm-5 col-md-4 col-lg-4 col-xl-4">
                            <div class="tfu-order-invoice" >
                                <p>Order Placed : <span> <?php echo e(date('m/d/Y', strtotime($my_order->created_at))); ?></span></p>
                                <h6><a href="mailto:support@trays4.us?subject=Need help #<?php echo e($my_order->order_number); ?>" >Support</a></h6>
                                <?php if(!empty($my_order->quick_book_link)): ?>
                                    <h6><a href="<?php echo e($my_order->quick_book_link); ?>" target="_blank">Invoice</a></h6>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>


                    <table class="table table-borderless" >
                        <tbody>
                        <?php $__currentLoopData = $my_order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                //print_r($order_item->product->product_slug);exit;
                              //print_r($order_item->product->wishlist->id);exit;
                            ?>
                            <tr id="tr_<?php echo e($my_order->id); ?>" class="cart_tr tfu_product_qty_wrapper">

                                <td class="align-middle tfu-order-whislist-mr-start">

                                    <?php
                                        $alreadyInWishlist = isset($order_item->product->wishlist->id) && ($order_item->product->wishlist->id > 0);
                                        $wishlist_icon_name = 'whishlist-without-heart.svg';
                                        if($alreadyInWishlist)
                                            $wishlist_icon_name = 'whishlist-heart.svg';
                                    ?>
                                    <a href="javascript:void(0)"  rel="nofollow" class="cart_whishlist_product_btn tfu_add_wish_list <?php echo e($alreadyInWishlist ? 'already_wish_list' : ''); ?>" data-pid="<?php echo e($order_item->product_id); ?>">
                                        <div class="cart-whishlist-product">
                                            <img src="<?php echo e(asset('/assets/frontend-assets/svg/'.$wishlist_icon_name)); ?>" alt="<?php echo e($wishlist_icon_name ?? ''); ?>">
                                        </div>
                                    </a>
                                </td>

                                <td class="align-middle">
                                    <div class="tfu-img-cart">
                                        <a href="<?php echo e(route('product-detail',['slug' => $order_item->product->product_slug ])); ?>">
                                            <?php if( !empty($order_item->product->feature_image) && \Storage::disk('uploads')->exists('/products/small-'.$order_item->product->feature_image)): ?>
                                                <img src="<?php echo e(url('uploads/products/small-'.$order_item->product->feature_image)); ?>" alt="<?php echo e($order_item->product->feature_image ?? ''); ?>" />
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="tfu-cart-menu-product-info" >
                                        <a href="<?php echo e(route('product-detail',['slug' => $order_item->product->product_slug ])); ?>"><h2><?php echo $order_item->product->product_name; ?></h2></a>
                                        <a href="<?php echo e(route('artist-detail',['slug' => $order_item->product->artist->artist_slug ])); ?>"><h3><?php echo e($order_item->product->artist->display_name ??  $order_item->product->artist->first_name); ?></h3></a>
                                    </div>
                                    <div class=" tfu-order-mr-hide-show"  >
                                        <?php
                                            $getProductTypeDetail = array();
                                            if(isset($order_item->productPrice->pt_sub_id) AND $order_item->productPrice->pt_sub_id > 0)
                                              $getProductTypeDetail  = \App\Traits\Definations::getProductTypeDetail( $order_item->productPrice->pt_sub_id);
                                        ?>

                                        <h5><?php echo $getProductTypeDetail->child->type_name ?? ''; ?>  <?php echo $getProductTypeDetail->type_name ?? ''; ?></h5>
                                        <h5><?php echo e($order_item->product->product_sku); ?></h5>
                                    </div>
                                </td>
                                <td class="align-middle tfu-order-mr-hide">
                                    <?php
                                        $getProductTypeDetail = array();
                                        if(isset($order_item->productPrice->pt_sub_id) AND $order_item->productPrice->pt_sub_id > 0)
                                          $getProductTypeDetail  = \App\Traits\Definations::getProductTypeDetail( $order_item->productPrice->pt_sub_id);
                                    ?>

                                    <h5><?php echo $getProductTypeDetail->child->type_name ?? ''; ?> <?php echo $getProductTypeDetail->type_name ?? ''; ?> </h5>
                                    <h5><?php echo e($order_item->product->product_sku); ?></h5>
                                </td>

                                <?php
                                    $total_item_price = $order_item->sale_price * $order_item->quantity;
                                    $formatted_item_total_price = number_format($total_item_price, 2);
                                    $order_total_price += $total_item_price;
                                ?>
                                <td class="align-middle tfu-mr-total-price-order-ds">
                                    <div class="tfu-cart-product-price" >
                                        <h2><span>$</span><?php echo e($order_item->sale_price); ?> </h2>
                                        <span> <?php echo e((isset($site_management->msrp_price) && $site_management->msrp_price > 0 ) ? 'MSRP $'.number_format(ceil($site_management->msrp_price * $total_item_price),2)  : ''); ?></span>
                                    </div>
                                </td>

                                <td class="align-middle">
                                    <div class="tfu-cart-product-price tfu-mr-total-price-order" >
                                        <h2><span>$</span><?php echo e($order_item->sale_price); ?> </h2>
                                        <span> <?php echo e((isset($site_management->msrp_price) && $site_management->msrp_price > 0 ) ? 'MSRP $'.number_format(ceil($site_management->msrp_price * $total_item_price),2)  : ''); ?></span>
                                    </div>

                                    <div class="tfu-cart-total-price" >
                                        <h3>  <?php echo e($order_item->quantity); ?>

                                            <span class="">($<?php echo e($formatted_item_total_price); ?>)</span></h3>
                                    </div>
                                    <div class="tfu-buy-wishlist-price tfu-buy-wishlist-price-mr">
                                        <?php if($order_item->product->status == 1): ?>
                                            <a href="javascript:void(0)"  rel="nofollow" class="add_to_cart" data-pid="<?php echo e($order_item->product_id); ?>">Add to cart</a>
                                        <?php else: ?>
                                            <a href="javascript:void(0)"  rel="nofollow" class="">Not available</a>
                                        <?php endif; ?>
                                    </div>

                                </td>

                                <td class="align-middle tfu-order-add-to-cart-mr" id="product_<?php echo e($order_item->product_id); ?>">
                                    <div class="tfu-buy-wishlist-price   ">
                                        <?php if($order_item->product->status == 1): ?>
                                            <a href="javascript:void(0)"  rel="nofollow" class="add_to_cart" data-pid="<?php echo e($order_item->product_id); ?>">Add to cart</a>
                                        <?php else: ?>
                                            <a href="javascript:void(0)"  rel="nofollow" class="">Not available</a>
                                        <?php endif; ?>
                                        <div class="tfu-product-cart-alert">
                                            <p class="already_item_cart" style="margin-bottom: -14px "></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle tfu-order-whislist-mr" >

                                    <?php
                                        $alreadyInWishlist = isset($order_item->product->wishlist->id) && ($order_item->product->wishlist->id > 0);
                                        $wishlist_icon_name = 'whishlist-without-heart.svg';
                                        if($alreadyInWishlist)
                                            $wishlist_icon_name = 'whishlist-heart.svg';
                                    ?>
                                    <a href="javascript:void(0)"  rel="nofollow" class="cart_whishlist_product_btn tfu_add_wish_list <?php echo e($alreadyInWishlist ? 'already_wish_list' : ''); ?>" data-pid="<?php echo e($order_item->product_id); ?>">
                                        <div class="cart-whishlist-product">
                                            <img src="<?php echo e(asset('/assets/frontend-assets/svg/'.$wishlist_icon_name)); ?>" alt="<?php echo e($wishlist_icon_name ?? ''); ?>">
                                        </div>
                                    </a>
                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <tr class="tfu-whishlist-total-list-price">
                            <td class="align-middle tfu-order-whislist-mr-start" >

                                <?php
                                    $alreadyInWishlist = isset($order_item->product->wishlist->id) && ($order_item->product->wishlist->id > 0);
                                    $wishlist_icon_name = 'whishlist-without-heart.svg';
                                    if($alreadyInWishlist)
                                        $wishlist_icon_name = 'whishlist-heart.svg';

                                ?>
                                <a href="javascript:void(0)" rel="nofollow"  class="cart_whishlist_product_btn tfu_add_wish_list <?php echo e($alreadyInWishlist ? 'already_wish_list' : ''); ?>" data-pid="<?php echo e($order_item->product_id); ?>"  rel="nofollow">
                                    <div class="cart-whishlist-product">
                                        <img src="<?php echo e(asset('/assets/frontend-assets/svg/'.$wishlist_icon_name)); ?>" alt="<?php echo e($wishlist_icon_name ?? ''); ?>">
                                    </div>
                                </a>
                            </td>

                            <td class="align-middle  tfu-order-mr-hide"></td>
                            <td class="align-middle tfu-order-mr-hide-order"> </td>
                            <td class="align-middle tfu-order-mr-hide-order-2"> </td>
                            <td class="align-middle">
                                <div class="tfu-whishlist-total-list-price tfu-total-heading">
                                    <h3>Total :</h3>
                                </div>
                            </td>

                            <td class="align-middle">
                                <div class="tfu-whishlist-total-list-price tfu-total-price">
                                    <h3><span class="price_6">$<?php echo e(number_format($order_total_price + $shiping_fee, 2)); ?></span></h3>
                                </div>
                            </td>
                            <?php /*
                            <td class="align-middle">
                                <div class="tfu-buy-wishlist-price">
                                    <a href="javascript:void(0)"  class="add_all_to_cart"> Add to Cart</a>
                                </div>
                            </td> */ ?>
                            <td class="align-middle">
                                <div class="tfu-buy-wishlist-price">
                                    <a href="javascript:void(0)"  class="tfu_add_all_item_to_cart"  data-oid="<?php echo e($my_order->id); ?>" rel="nofollow">Repeat Order</a>
                                </div>
                            </td>

                            <td class="align-middle tfu-order-whislist-mr" >

                                <?php

                                    $customFunctionResult = \App\Models\Wishlist::checkAllOrderItemsInWishlist($my_order->id);
                                     $alreadyInWishlist = false;
                                    $wishlist_icon_name = 'whishlist-without-heart.svg';
                                    if(!$customFunctionResult) {
                                        $wishlist_icon_name = 'whishlist-heart.svg';
                                        $alreadyInWishlist = true;
                                   }

                                ?>
                                <a href="javascript:void(0)" <?php echo e($customFunctionResult); ?> class="cart_whishlist_product_btn tfu_add_all_item_wishlist <?php echo e($alreadyInWishlist ? 'already_wish_list' : ''); ?>" data-oid="<?php echo e($my_order->id); ?>"  rel="nofollow">
                                    <div class="cart-whishlist-product">
                                        <img src="<?php echo e(asset('/assets/frontend-assets/svg/'.$wishlist_icon_name)); ?>" alt="<?php echo e($wishlist_icon_name ?? ''); ?>">
                                    </div>
                                </a>
                            </td>


                        </tr>

                        </tbody>
                    </table>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="tfu-cart-empty">
                <img src="<?php echo e(asset('/assets/frontend-assets/svg/tfu-empty-box.svg')); ?>" alt="tfu-empty-box.svg" />
                <p>Record not found</p>
            </div>
        <?php endif; ?>

        <?php echo e($my_orders->links('pagination.custom')); ?>


    </section>

<?php $__env->stopSection(); ?>



<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript">
        $(document).ready(function() {

            //----------------------------------------------------------------------------------------

            $(document).on("click",".tfu_add_all_item_wishlist",function() {
                let _this = $(this);
                let oid = _this.attr('data-oid');
                $.ajax({
                    url: "<?php echo e(route('add-to-wishlist-all-ordered-item')); ?>",
                    type: "POST",
                    data: {"_token": "<?php echo e(csrf_token()); ?>", "order_id": oid},
                    success: function(response) {
                        if(response.status == 'success') {
                            $('#order_'+oid).removeClass('already_wish_list');
                            $('#order_'+oid).find('.tfu_add_wish_list img').attr('src',response.whishlist_icon);
                            $('#order_'+oid).find('.cart-whishlist-product img').attr('src',response.whishlist_icon);
                        }
                    },
                    error: function(xhr) {
                        // Handle the error (e.g., display an error message)
                        console.error(xhr);
                    }
                });
            });

            //----------------------------------------------------------------------------------------

            $(document).on("click",".tfu_add_all_item_to_cart",function() {
                let _this = $(this);
                let oid = _this.attr('data-oid');
                $.ajax({
                    url: "<?php echo e(route('add-to-cart-all-ordered-item')); ?>",
                    type: "POST",
                    data: {"_token": "<?php echo e(csrf_token()); ?>", "order_id": oid},
                    success: function(response) {
                        if(response.status == 'success') {
                            Swal.fire({
                                type: 'success',
                                title: 'All order item has been added to cart',
                                showConfirmButton: false,
                                timer: 2800
                            });
                            setTimeout(function(){ window.location = response.redirect_url }, 3000);
                        }
                    },
                    error: function(xhr) {
                        // Handle the error (e.g., display an error message)
                        console.error(xhr);
                    }
                });
            });

        });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/frontend/my-account/my-orders.blade.php ENDPATH**/ ?>