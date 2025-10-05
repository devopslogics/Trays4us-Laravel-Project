@extends('layouts.frontend')

@section('content')
    <?php /*
        <section class="tfu-dashboard-wrapper" >
          <div class=" tfu-general-breadcumb-wrapper" >
            <ul class="shop-breadcrumb">
                <li><a href="{{ route('home') }}" >Home</a></li>
                <li><a href="#">Wishlist</a></li>
            </ul>
            <div class="tfu-general-heading" >
                <h2>Wishlist</h2>
            </div>
       </div>


        <div class="row  mb-2 mt-4" >

            <ul class="tfu-dashboard-menu-link">

                <li> <span><img src="{{ asset('/assets/frontend-assets/svg/vertical-line.svg')}}"  /></span><a href="{{ route('my-account') }}" >Details</a></li>

                <li> <span><img src="{{ asset('/assets/frontend-assets/svg/vertical-line.svg')}}"  /></span><a href="#news">Send Addreses</a></li>

                <li> <span><img src="{{ asset('/assets/frontend-assets/svg/vertical-line.svg')}}"  /></span><a href="{{ route('wishlist') }}" style="font-weight:800;">Your Wishlists</a></li>

                <li> <span><img src="{{ asset('/assets/frontend-assets/svg/vertical-line.svg')}}"  /></span><a href="#about">Your Orders</a></li>

                <li> <span><img src="{{ asset('/assets/frontend-assets/svg/vertical-line.svg')}}"  /></span><a href="#about"> Payments</a><span></li>

            </ul>
        </div>

        <div class="row" >
            <div class="col-xl-12" >
                <div class="ftu-dashboard-content">
                    <table class="table table-image">
                        <tbody>
                        @if($products->isNotEmpty())
                            @foreach($products as $product)
                                <tr id="tr_{{$product->wid}}">
                                    <th scope="row">
                                        @if( !empty($product->feature_image) && \Storage::disk('uploads')->exists('/products/small-'.$product->feature_image))
                                            <img src="{{ url('uploads/products/small-'.$product->feature_image) }}" />
                                        @endif
                                    </th>
                                    <td>{{$product->product_name}}</td>
                                    <td>${{$product->price}} / item </td>
                                    <td>Total ${{$product->price}} </td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn add_to_cart" data-pid="{{$product->pid}}">add to cart</a>
                                        <a href="javascript:void(0)" class="btn remove_wishlist" data-wid="{{$product->wid}}">Remove</a>
                                    </td>
                                </tr>
                            @endforeach
                     @else
                            <tr>
                                <td colspan="8">Record not found</td>
                            </tr>
                    @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    */ ?>

    <section class="ftu-whishlist-menu-wrapper">
        <div class=" tfu-general-breadcumb-wrapper">
            {{-- <ul class="shop-breadcrumb">
                <li><a href="{{ route('my-account') }}">My Account</a></li>
                <li>Wishlists</li>
            </ul> --}}
            <div class="tfu-general-heading">
                <h1>MY ACCOUNT</h1>
            </div>
        </div>


        <div class="row  tfu-dashboard-handler" >

            <ul class="tfu-dashboard-menu-link">

                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="{{ route('my-account') }}" >Details</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="{{ route('wishlist') }}" class="tfu-active" style="font-weight:800;"  >Wishlists</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="{{ route('my-order') }}">Orders</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="{{ route('cart') }}" >Cart</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>

            </ul>

        </div>

        {{-- <div class="row">
            <div class="col-xl-4">
                <h2 class="ftu-whishlist-title">Wishlists</h2>
            </div>
        </div> --}}



        <?php /*
        <div class="row  mb-2 mt-4" >

          <div class="col-xl-8">
            <ul class="tfu-dashboard-menu-link">

                <li> <span><img src="{{ asset('/assets/frontend-assets/svg/vertical-line.svg')}}"  /></span><a href="{{ route('my-account') }}" >All</a></li>

                <li> <span><img src="{{ asset('/assets/frontend-assets/svg/vertical-line.svg')}}"  /></span><a href="{{ route('wishlist') }}" style="font-weight:800;">Your Wishlists</a></li>

                <li> <span><img src="{{ asset('/assets/frontend-assets/svg/vertical-line.svg')}}"  /></span><a href="#news">My lists</a></li>

                <li> <span><img src="{{ asset('/assets/frontend-assets/svg/vertical-line.svg')}}"  /></span><a href="#about">Reminder</a></li>

                <li> <span><img src="{{ asset('/assets/frontend-assets/svg/vertical-line.svg')}}"  /></span><a href="#about"> Premade</a><span></li>

            </ul>
          </div>
          <div class="col-xl-4">

            <div class="tfu-add-to-list" >
                <div class="tfu-add-to-list-icon" >
                 <img src="{{ asset('/assets/frontend-assets/svg/add-to-list.svg')}}"  />
                </div>
                <div class="tfu-add-to-list-form" >
                    <form action="" class="tfu-search-form" id="whishlist_search_form">
                        <div class="form-group">
                            <input type="text" class="form-control" name="search_by" id="search_by" placeholder="New list name" value="" fdprocessedid="4037e">
                        </div>
                    </form>
                </div>
            </div>

          </div>
        </div>
        */ ?>
        <div class="tfu-Whishlist-table-handler">
          <?php /*
          <div class="row" >

            <div class="col-xl-5">
               <div class="tfu-whishlist-user-handler" >
                    <a href="javascript:void(0)" class="cart_whishlist_product_btn" data-cid="6">
                        <div class="cart-whishlist-product">
                            <img src="https://hammanitechdemos.com/trays4us/assets/frontend-assets/svg/whishlist-without-heart.svg">
                        </div>
                    </a>
                    <div class="tfu-whishlist-user-name" >
                        <h3>Wishlist name:<span>Adam´s Kate set monthly</span></h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">

                <div  class="tfu-whishlist-handler" >
                    A reminder will be sent
                    <label class="tfu-switch">
                        <input type="checkbox">
                        <span class="tfu-switch-slider"></span>
                    </label>
                  </div>

            </div>

            <div class="col-xl-1">
                <div class="tfu-whishlist-select-option" >
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                        <option selected>Monthly</option>
                        <option value="1">Jan</option>
                        <option value="2">Feb</option>
                        <option value="3">March</option>
                      </select>
                </div>
             </div>
             <div class="col-xl-1">
                <div class="tfu-whishlist-select-option" >
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                        <option selected>Day</option>
                        <option value="1">Mon</option>
                        <option value="2">Tue</option>
                        <option value="3">Wed</option>
                      </select>
                </div>
             </div>
             <div class="col-xl-1">
                <a href="javascript:void(0)" class="cart_remove_product_btn" data-cid="6">
                    <div class="cart-remove-product">
                        <img src="https://hammanitechdemos.com/trays4us/assets/frontend-assets/svg/cart-remove-product.svg">
                    </div>
                </a>
             </div>


          </div> */ ?>

              <table class="table table-borderless" >
                <tbody>
                @if($wishlists->isNotEmpty())
                    @php
                        $cart_total_price = 0;
                    @endphp
                    @foreach($wishlists as $wishlist)

                        @php
                            // Get minimam order quantity and case pack from customizable_type_relation table
                            $moq_case_pack = array();
                            if(isset($wishlist->product_customizable) AND isset($wishlist->pt_sub_id))
                                $moq_case_pack  = \App\Models\Helper::get_moq_case_pack($wishlist->product_customizable,$wishlist->pt_sub_id);
                            //print_r($moq_case_pack);exit;
                        @endphp

                        <tr id="tr_{{$wishlist->wid}}" class="cart_tr tfu_product_qty_wrapper">
                            <td class="align-middle mtr-remove-whislist">
                                <div class="cart-remove-product">
                                    <a href="javascript:void(0)" class="remove_wishlist" data-wid="{{$wishlist->wid}}"  rel="nofollow">
                                        <img src="{{ asset('/assets/frontend-assets/svg/cart-remove-product.svg') }}" alt="cart-remove-product.svg">
                                    </a>
                                </div>
                            </td>

                            <td class="align-middle">
                                <div class="tfu-img-cart">
                                    @if( !empty($wishlist->feature_image) && \Storage::disk('uploads')->exists('/products/small-'.$wishlist->feature_image))
                                        <img src="{{ url('uploads/products/small-'.$wishlist->feature_image) }}" alt="{{$wishlist->feature_image ?? ''}}" />
                                    @endif
                               </div>
                            </td>
                            <td class="align-middle">
                                <div class="tfu-cart-menu-product-info" >
                                    <a href="{{ route('product-detail',['slug' => $wishlist->product_slug ]) }}"><h2>{!! $wishlist->product_name !!}</h2></a>
                                    <a href="{{ route('artist-detail',['slug' => $wishlist->artist_slug ]) }}"><h3>{!! $wishlist->display_name !!}</h3></a>
                                    <div class="tfu-mr-product-data" >
                                        <h5>{!! $wishlist->type_name !!}</h5>
                                        <h5>{{$wishlist->product_sku}}</h5>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle  tfu-mr-product-data-hide ">
                                <h5>{!! $wishlist->type_name !!}</h5>
                                <h5>{{$wishlist->product_sku}}</h5>
                            </td>
                            <td class="align-middle tfu-whislist-mspr-price">
                              <div class="tfu-cart-product-price">
                                <h2><span>$</span>{{$wishlist->price}} </h2>
                                <span> {{ (isset($site_management->msrp_price) && $site_management->msrp_price > 0 ) ? 'MSRP $'.number_format(ceil($site_management->msrp_price * $wishlist->price),2)  : '' }}</span>
                             </div>
                            </td>


                            <td class="align-middle">
                                <div class="tfu-cart-product-price mr-whistlist-mrp">
                                    <h2><span>$</span>{{$wishlist->price}} </h2>
                                    <span> {{ (isset($site_management->msrp_price) && $site_management->msrp_price > 0 ) ? 'MSRP $'.number_format(ceil($site_management->msrp_price * $wishlist->price),2)  : '' }}</span>
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
                                               // echo "<pre>";print_r($wishlist);exit;
                                                $moq = (isset($moq_case_pack->minimum_order_quantity) && $moq_case_pack->minimum_order_quantity > 0) ? $moq_case_pack->minimum_order_quantity : 1;
                                                $calculted_price = $moq * $wishlist->price;

                                                $total_item_price = $wishlist->price * $wishlist->w_quantity;
                                                $formatted_item_total_price = number_format($total_item_price, 2);
                                                $cart_total_price += $total_item_price;

                                            @endphp
                                            <div class="ftu-select-btn-qty">
                                                <span data-qty="{{$wishlist->quantity}}">{{$wishlist->w_quantity}}  (${{$wishlist->price * $wishlist->w_quantity}})</span>
                                                <img src="{{ asset('/assets/frontend-assets/svg/input-dropdown-icon.svg') }}" alt="input-dropdown-icon.svg"  />
                                            </div>


                                            <div class="ftu-select-content-qty">

                                                <ul class="ftu-qty-options" id="qty_ul_{{$wishlist->wid}}" data-wid="{{$wishlist->wid}}">
                                                    <?php
                                                    //echo "<pre>";print_r($moq_case_pack);exit;

                                                    $case_pack = (isset($moq_case_pack->case_pack) && $moq_case_pack->case_pack > 0) ? $moq_case_pack->case_pack : 1;
                                                    for ($i = 1; $i <= 5; $i++) {
                                                    $quantity = $case_pack + $moq;
                                                    $calculated_price2 = $quantity * $wishlist->price;

                                                    ?>
                                                    <li onclick="updateName(this)" data-qty="{{$quantity}}" class="update_cart">{{$quantity}}  (${{$calculated_price2}})</li>
                                                    <?php
                                                    $case_pack += $moq_case_pack->case_pack; // Increment by the original value of case_pack
                                                    }
                                                    $p_quantity = $moq_case_pack->minimum_order_quantity;
                                                    if(isset($product->c_quantity) AND $wishlist->c_quantity > 0)
                                                        $p_quantity = $moq_case_pack->case_pack;
                                                    ?>
                                                </ul>
                                                <div class="ftu-qty-input">
                                                    <input spellcheck="false" data-moq="{{$p_quantity}}" data-cp="{{ $moq_case_pack->case_pack ?? 1 }}"  data-price="{{$wishlist->price}}" class="ftu-product-quantity numeric_only" type="text" placeholder="Custom quantity">
                                                    <a href="javascript:void(0)" class="cart_update_product_btn" rel="nofollow">
                                                        <button type="button" class="update_cart update_cart_btn">Update</button>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>



                                </div>
                                <div class="tfu-buy-wishlist-price tfu-buy-wishlist-price-mr">
                                    <a href="javascript:void(0)"  rel="nofollow" class="add_to_cart" data-pid="{{$wishlist->pid}}">Add to cart</a>
                                </div>

                              </td>
{{--
                            @php
                                $total_item_price = $wishlist->price * $wishlist->w_quantity;
                                $formatted_item_total_price = number_format($total_item_price, 2);
                                $cart_total_price += $total_item_price;
                            @endphp
                            <td class="align-middle">
                                <div class="tfu-cart-total-price" >
                                    <h3><span>Total : </span> $<span class="price_{{$wishlist->wid}}">{{$formatted_item_total_price}}</span></h3>
                                </div>
                            </td> --}}
                            <td class="align-middle tfu-add-to-cart-whislist-mr">
                                <div class="tfu-buy-wishlist-price">
                                    <a href="javascript:void(0)"  rel="nofollow" class="add_to_cart" data-pid="{{$wishlist->pid}}">Add to cart</a>
                                </div>
                            </td>
                            <td class="align-middle mtr-remove-whislist-des ">
                                <div class="cart-remove-product">
                                    <a href="javascript:void(0)"  rel="nofollow" class="remove_wishlist" data-wid="{{$wishlist->wid}}">
                                        <img src="{{ asset('/assets/frontend-assets/svg/cart-remove-product.svg') }}" alt="cart-remove-product.svg">
                                    </a>
                                </div>
                            </td>
                            <?php /*
                            <td class="align-middle" >

                                @php
                                    $alreadyInWishlist = isset($wishlist->wid) && ($wishlist->wid > 0);
                                    $wishlist_icon_name = 'whishlist-without-heart.svg';
                                    if($alreadyInWishlist)
                                        $wishlist_icon_name = 'whishlist-heart.svg';
                                @endphp
                                <a href="javascript:void(0)" class="cart_whishlist_product_btn tfu_add_wish_list {{ $alreadyInWishlist ? 'already_wish_list' : '' }}" data-pid="{{ $wishlist->pid }}">
                                    <div class="cart-whishlist-product">
                                        <img src="{{ asset('/assets/frontend-assets/svg/'.$wishlist_icon_name) }}" alt="Vans">
                                    </div>
                                </a>
                            </td> */ ?>

                        </tr>
                    @endforeach

                     <tr class="tfu-whishlist-total-list-price">
                        <td class="align-middle tfu-whishlist-total-mr-1  "></td>
                        <td class="align-middle  tfu-whishlist-total-mr-2"> </td>
                        <td class="align-middle tfu-whishlist-total-mr-3"> </td>
                        <td class="align-middle"></td>
                        <td class="align-middle">
                            <div class="tfu-whishlist-total-list-price tfu-total-heading">
                                <h3><span>Total : </span></h3>
                            </div>
                        </td>

                        <td class="align-middle">
                          <div class="tfu-whishlist-total-list-price tfu-total-price">
                              <h3> $<span class="tfu_wl_total_price">{{number_format($cart_total_price, 2)}}</span></h3>
                          </div>
                        </td>

                        <td class="align-middle">
                            <div class="tfu-buy-wishlist-price ">
                                <a href="javascript:void(0)"  rel="nofollow" class="add_all_to_cart"> Add to Cart</a>
                              </div>
                        </td>

                        <td class="align-middle"> </td>

                     </tr>
                @else

        <div class="tfu-cart-empty">
            <div class="tfu-cart-empty-left" >
                <a href="{{ route('frontend.products') }}">
                    <img  src="{{ asset('/assets/frontend-assets/svg/left-chevron-icon.svg') }}" alt="left-chevron-icon.svg"/> </a>
            </div>
           <p><span><img src="{{ asset('/assets/frontend-assets/svg/empty-cart-icon.svg') }}" alt="empty-cart-icon.svg" /></span> Your Whishlists is currently empty</p>
       </div>
                @endif
                </tbody>
          </table>

        </div>

    </section>

