<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Password Reset</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="width: 100% !important; height: 100% !important; padding: 0 !important; margin: 0 !important; font-family: Arial, Helvetica, sans-serif;">

<div style="margin: 0 auto; width: 80%; max-width: 640px; font-family: Arial, Helvetica, sans-serif;">
    <div style="background-color: #ff6600; padding: 42px 0; text-align: center;">
        <a href="{{ route('home') }}" target="_blank" style="color: #ffffff; font-size: 18px; font-weight: bold; text-decoration: none;">Trays4Us</a>
    </div>

    @if(isset($is_admin_email) && $is_admin_email)
        <div class="txtTinyMce-wrapper" style="line-height: 1.2;font-size: 12px;color: #44464a;font-family: Nunito, Arial, Helvetica Neue,Helvetica, sans-serif;mso-line-height-alt: 14px;">
            <p>You’ve received the following order from {!! $order->customer->company ?? '' !!}</p>
            <p>{!! $order->customer->company ?? '' !!}</p>
            <p>Attn: {!! $order->customer->first_name ?? '' !!} {!! $order->customer->last_name ?? '' !!}</p>
            <p>{!! $order->customer->shiping_address1 ?? '' !!}</p>
            <p>{!! $order->customer->shiping_address2 ?? '' !!}</p>
            <p> {{ $order->customer->city ?? '' }}, {{ $order->customer->state ? $order->customer->state->abbrev : '' }}  {{ $order->customer->postal_code ?? '-' }}</p>
            <p>{{ $order->customer->country->country_name ?? '-' }}</p>
        </div>
    @endif

    <div style="padding: 12px 0; text-align: center;">
        <a href="{{ route('my-order', ['oid' => $order->id ]) }}"><p>Order number: <span style="font-weight: bold; color: #ff6600;">{{$order->order_number}}</span></p></a>
        <p><strong>Estimated Ship Date:</strong> <span> {{ date('m/d/Y', strtotime($order->estimated_ship_date))}}</span></p>
    </div>

    <div style="background-color: #f6fcfd; padding: 18px;">
        <table cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <tr>
                <th style="text-align: left; color: #ff6600;">Item</th>
                <th style="text-align: center; color: #ff6600;">SKU</th>
                <th style="text-align: center; color: #ff6600;">Quantity</th>
                <th style="text-align: right; color: #ff6600;">Total</th>
            </tr>
            <?php
                $order_item_price = 0;
            ?>

            @foreach($order->orderItems as $item)

                @php
                    $total_item_price = $item->sale_price * $item->quantity;
                    $formatted_item_total_price = number_format($total_item_price, 2);
                    $order_item_price += $total_item_price;
                @endphp
            <tr>
                <td style="padding-top: 12px;">
                    <a href="{{ route('product-detail',['slug' => $item->product->product_slug ]) }}" style="text-decoration: none; color: #000;">
                        @if( !empty($item->product->feature_image) && \Storage::disk('uploads')->exists('/products/small-'.$item->product->feature_image))
                            <img src="{{ url('uploads/products/small-'.$item->product->feature_image) }}" style="width: 100px; height: auto; display: block; margin-bottom: 5px;" alt="{{$item->product->product_name}}" />
                        @endif
                        <p>{!! $item->product->product_name !!}</p>
                    </a>
                </td>
                <td style="text-align: center;"> {{$item->product->product_sku ?? ''}}</td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
                <td style="text-align: right;">${{ $formatted_item_total_price }}</td>
            </tr>
            @endforeach
            <tr style="border-top: 1px solid #ddd;">
                <td colspan="3" style="padding: 18px 0;"><strong>Subtotal</strong></td>
                <td style="text-align: right;">${{ number_format($order_item_price, 2) }}</td>
            </tr>

            @php
                $shipment_cost = 0.00;
                if($order_item_price  <= $site_management->shipping_threshold)
                    $shipment_cost = $site_management->shipping_fee;
            @endphp
            <tr style="border-top: 1px solid #ddd;">
                <td colspan="3" style="padding: 18px 0;"><strong>Shipping</strong></td>
                <td style="text-align: right;">${{number_format($shipment_cost, 2)}}</td>
            </tr>
            <tr style="border-top: 1px solid #ddd;">
                <td colspan="3" style="padding: 18px 0;"><strong>Total</strong></td>
                <td style="text-align: right; font-size: 18px;"><strong>${{ number_format(($order_item_price + $shipment_cost), 2) }}</strong></td>
            </tr>
        </table>
    </div>

    <div style="padding: 24px 0; text-align: center;">
        <p style="padding: 24px 0;">You can find more amazing products on our website.</p>
        <p style="padding: 18px 0;">
            <a href="{{ route('home') }}" style="border: 1px solid #ff6600; color: #ff6600; padding: 10px 20px; text-decoration: none; border-radius: 28px;">View More</a>
        </p>
        <p style="color: #500050;">Sincerely,</p>
        <p style="color: #500050;">Trays4Us Team</p>
        <p><a href="mailto:support@trays4.us" style="color: #000; text-decoration: none;">support@trays4.us</a></p>
    </div>
</div>

</body>
</html>
