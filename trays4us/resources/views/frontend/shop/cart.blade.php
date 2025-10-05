@extends('layouts.frontend')
<?php
use Carbon\Carbon;
?>
@push('styles')
    <style>
        .e_shopping_address {
            border: 3px solid red;
            padding: 14px !important;
            color: red;
            border-bottom-width: initial !important;
        }
        .animated-div {
            transition: transform 2s ease;
        }
    </style>
@endpush

@section('content')
    @if($cart_products->isNotEmpty())

        <form method="post" id="cart_form">
            {{ csrf_field() }}
            <section class="ftu-cart-menu-wrapper">

            <div class=" tfu-general-breadcumb-wrapper" >
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif

                <div class="tfu-general-heading" >
                    <span>MY ACCOUNT</span>
                </div>
            </div>

            <div class="row  tfu-dashboard-handler" >

                <ul class="tfu-dashboard-menu-link">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                        <path d="M1 0.5V16" stroke="black"/></svg></span>
                    <li> <a href="{{ route('my-account') }}" >Details</a></li>
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                        <path d="M1 0.5V16" stroke="black"/></svg></span>
                    <li> <a href="{{ route('wishlist') }}">Wishlists</a></li>
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                        <path d="M1 0.5V16" stroke="black"/></svg></span>
                    <li> <a href="{{ route('my-order') }}">Orders</a></li>
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                        <path d="M1 0.5V16" stroke="black"/></svg></span>
                    <li> <a href="{{ route('cart') }}" class="tfu-active" style="font-weight:800;">Cart</a></li>
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                        <path d="M1 0.5V16" stroke="black"/></svg></span>
                </ul>

            </div>

            <div class="tfu-cart-table-handler" >
               <table class="table table-borderless">
                    <tbody>
                            @php
                                 $cart_total_price = 0;
                            @endphp
                            @foreach($cart_products as $cart_product)

                                @php
                                    // Get minimam order quantity and case pack from customizable_type_relation table
                                    $moq_case_pack = array();
                                    if(isset($cart_product->product_customizable) AND isset($cart_product->pt_sub_id))
                                        $moq_case_pack  = \App\Models\Helper::get_moq_case_pack($cart_product->product_customizable,$cart_product->pt_sub_id);

                                @endphp

                                <tr id="tr_{{$cart_product->cid}}" class="cart_tr">
                                    <td class="align-middle tfu-cart-whislist-remove-mr">
                                        <div class="tfu-cart-table-whislist-remove">
                                         @php
                                            $alreadyInWishlist = isset($cart_product->wid) && ($cart_product->wid > 0);
                                            $wishlist_icon_name = 'whishlist-without-heart.svg';
                                            if($alreadyInWishlist)
                                                $wishlist_icon_name = 'whishlist-heart.svg';
                                         @endphp

                                        <a href="javascript:void(0)" class="cart_whishlist_product_btn tfu_add_wish_list {{ $alreadyInWishlist ? 'already_wish_list' : '' }}" data-pid="{{ $cart_product->pid }}"  rel="nofollow">
                                            <div class="cart-whishlist-product">
                                                <img src="{{ asset('/assets/frontend-assets/svg/'.$wishlist_icon_name) }}" alt="{{$wishlist_icon_name}}">
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)" class="cart_remove_product_btn" data-cid="{{$cart_product->cid}}"  rel="nofollow">
                                            <div class="cart-remove-product">
                                                <img  src="{{ asset('/assets/frontend-assets/svg/cart-remove-product.svg') }}" alt="cart-remove-product.svg" />
                                            </div>
                                        </a>

                                       </div>
                                    </td>

                                    <td class="align-middle" >
                                        <div class="tfu-img-cart" >
                                            @if( !empty($cart_product->feature_image) && \Storage::disk('uploads')->exists('/products/small-'.$cart_product->feature_image))
                                                <img src="{{ url('uploads/products/small-'.$cart_product->feature_image) }}" alt="cart-remove-product.svg" />
                                            @endif
                                        </div>
                                    </td>

                                    <td class="align-middle">
                                      <div class="tfu-cart-menu-product-info" >
                                        <a href="{{ route('product-detail',['slug' => $cart_product->product_slug ]) }}"><h2>{!! $cart_product->product_name !!}</h2></a>
                                        <a href="{{ route('artist-detail',['slug' => $cart_product->artist_slug ]) }}"><h3>{!! $cart_product->display_name !!}</h3></a>
                                          <div class="tfu-mr-cart-info" >
                                            <p>{!! $cart_product->type_name !!}</p>
                                            <p>{{$cart_product->product_sku}}</p>
                                          </div>
                                      </div>
                                    </td>
                                    <td class="align-middle tfu-mr-cart" >
                                        <p>{!! $cart_product->type_name !!}</p>
                                        <p>{{$cart_product->product_sku}}</p>
                                    </td>

                                    <td class="align-middle tfu-mr-cart" >
                                      <div class="tfu-cart-product-price" >
                                          <h2><span>$</span>{{$cart_product->price}}</h2>
                                          <span> {{ (isset($site_management->msrp_price) && $site_management->msrp_price > 0 ) ? 'MSRP $'.number_format(ceil($site_management->msrp_price * $cart_product->price),2)  : '' }}</span>
                                     </div>
                                    </td>

                                    <td class="align-middle">
                                        <div class="tfu-cart-product-price tfu-cart-price-sku" >
                                            <h2><span>$</span>{{$cart_product->price}}</h2>
                                            <span> {{ (isset($site_management->msrp_price) && $site_management->msrp_price > 0 ) ? 'MSRP $'.number_format(ceil($site_management->msrp_price * $cart_product->price),2)  : '' }}</span>
                                       </div>
                                      <div class="tfu-cart-product-quantity" >
                                          <?php /*
                                        <div class="ftu_qty_inc_dec">
                                            <i class="ftu-increment ftu_increment_cart" data-cid="{{$cart_product->cid}}"><img src="{{ asset('/assets/frontend-assets/svg/lower-arrow.svg') }}" /></i>
                                            <img class="quanity-line-handler" src="{{ asset('/assets/frontend-assets/svg/quantity-arrow-line.svg') }}" />
                                            <i class="ftu-decrement ftu_decrement_cart" data-cid="{{$cart_product->cid}}"><img src="{{ asset('/assets/frontend-assets/svg/upper-arrow.svg') }}" /></i>
                                        </div>
                                        <input type="text" name="ftu-qty" value="{{$cart_product->quantity}}" data-moq="{{$cart_product->moq}}" data-cp="{{$cart_product->case_pack}}"  class="ftu-product-quantity qty_{{$cart_product->cid}}" readonly />
                                        */ ?>

                                          <div class="tfu-wrapper-shop-select" >
                                              <div class="ftu-wrapper-select-quantity">
                                                  @php
                                                      $moq = (isset($moq_case_pack->minimum_order_quantity) && $moq_case_pack->minimum_order_quantity> 0) ? $moq_case_pack->minimum_order_quantity : 1;
                                                      $calculted_price = $moq * $cart_product->price;

                                                      $total_item_price = $cart_product->price * $cart_product->quantity;
                                                      $formatted_item_total_price = number_format($total_item_price, 2);
                                                      $cart_total_price += $total_item_price;

                                                  @endphp
                                                  <div class="ftu-select-btn-qty">
                                                      <span data-qty="{{$cart_product->quantity}}">{{$cart_product->quantity}}  (${{$cart_product->price * $cart_product->quantity}})</span>
                                                      <img src="{{ asset('/assets/frontend-assets/svg/input-dropdown-icon.svg') }}" alt="input-dropdown-icon.svg"  />
                                                  </div>


                                                  <div class="ftu-select-content-qty">

                                                      <ul class="ftu-qty-options" id="qty_ul_{{$cart_product->cid}}" data-cid="{{$cart_product->cid}}">
                                                          <?php
                                                          $case_pack = (isset($moq_case_pack->case_pack) && $moq_case_pack->case_pack > 0) ? $moq_case_pack->case_pack : 1;
                                                          for ($i = 1; $i <= 5; $i++) {
                                                          $quantity = $case_pack + $moq;
                                                          $calculated_price2 = $quantity * $cart_product->price;

                                                          ?>
                                                          <li onclick="updateName(this)" data-qty="{{$quantity}}" class="update_cart"> {{$quantity}}  (${{$calculated_price2}})</li>
                                                          <?php
                                                            $case_pack += $moq_case_pack->case_pack; // Increment by the original value of case_pack
                                                          }
                                                          $p_quantity = $moq_case_pack->minimum_order_quantity;
                                                          if(isset($product->c_quantity) AND $cart_product->c_quantity> 0)
                                                              $p_quantity = $moq_case_pack->case_pack;
                                                          ?>
                                                      </ul>
                                                      <div class="ftu-qty-input">
                                                            <input data-moq="{{$p_quantity}}" data-cp="{{$moq_case_pack->case_pack}}"  data-price="{{$cart_product->price}}" class="ftu-product-quantity numeric_only" type="text" placeholder="Custom quantity">
                                                            <a href="javascript:void(0)" class="cart_update_product_btn"  rel="nofollow">
                                                                <button type="button" class="update_cart update_cart_btn">Update</button>
                                                            </a>
                                                      </div>
                                                  </div>

                                              </div>
                                          </div>



                                      </div>
                                    </td>
                                    <?php /*
                                     @php
                                         $total_item_price = $cart_product->price * $cart_product->quantity;
                                         $formatted_item_total_price = number_format($total_item_price, 2);
                                         $cart_total_price += $total_item_price;
                                     @endphp

                                    <td class="align-middle">
                                      <div class="tfu-cart-total-price" >
                                          <h3><span>Total : </span> $<span class="price_{{$cart_product->cid}}">{{$formatted_item_total_price}}</span></h3>
                                      </div>
                                    </td> */ ?>

                                    <td class="align-middle tfu-mr-cart" >

                                    </td>

                                    <td class="align-middle tfu-mr-cart " >
                                        <a href="javascript:void(0)"  rel="nofollow" class="cart_remove_product_btn" data-cid="{{$cart_product->cid}}">
                                            <div class="cart-remove-product">
                                                <img  src="{{ asset('/assets/frontend-assets/svg/cart-remove-product.svg') }}" alt="cart-remove-product.svg" />
                                            </div>
                                        </a>
                                    </td>

                                    <td class="align-middle tfu-mr-cart" >

                                        @php
                                            $alreadyInWishlist = isset($cart_product->wid) && ($cart_product->wid > 0);
                                            $wishlist_icon_name = 'whishlist-without-heart.svg';
                                            if($alreadyInWishlist)
                                                $wishlist_icon_name = 'whishlist-heart.svg';
                                        @endphp
                                        <a href="javascript:void(0)"  rel="nofollow" class="cart_whishlist_product_btn tfu_add_wish_list {{ $alreadyInWishlist ? 'already_wish_list' : '' }}" data-pid="{{ $cart_product->pid }}">
                                            <div class="cart-whishlist-product">
                                                <img src="{{ asset('/assets/frontend-assets/svg/'.$wishlist_icon_name) }}" alt="{{$wishlist_icon_name}}">
                                            </div>
                                        </a>
                                    </td>

                                 </tr>

                            @endforeach
                        </tbody>
               </table>
            </div>

            <div class="tfu-cart-item-btn" >
              <a href="{{ route('frontend.products') }}">Add more items</a>
            </div>

        </section>

            <section class="table table-borderless tfu-total-cart-table">
                <div class="row">
                    @if(empty($is_customer->shiping_address1) && empty($is_customer->shiping_address2))
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <div class="ftu-mb-input text-center e_shopping_address">
                                <b>Please add your address before placing the order. Click <a href="{{route('customer-profile')}}" class="ftu-common-btn" style="margin-left: 10px;">Edit Profile</a> to update.</b>
                            </div>
                        </div>

                        @else
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div>
                                <p>
                                    <strong>Shipping to:</strong>
                                    <?php
                                    $address = '';

                                    if ($is_customer->company) {
                                        $address .= trim($is_customer->company);
                                    }
                                    if ($is_customer->shiping_address1) {
                                        $address .= ($address ? ', ' : '') . trim($is_customer->shiping_address1);
                                    }
                                    if ($is_customer->shiping_address2) {
                                        $address .= ($address ? ', ' : '') . trim($is_customer->shiping_address2);
                                    }
                                    if ($is_customer->city) {
                                        $address .= ($address ? ', ' : '') . trim($is_customer->city);
                                    }
                                    if ($is_customer->state) {
                                        $address .= ($address ? ', ' : '') . $is_customer->state->abbrev;
                                    }
                                    if ($is_customer->postal_code) {
                                        $address .= ($address ? ' ' : '') . trim($is_customer->postal_code);
                                    }
                                    if ($is_customer->country) {
                                        $address .= ($address ? ', ' : '') . trim($is_customer->country->country_name);
                                    }
                                    echo $address;
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-2" >
                           <a href="{{route('customer-profile')}}" class="ftu-common-btn" style="margin-left: 10px;">Edit Address</a>
                        </div>
                    @endif
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                        <div class="ftu-mb-input text-center">
                            <textarea id="order_notes" class="tfu-address-handle form-control" name="order_notes" rows="4" cols="50" placeholder="Enter special instructions for your order..."></textarea>
                        </div>
                    </div>
                </div>
            </section>

            <section class="tfu-cart-total-cost-wrapper tfu-total-cart-table">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                        <div class="tfu-cart-total-cost" >
                            <table class="table table-borderless ">
                        <tbody>
                        <tr><td colspan="3" ><div class="tfu-vertical-cart-total-line" ></div></td></tr>

                        @php
                            $estimated_ship_date = Carbon::now()->addDays($site_management->estimated_ship_days);
                        @endphp

                          <tr>
                            <td>
                             <div class="tfu-cart-shipping-detils ">
                               <p>Free shipping for orders ${{$site_management->shipping_threshold}}+   </p>
                               <p> This order will ship from New Hampshire</p>
                               <h6>Expected ship date {{ date('m/d/Y', strtotime($estimated_ship_date)) }}</h6>
                             </div>
                            </td>
                            <td> <div class="tfu-cart-shipping-info tfu-pricing">Shipping </div></td>
                            <td>
                                <div class="cart-shipping-price tfu-pricing" id="shipment_cost">
                                    @if($cart_total_price <= $site_management->shipping_threshold)
                                        @php
                                            $shipment_cost = $site_management->shipping_fee;
                                        @endphp
                                        ${{number_format($shipment_cost, 2)}}
                                   @else
                                        $0.00
                                        @php
                                            $shipment_cost = 0;
                                        @endphp
                                   @endif
                                </div>
                            </td>
                          </tr>
                          <tr><td colspan="3" ><div class="tfu-vertical-cart-total-line" ></div></td></tr>
                          <tr>
                            <td>
                                <div class="tfu-cart-order-invoice" >
                                    After submitting the order, you will receive the invoice from QuickBooks® and the payment term is NET30 is for repeat orders. The invoice can be paid securely via check or credit card.
                               </div>
                            </td>
                            <td> <div class="tfu-cart-overall-totals tfu-pricing">Total: </div></td>
                            <td><div class="cart-shipping-price tfu-pricing" id="final_price">${{number_format($cart_total_price + $shipment_cost, 2)}}</div></td>

                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>
                              <div class="tfu-cart-check-handle">

                               @if((isset($site_management->minimum_order_amount) && $site_management->minimum_order_amount > $cart_total_price ))
                                    <button type="submit" class="ftu-cart-order-submit disabled" id="">Minimum order size ${{$site_management->minimum_order_amount}}</button>
                               @else
                                      <button type="submit" class="ftu-cart-order-submit" id="ftu-cart-order-submit">Place Order</button>
                               @endif
                            </div>

                          </td>
                          </tr>
                      </tbody>
                     </table>
                        </div>
                    </div>
                </div>

        </section>
        </form>
    @else
    <section class="ftu-cart-menu-wrapper">

        <div class=" tfu-general-breadcumb-wrapper" >
            <ul class="shop-breadcrumb">
                <li><a href="{{ route('my-account') }}">My Account</a></li>
                <li>Cart /</li>
            </ul>
            <div class="tfu-general-heading" >
                <h1>MY ACCOUNT</h1>
            </div>
        </div>

        <div class="row  tfu-dashboard-handler" >
            <ul class="tfu-dashboard-menu-link">
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg>
                </span>
                <li> <a href="{{ route('my-account') }}" >Details</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg>
                </span>
                <li> <a href="{{ route('wishlist') }}">Wishlists</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg>
                </span>
                <li> <a href="{{ route('my-order') }}">Orders</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg>
                </span>
                <li> <a href="{{ route('cart') }}" class="tfu-active" style="font-weight:800;">Cart</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg>
                </span>
            </ul>
        </div>

        <div class="tfu-cart-empty">
             <div class="tfu-cart-empty-left" ><a href="{{ route('frontend.products') }}">
                <img  src="{{ asset('/assets/frontend-assets/svg/left-chevron-icon.svg') }}" alt="left-chevron-icon.svg" /> </a>
             </div>
              <p><span><img src="{{ asset('/assets/frontend-assets/svg/empty-cart-icon.svg') }}" alt="empty-cart-icon.svg" />
              </span> Your cart is currently empty</p>
        </div>
       </section>
    @endif