@endsection



@push('scripts')

    <script type="text/javascript">
        $(document).ready(function() {

            $('.update_cart').click(function () {
                var quantity =  $(this).attr('data-qty');
                var _this = $(this);
                var main_selector = $(this).closest('.ftu-select-content-qty');
                var wid = main_selector.find('.ftu-qty-options').attr('data-wid');
               // alert(wid);
                if($(this).hasClass('update_cart_btn')) {
                    update_nearest_quantity2();
                    quantity = main_selector.find('.ftu-product-quantity').val();
                    var price = main_selector.find('.ftu-product-quantity').attr('data-price');
                    var calc_price = quantity * price;

                    $('.ftu-wrapper-select-quantity.active .ftu-select-btn-qty span').attr('data-qty', quantity);
                    $('.ftu-wrapper-select-quantity.active .ftu-select-btn-qty span').html(quantity + ' ($' + calc_price+')');
                    $('.ftu-wrapper-select-quantity').removeClass('active');
                }

                update_wishlist(wid, quantity);

            });


            //--------------------------------------------------------------------------------------------------------

            $(document).on("click",".add_all_to_cart",function() {
                var _this = $(this);
                $.ajax({
                    url: "{{ route('add-to-cart-all-wishlist-item') }}",
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}"},
                    success: function(response) {
                        if(response.status == 'success') {
                            $('.add_to_cart').addClass('already_cart');
                            $('.add_to_cart').text('Added to cart');
                            $('#item_count').html(response.total_quantity);
                        }
                    },
                    error: function(xhr) {
                        // Handle the error (e.g., display an error message)
                        console.error(xhr);
                    }
                });
            });

            //--------------------------------------------------------------------------------------------------------
            function update_wishlist(wid, quantity) {
                $.ajax({
                    url: "{{ route('update-wishlist') }}",
                    type: "POST",
                    data: { wid: wid ,quantity: quantity, "_token": "{{ csrf_token() }}"},
                    success: function(response) {
                        if(response.status == 'success') {
                            $('.tfu_wl_total_price').text(response.price);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr);
                    }
                });
            }
        });
    </script>

@endpush

