@extends('layouts.admin.dashboard')
@push('styles')
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.min.css')}}">
    <style>
        .editable-field{border: 0; width: 92px; text-align: center; }
        .editable_border {border: 1px solid grey !important;}
    </style>
@endpush
@section('content')

    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Order detail</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('edit-order-submitted') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="order_id" id="order_id" value="{{$order->id}}">
                        @if($order->customer)
                            <div class="row m-0">
                                <div class="col-md-4 mb-1">
                                    <span><b>Name : </b>{{ $order->customer->first_name.' '.$order->customer->last_name }} </span>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <span><b>Order Number : </b>{{$order->order_number}} </span>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <span><b>Phone : </b> {{ $order->customer->phone ?? '-' }}</span>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <span> <b>Email : </b> {{ $order->customer->email ?? ''}}</span>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <span> <b>Shipping address 1 : </b> {{ $order->customer->shiping_address1 ?? '-'}}</span>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <span> <b>Shipping address 2 : </b> {{ $order->customer->shiping_address2 ?? '-'}}</span>
                                </div>

                                <div class="col-md-4 mb-1">
                                    <span> <b>Full Address : </b>

                                        <?php
                                        $address = '';
                                        if ($order->customer->city) {
                                            $address .= ($address ? ', ' : '') . trim($order->customer->city);
                                        }
                                        if ($order->customer->state) {
                                            $address .= ($address ? ', ' : '') . $order->customer->state->abbrev;
                                        }
                                        if ($order->customer->postal_code) {
                                            $address .= ($address ? ' ' : '') . trim($order->customer->postal_code);
                                        }
                                        if ($order->customer->country) {
                                            $address .= ($address ? ', ' : '') . trim($order->customer->country->country_code);
                                        }
                                        echo $address;
                                        ?>
                                    </span>
                                </div>

                                <div class="col-md-4 mb-1">
                                    <span> <b>Company : </b> {{ $order->customer->company ?? '-'}}</span>
                                </div>

                                @if($order->order_notes)
                                    <div class="col-md-12 mb-1">
                                        <span> <b>Order notes : </b>
                                            {{ $order->order_notes  }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @endif

                         <div class="table-responsive">
                            <table class="table" id="tfu_edit_order">
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
                                        <div class="text-uppercase "> Unit Price </div>
                                    </th>

                                    <th scope="col" class="border-0 bg-light ">
                                        <div class="text-uppercase "> Total price </div>
                                    </th>

                                    <th scope="col" class="border-0 bg-light ">
                                        <div class="text-uppercase "> Action </div>
                                    </th>


                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_cost = 0;
                                    @endphp

                                    @foreach($order->orderItems as $item)
                                        <tr id="tr_{{$item->id}}">
                                            <td class="">
                                                @if( !empty($item->product->feature_image) && \Storage::disk('uploads')->exists('/products/small-'.$item->product->feature_image))
                                                    <a href="{{ route('product-detail',['slug' => $item->product->product_slug ]) }}">
                                                        <img src="{{ url('uploads/products/small-'.$item->product->feature_image) }}" style="width: 50%"/>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{!! $item->product->product_name !!}</td>
                                            <td>{{ $item->product->artist->display_name ?? '' }}</td>
                                            <td>{{ $item->product->product_sku }}</td>
                                            <td><input type="text" class="editable-field tfu_quantity" name="products_qty[{{$item->id}}]" value="{{ $item->quantity }}" readonly></td>
                                            <td>$<input type="text" class="editable-field tfu_price" name="products_prices[{{$item->id}}]" value="{{ $item->sale_price }}" readonly></td>
                                            <td>$<span class="item_tot_price">{{ $item->sale_price * $item->quantity }}</span></td>
                                            <td>
                                                @if($order->status != 6 AND $order->status != 5)
                                                    <a href="javascript:void(0)" data-id="{{$item->id}}"
                                                       class="btn btn-sm bg-danger-light mr-1 delete-order-item"
                                                       title="Delete"
                                                       data-msg="Are you sure want to delete">
                                                        <i class="far  fa-trash-alt mr-1"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>

                                        @php
                                            $total_cost += $item->sale_price * $item->quantity;
                                        @endphp

                                    @endforeach

                                    <tr class="exclude_tr">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Shipping Fee : </td>
                                        <td>$<span id="total_shiping_cost">{{number_format($order->shipping_cost, 2)}}</span></td>
                                    </tr>

                                    <tr class="exclude_tr">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Total Price : </td>
                                        <td>$<span id="total_cost">{{number_format($total_cost + $order->shipping_cost, 2) }}</span></td>
                                    </tr>

                                </tbody>
                            </table>
                         </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Expected ship date</label>
                                    <input type="text" class="form-control" name="estimated_ship_date" id="estimated_ship_date" value="{{ date('m/d/Y', strtotime($order->estimated_ship_date)) }}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Shipping fee</label>
                                    <input type="text" class="form-control" name="shipping_cost" id="shipping_cost" value="{{ $order->shipping_cost }}">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>QuickBook Link</label>
                                    <input type="text" class="form-control" name="quick_book_link" id="quick_book_link" value="{{ ($order->quick_book_link) }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>UPS/FedEX/USPS tracking ID</label>
                                    <input type="text" class="form-control" name="tracking_id" id="tracking_id" value="{{ ($order->tracking_id) }}">
                                </div>
                            </div>

                        </div>


                        <div class="text-end">
                            <button type="submit" name="action" value="1" class="btn btn-primary">Save Only</button>
                            <button type="submit" name="action" value="2" class="btn btn-primary">Save & Send Email</button>
                            <a href="{{ route('all-orders') }}" class="btn btn-link">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#estimated_ship_date").datepicker({
                dateFormat: 'mm/dd/yy'
            });

            //------------------------------------------------------------------------

            $('.editable-field').click(function () {
                $(this).addClass('editable_border');
                $(this).prop('readonly', false).focus();
            });

            //------------------------------------------------------------------------

            $('.editable-field').blur(function() {
                $('.editable-field').removeClass('editable_border');
            });

            //------------------------------------------------------------------------

            $(".delete-order-item").click(function (event) {

                event.preventDefault();

                var msg = ($(this).attr('data-msg'));
                var type = ($(this).attr('data-type'));


                var oi_id = $(this).attr('data-id');
                _this = $(this);

                Swal.fire({
                    reverseButtons: true,
                    title: msg,
                    type: 'warning',
                    width:350,
                    height:150,
                    showCancelButton: true,
                    cancelButtonText: 'No',
                    confirmButtonText: 'Yes',
                    confirmButtonColor: '#ff7129',
                    cancelButtonColor: '#808080'
                }).then((result) => {
                    if (result.value) {
                        $('#loading').show();
                        $.ajax({
                            url:"{{ route('delete-order-items') }}",
                            data: { oi_id: oi_id },
                            type: "GET",
                            success: function(data){
                                $('#loading').hide();
                                if(data.status == 'success') {
                                    setTimeout(function() {
                                        location.reload();
                                    }, 5000);
                                }
                            }
                        });
                    }

                })

            });

            //------------------------------------------------------------------------

            $(".tfu_price,.tfu_quantity,#shipping_cost").blur(function() {
                 total_price = 0;
                $('#tfu_edit_order  tbody   tr:not(.exclude_tr)').each(function() {
                    quantity =  $(this).find('.tfu_quantity').val();
                    tfu_price = $(this).find('.tfu_price').val();
                    item_tot_price = parseFloat(quantity * tfu_price).toFixed(2);
                    $(this).find('.item_tot_price').text(item_tot_price);
                    total_price += quantity * tfu_price;
                });
                console.log(total_price);
                shipping_cost = parseFloat($('#shipping_cost').val()).toFixed(2);
                total_price = parseFloat(total_price).toFixed(2);
                final_price = parseFloat(shipping_cost) + parseFloat(total_price);
                $('#total_cost').text(parseFloat(final_price).toFixed(2));
                $('#total_shiping_cost').text(shipping_cost);
            });



        });
    </script>
@endpush

