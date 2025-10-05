@extends('layouts.frontend')

@section('content')

    <section class="ftu-whishlist-menu-wrapper">
        <div class=" tfu-general-breadcumb-wrapper">
            {{-- <ul class="shop-breadcrumb">
                <li><a href="{{ route('my-account') }}">My Account</a></li>
                <li>Orders</li>
            </ul> --}}
            <div class="tfu-general-heading">
                <h1>MY ACCOUNT</h1>
            </div>
        </div>


        <div class="row   tfu-dashboard-handler" >

            <ul class="tfu-dashboard-menu-link">

                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="{{ route('my-account') }}" >Details</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="{{ route('wishlist') }}"  >Wishlists</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="{{ route('my-order') }}" class="tfu-active"  style="font-weight:800;" >Orders</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="{{ route('cart') }}" >Cart</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>

            </ul>

        </div>

        {{-- <div class="row">
            <div class="col-xl-4">
                <h2 class="ftu-whishlist-title">Orders</h2>
            </div>
        </div> --}}

        @if($my_orders->isNotEmpty())
            @foreach($my_orders as $my_order)
                @php
                    $order_total_price = 0;
                    $order_status  = \App\Traits\Definations::getOrderStatusClass($my_order->status);
                    $shiping_fee = $my_order->shipping_cost;
                    $totalAmount = $my_order->orderItems->sum(function ($item) {
                        return $item->sale_price * $item->quantity;
                    });


                @endphp
                <div class="tfu-order-table-handler" id="order_{{$my_order->id}}">

                    <div class="row">
                        <div class="col-8 col-sm-7 col-md-8 col-lg-8 col-xl-8">
                            <div class="tfu-order-information" >
                                <h6>Order Number : <span>{{$my_order->order_number}}</span></h6>
                                <h5>Tracking id: <span>{{ $my_order->tracking_id ? $my_order->tracking_id : 'Not available yet' }}</span></h5>

                                <table class="table table-borderless tfu-order-track-info" >
                                    <tr class="tfu-order-table-heading">
                                        <td>Shipping Date</td>
                                        <td>Total </td>
                                        <td>Shipping cost</td>
                                    </tr>
                                    <tr>
                                        <td> <p>  {{ date('m/d/Y', strtotime($my_order->estimated_ship_date)) }}  </p></td>
                                        <td>  <h4 class="tfu-order-bold-price" > <span> ${{number_format($totalAmount + $shiping_fee, 2)}}</span></h4></td>
                                        <td> <h4 class="tfu-order-unbold-price" >  <span> ${{number_format($shiping_fee, 2)}} </span></h4></td>
                                    </tr>
                                </table>
                                <?php /*<h5>{{ date('d/m/Y', strtotime($my_order->estimated_ship_date)) }}</h5> */ ?>
                                <h4>Status : <span>{{ $order_status[1]  ?? ''}}</span></h4>

                            </div>
                        </div>

                        <div class="col-4 col-sm-5 col-md-4 col-lg-4 col-xl-4">
                            <div class="tfu-order-invoice" >
                                <p>Order Placed : <span> {{ date('m/d/Y', strtotime($my_order->created_at)) }}</span></p>
                                <h6><a href="mailto:support@trays4.us?subject=Need help #{{$my_order->order_number}}" >Support</a></h6>
                                @if(!empty($my_order->quick_book_link))
                                    <h6><a href="{{$my_order->quick_book_link}}" target="_blank">Invoice</a></h6>
                                @endif
                            </div>
                        </div>
                    </div>


                    <table class="table table-borderless" >
                        <tbody>
                        @foreach($my_order->orderItems as $order_item)
                            @php
                                //print_r($order_item->product->product_slug);exit;
                              //print_r($order_item->product->wishlist->id);exit;
                            @endphp
                            <tr id="tr_{{$my_order->id}}" class="cart_tr tfu_product_qty_wrapper">

                                <td class="align-middle tfu-order-whislist-mr-start">

                                    @php
                                        $alreadyInWishlist = isset($order_item->product->wishlist->id) && ($order_item->product->wishlist->id > 0);
                                        $wishlist_icon_name = 'whishlist-without-heart.svg';
                                        if($alreadyInWishlist)
                                            $wishlist_icon_name = 'whishlist-heart.svg';
                                    @endphp
                                    <a href="javascript:void(0)"  rel="nofollow" class="cart_whishlist_product_btn tfu_add_wish_list {{ $alreadyInWishlist ? 'already_wish_list' : '' }}" data-pid="{{ $order_item->product_id }}">
                                        <div class="cart-whishlist-product">
                                            <img src="{{ asset('/assets/frontend-assets/svg/'.$wishlist_icon_name) }}" alt="{{$wishlist_icon_name ?? ''}}">
                                        </div>
                                    </a>
                                </td>

                                <td class="align-middle">
                                    <div class="tfu-img-cart">
                                        <a href="{{ route('product-detail',['slug' => $order_item->product->product_slug ]) }}">
                                            @if( !empty($order_item->product->feature_image) && \Storage::disk('uploads')->exists('/products/small-'.$order_item->product->feature_image))
                                                <img src="{{ url('uploads/products/small-'.$order_item->product->feature_image) }}" alt="{{$order_item->product->feature_image ?? ''}}" />
                                            @endif
                                        </a>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="tfu-cart-menu-product-info" >
                                        <a href="{{ route('product-detail',['slug' => $order_item->product->product_slug ]) }}"><h2>{!! $order_item->product->product_name !!}</h2></a>
                                        <a href="{{ route('artist-detail',['slug' => $order_item->product->artist->artist_slug ]) }}"><h3>{{ $order_item->product->artist->display_name ??  $order_item->product->artist->first_name}}</h3></a>
                                    </div>
                                    <div class=" tfu-order-mr-hide-show"  >
                                        @php
                                            $getProductTypeDetail = array();
                                            if(isset($order_item->productPrice->pt_sub_id) AND $order_item->productPrice->pt_sub_id > 0)
                                              $getProductTypeDetail  = \App\Traits\Definations::getProductTypeDetail( $order_item->productPrice->pt_sub_id);
                                        @endphp

                                        <h5>{!!  $getProductTypeDetail->child->type_name ?? '' !!}  {!! $getProductTypeDetail->type_name ?? '' !!}</h5>
                                        <h5>{{$order_item->product->product_sku}}</h5>
                                    </div>
                                </td>
                                <td class="align-middle tfu-order-mr-hide">
                                    @php
                                        $getProductTypeDetail = array();
                                        if(isset($order_item->productPrice->pt_sub_id) AND $order_item->productPrice->pt_sub_id > 0)
                                          $getProductTypeDetail  = \App\Traits\Definations::getProductTypeDetail( $order_item->productPrice->pt_sub_id);
                                    @endphp

                                    <h5>{!! $getProductTypeDetail->child->type_name ?? '' !!} {!! $getProductTypeDetail->type_name ?? '' !!} </h5>
                                    <h5>{{$order_item->product->product_sku}}</h5>
                                </td>

                                @php
                                    $total_item_price = $order_item->sale_price * $order_item->quantity;
                                    $formatted_item_total_price = number_format($total_item_price, 2);
                                    $order_total_price += $total_item_price;
                                @endphp
                                <td class="align-middle tfu-mr-total-price-order-ds">
                                    <div class="tfu-cart-product-price" >
                                        <h2><span>$</span>{{ $order_item->sale_price }} </h2>
                                        <span> {{ (isset($site_management->msrp_price) && $site_management->msrp_price > 0 ) ? 'MSRP $'.number_format(ceil($site_management->msrp_price * $total_item_price),2)  : '' }}</span>
                                    </div>
                                </td>

                                <td class="align-middle">
                                    <div class="tfu-cart-product-price tfu-mr-total-price-order" >
                                        <h2><span>$</span>{{ $order_item->sale_price }} </h2>
                                        <span> {{ (isset($site_management->msrp_price) && $site_management->msrp_price > 0 ) ? 'MSRP $'.number_format(ceil($site_management->msrp_price * $total_item_price),2)  : '' }}</span>
                                    </div>

                                    <div class="tfu-cart-total-price" >
                                        <h3>  {{ $order_item->quantity }}
                                            <span class="">(${{$formatted_item_total_price}})</span></h3>
                                    </div>
                                    <div class="tfu-buy-wishlist-price tfu-buy-wishlist-price-mr">
                                        @if($order_item->product->status == 1)
                                            <a href="javascript:void(0)"  rel="nofollow" class="add_to_cart" data-pid="{{$order_item->product_id}}">Add to cart</a>
                                        @else
                                            <a href="javascript:void(0)"  rel="nofollow" class="">Not available</a>
                                        @endif
                                    </div>

                                </td>

                                <td class="align-middle tfu-order-add-to-cart-mr" id="product_{{$order_item->product_id}}">
                                    <div class="tfu-buy-wishlist-price   ">
                                        @if($order_item->product->status == 1)
                                            <a href="javascript:void(0)"  rel="nofollow" class="add_to_cart" data-pid="{{$order_item->product_id}}">Add to cart</a>
                                        @else
                                            <a href="javascript:void(0)"  rel="nofollow" class="">Not available</a>
                                        @endif
                                        <div class="tfu-product-cart-alert">
                                            <p class="already_item_cart" style="margin-bottom: -14px "></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle tfu-order-whislist-mr" >

                                    @php
                                        $alreadyInWishlist = isset($order_item->product->wishlist->id) && ($order_item->product->wishlist->id > 0);
                                        $wishlist_icon_name = 'whishlist-without-heart.svg';
                                        if($alreadyInWishlist)
                                            $wishlist_icon_name = 'whishlist-heart.svg';
                                    @endphp
                                    <a href="javascript:void(0)"  rel="nofollow" class="cart_whishlist_product_btn tfu_add_wish_list {{ $alreadyInWishlist ? 'already_wish_list' : '' }}" data-pid="{{ $order_item->product_id }}">
                                        <div class="cart-whishlist-product">
                                            <img src="{{ asset('/assets/frontend-assets/svg/'.$wishlist_icon_name) }}" alt="{{ $wishlist_icon_name ?? ''}}">
                                        </div>
                                    </a>
                                </td>

                            </tr>
                        @endforeach

                        <tr class="tfu-whishlist-total-list-price">
                            <td class="align-middle tfu-order-whislist-mr-start" >

                                @php
                                    $alreadyInWishlist = isset($order_item->product->wishlist->id) && ($order_item->product->wishlist->id > 0);
                                    $wishlist_icon_name = 'whishlist-without-heart.svg';
                                    if($alreadyInWishlist)
                                        $wishlist_icon_name = 'whishlist-heart.svg';

                                @endphp
                                <a href="javascript:void(0)" rel="nofollow"  class="cart_whishlist_product_btn tfu_add_wish_list {{ $alreadyInWishlist ? 'already_wish_list' : '' }}" data-pid="{{ $order_item->product_id }}"  rel="nofollow">
                                    <div class="cart-whishlist-product">
                                        <img src="{{ asset('/assets/frontend-assets/svg/'.$wishlist_icon_name) }}" alt="{{ $wishlist_icon_name ?? ''}}">
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
                                    <h3><span class="price_6">${{number_format($order_total_price + $shiping_fee, 2)}}</span></h3>
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
                                    <a href="javascript:void(0)"  class="tfu_add_all_item_to_cart"  data-oid="{{ $my_order->id }}" rel="nofollow">Repeat Order</a>
                                </div>
                            </td>

                            <td class="align-middle tfu-order-whislist-mr" >

                                @php

                                    $customFunctionResult = \App\Models\Wishlist::checkAllOrderItemsInWishlist($my_order->id);
                                     $alreadyInWishlist = false;
                                    $wishlist_icon_name = 'whishlist-without-heart.svg';
                                    if(!$customFunctionResult) {
                                        $wishlist_icon_name = 'whishlist-heart.svg';
                                        $alreadyInWishlist = true;
                                   }

                                @endphp
                                <a href="javascript:void(0)" {{$customFunctionResult}} class="cart_whishlist_product_btn tfu_add_all_item_wishlist {{ $alreadyInWishlist ? 'already_wish_list' : '' }}" data-oid="{{ $my_order->id }}"  rel="nofollow">
                                    <div class="cart-whishlist-product">
                                        <img src="{{ asset('/assets/frontend-assets/svg/'.$wishlist_icon_name) }}" alt="{{ $wishlist_icon_name ?? ''}}">
                                    </div>
                                </a>
                            </td>


                        </tr>

                        </tbody>
                    </table>
                </div>
            @endforeach
        @else
            <div class="tfu-cart-empty">
                <img src="{{ asset('/assets/frontend-assets/svg/tfu-empty-box.svg') }}" alt="tfu-empty-box.svg" />
                <p>Record not found</p>
            </div>
        @endif

        {{ $my_orders->links('pagination.custom') }}

    </section>

@endsection



@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            //----------------------------------------------------------------------------------------

            $(document).on("click",".tfu_add_all_item_wishlist",function() {
                let _this = $(this);
                let oid = _this.attr('data-oid');
                $.ajax({
                    url: "{{ route('add-to-wishlist-all-ordered-item') }}",
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", "order_id": oid},
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
                    url: "{{ route('add-to-cart-all-ordered-item') }}",
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", "order_id": oid},
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
@endpush

