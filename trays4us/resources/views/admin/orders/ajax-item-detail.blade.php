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
                    <div class="text-uppercase "> Unit Price </div>
                </th>

                <th scope="col" class="border-0 bg-light ">
                    <div class="text-uppercase "> Total price </div>
                </th>


            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->product_name }}</td>
                    <td><strong>{{ $item->quantity }}</strong></td>
                    <td>{{ $item->sale_price }}</td>
                    <td>{{ $item->sale_price * $item->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


@if($order->customer)
    <div class="row m-0">
        <div class="col-md-4 mb-1">
            <span><b>Name:</b>{{ $order->customer->first_name.' '.$order->customer->last_name }} </span>
        </div>
        <div class="col-md-4 mb-1">
            <span><b>Phone:</b> {{ $order->customer->phone ?? '-' }}</span>
        </div>
        <div class="col-md-4 mb-1">
            <span> <b>Email:</b> {{ $order->customer->email ?? ''}}</span>
        </div>
        <div class="col-md-4 mb-1">
            <span> <b>Shipping address 1:</b> {{ $order->customer->shiping_address1 ?? '-'}}</span>
        </div>
        <div class="col-md-4 mb-1">
            <span> <b>Shipping address 2:</b> {{ $order->customer->shiping_address2 ?? '-'}}</span>
        </div>
    </div>
@endif

