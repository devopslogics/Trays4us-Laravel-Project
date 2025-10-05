@extends('layouts.admin.dashboard')
@push('styles')
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.min.css')}}">
    <style>
        .editable-field{border: 0;}
        .editable_border {border: 1px solid grey !important;}
    </style>
@endpush
@section('content')

    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Open Cart Detail</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                        @if($customer)
                            <div class="row m-0">
                                <div class="col-md-4 mb-1">
                                    <span><b>Name : </b>{{$customer->first_name.' '.$customer->last_name }} </span>
                                </div>

                                <div class="col-md-4 mb-1">
                                    <span><b>Phone : </b> {{ $customer->phone ?? '-' }}</span>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <span> <b>Email : </b> {{$customer->email ?? ''}}</span>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <span> <b>Shipping address 1 : </b> {{ $customer->shiping_address1 ?? '-'}}</span>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <span> <b>Shipping address 2 : </b> {{ $customer->shiping_address2 ?? '-'}}</span>
                                </div>
                            </div>
                        @endif

                         <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col" class="border-0 bg-light ">
                                        <div class="text-uppercase ">Image</div>
                                    </th>

                                    <th scope="col" class="border-0 bg-light ">
                                        <div class="text-uppercase "> Product</div>
                                    </th>

                                    <th scope="col" class="border-0 bg-light ">
                                        <div class="text-uppercase "> Artist Name</div>
                                    </th>

                                    <th scope="col" class="border-0 bg-light ">
                                        <div class="text-uppercase ">SKU</div>
                                    </th>

                                    <th scope="col" class="border-0 bg-light ">
                                        <div class="text-uppercase "> Quantity </div>
                                    </th>

                                    <th scope="col" class="border-0 bg-light ">
                                        <div class="text-uppercase "> Total price </div>
                                    </th>


                                </tr>
                                </thead>
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

                                    @php
                                        $moq = (isset($moq_case_pack->minimum_order_quantity) && $moq_case_pack->minimum_order_quantity> 0) ? $moq_case_pack->minimum_order_quantity : 1;
                                        $calculted_price = $moq * $cart_product->price;

                                        $total_item_price = $cart_product->price * $cart_product->quantity;
                                        $formatted_item_total_price = number_format($total_item_price, 2);
                                        $cart_total_price += $total_item_price;

                                    @endphp

                                        <tr>
                                            <td class="">
                                                @if( !empty($cart_product->feature_image) && \Storage::disk('uploads')->exists('/products/small-'.$cart_product->feature_image))
                                                    <img src="{{ url('uploads/products/small-'.$cart_product->feature_image) }}" alt="cart-remove-product.svg" />
                                                @endif
                                            </td>
                                            <td>
                                                <div class="tfu-cart-menu-product-info" >
                                                    <a href="{{ route('product-detail',['slug' => $cart_product->product_slug ]) }}">{{$cart_product->product_name}}</a>

                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('artist-detail',['slug' => $cart_product->artist_slug ]) }}">{{$cart_product->display_name}}</a>

                                            </td>

                                            <td>
                                                <p>{{$cart_product->type_name}}</p>
                                                <p>{{$cart_product->product_sku}}</p>
                                            </td>
                                            <td>{{ $cart_product->quantity }} </td>

                                            <td>{{$total_item_price}}</td>


                                        </tr>



                                    @endforeach


                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Total Price : </td>
                                        <td>${{number_format($cart_total_price, 2) }}</td>
                                    </tr>

                                </tbody>
                            </table>
                         </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

        });
    </script>
@endpush

