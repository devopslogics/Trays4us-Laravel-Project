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
            <ul class="shop-breadcrumb">
                <li><a href="{{ route('my-account') }}">My Account</a></li>
                <li>Order detail</li>
            </ul>
            <div class="tfu-general-heading">
                <h1>Order detail</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4">
                <h2 class="ftu-whishlist-title">Order detail</h2>
            </div>
        </div>


        <div class="tfu-Whishlist-table-handler">

                @if($order->customer)
                <div class="row m-0">
                    <div class="col-md-4 mb-1">
                        <span><b>Order # : </b>{{ $order->order_number }} </span>
                    </div>

                    <div class="col-md-4 mb-1">
                        <span><b>Order lead time (Days) : </b>{{ date('d/m/Y', strtotime($order->estimated_ship_date)) }} </span>
                    </div>
                    @php
                        $order_status  = \App\Traits\Definations::getOrderStatusClass($order->status);
                    @endphp
                    <div class="col-md-4 mb-1">
                        <span><b>Order status : </b> {{ $order_status[1] }} </span>
                    </div>

                </div>
                @endif

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col" class="border-0 bg-light ">
                                <div class="text-uppercase "> Product</div>
                            </th>

                            <th scope="col" class="border-0 bg-light ">
                                <div class="text-uppercase "> Quantity </div>
                            </th>

                            <th scope="col" class="border-0 bg-light ">
                                <div class="text-uppercase "> Unit Price ($) </div>
                            </th>

                            <th scope="col" class="border-0 bg-light ">
                                <div class="text-uppercase "> Total price ($) </div>
                            </th>


                        </tr>
                        </thead>
                        <tbody>
                        @php $order_total_price = 0; @endphp

                            @foreach($order->orderItems as $item)
                                @php
                                    $total_item_price = $item->price * $item->quantity;
                                    $formatted_item_total_price = number_format($total_item_price, 2);
                                    $order_total_price += $total_item_price;
                                @endphp

                                <tr>
                                    <td>{{ $item->product->product_name }}</td>
                                    <td><strong>{{ $item->quantity }}</strong></td>
                                    <td>{{ $item->sale_price }}</td>
                                    <td>{{ $formatted_item_total_price }}</td>
                                </tr>
                            @endforeach

                            <tr class="tfu-whishlist-total-list-price">
                                <td class="align-middle"></td>
                                <td class="align-middle"> </td>
                                <td class="align-middle"> </td>
                                <td class="align-middle">
                                    <div class="tfu-whishlist-total-list-price">
                                        <h3><span>Total : </span> $<span class="price_6">{{number_format($order_total_price + $order->shipping_cost, 2)}}</span></h3>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
        </div>

    </section>

@endsection



@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

        });
    </script>
@endpush