@endsection

@push('scripts')

    <script type="text/javascript">
        $(document).ready(function () {

            $(".cart_remove_product_btn").on("click", function() {
                var _this = $(this);
                var cid = $(this).attr('data-cid');
                $.ajax({
                    url: "{{ route('remove-cart') }}",
                    type: "POST",
                    data: { cid: cid , "_token": "{{ csrf_token() }}"},
                    success: function(response) {
                        if(response.status == 'success') {
                            //$('#tr_'+cid).remove();
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        // Handle the error (e.g., display an error message)
                        console.error(xhr);
                    }
                });
            });

            //------------------------------------------------------------------------------------------------

            // Update cart

            $('.update_cart').click(function () {
                var quantity =  $(this).attr('data-qty');

                var _this = $(this);
                var main_selector = $(this).closest('.ftu-select-content-qty');
                var cid = main_selector.find('.ftu-qty-options').attr('data-cid');
                if($(this).hasClass('update_cart_btn')) {
                    update_nearest_quantity2();
                    quantity = main_selector.find('.ftu-product-quantity').val();

                    if (typeof quantity === 'undefined' || quantity === "") {
                        Swal.fire({
                            reverseButtons: true,
                            title: 'Quantity must be greater than zero. Please enter a valid quantity.',
                            type: 'warning',
                            showCancelButton: true,
                            showConfirmButton : false,
                            cancelButtonText: 'Close',
                            cancelButtonColor: '#808080'
                        }).then((result) => {
                        })
                        return false;
                    }

                    var price = main_selector.find('.ftu-product-quantity').attr('data-price');
                    var calc_price = quantity * price;

                    $('.ftu-wrapper-select-quantity.active .ftu-select-btn-qty span').attr('data-qty', quantity);
                    $('.ftu-wrapper-select-quantity.active .ftu-select-btn-qty span').html(quantity + ' ($' + calc_price+')');
                    $('.ftu-wrapper-select-quantity').removeClass('active');
                }
                update_cart(cid, quantity);
            });

            //--------------------------------------------------------------------------------------------------------

            function update_cart(cid, quantity) {
                $.ajax({
                    url: "{{ route('update-cart') }}",
                    type: "POST",
                    data: { cid: cid ,quantity: quantity, "_token": "{{ csrf_token() }}"},
                    success: function(response) {
                        if(response.status == 'success') {
                            $('.qty_'+cid).val(response.total_quantity);
                            $('#item_count').text(response.total_cart_quantity);
                           // $('.cart-shipping-price').text(response.total_price);
                            $('#shipment_cost').text('$'+response.shipment_cost);
                            $('#total_price').text('$'+response.total_price);
                            $('#final_price').text('$'+response.final_price);
                            // Change place order text if minumam order amount exceeds
                            $('.ftu-cart-order-submit').text(response.place_order_text);
                            if(response.remove_disable_class) {
                                $('.ftu-cart-order-submit').removeClass('disabled');
                            } else {
                                $('.ftu-cart-order-submit').addClass('disabled');
                            }
                           // $('.price_'+cid).text(response.price);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr);
                    }
                });
            }

            // Place order

            $("#cart_form").submit(function(event) {
                event.preventDefault();
                if($(this).find('.ftu-cart-order-submit').hasClass('disabled')) {
                    return false;
                }

                if($('.tfu-total-cart-table .ftu-mb-input').hasClass('e_shopping_address')) {
                    $('html, body').animate({
                        scrollTop: $(".e_shopping_address").offset().top
                    }, 800); // Adjust 800ms to control the scroll speed
                    $(".e_shopping_address").addClass('animated-div');
                    return false;
                }

                $('#tfu_loading').show();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('place-order') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if(response.status == 'success') {
                            //$('#tfu_general_body').html(response.message);
                           // $('#tfu_general_modal').modal('show');
                            $('#tfu_loading').hide();
                            window.location.href = response.redirect_url;
                        }

                    },
                    error: function(xhr) {
                        // Handle the error (e.g., display an error message)
                        $('#tfu_loading').hide();
                        console.error(xhr);
                    }
                });

            });
        });

    </script>

@endpush

