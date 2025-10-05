<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $filename = $product->feature_image;
        $prefix = 'customer-';

        // Check if the string starts with the prefix
        if (strpos($filename, $prefix) === 0) {
            $filename = substr($filename, strlen($prefix));
        }
        $sourcePath = base_path('uploads/products/'.$filename);
    @endphp

    <style>
        @page {

        }

        body {
            padding: 0;
            margin: 0;
        }

        .full-page-image, .customer-logo {
            width: 100%;
            position: relative;
        }

        .full-page-image img{
            width: 23%;
            /* Ensure correct sizing and positioning */
        }

       .customer-logo img {
            width: 22% !important;
            /* Ensure correct sizing and positioning */
        }


    </style>
</head>
<body>

<div class="full-page-image" style=" 
padding: 0;
   margin: 52px 0px 0px 0px;
 position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
">
    @for($i = 0; $i<32; $i++)
        <img src="{{$sourcePath}}" alt="Artist Logo" style="margin: 28px 0px 0px 0px !important; padding:0px;">
    @endfor
</div>

<div style="page-break-after: always;"></div>

<div class="customer-logo" style="padding: 0;
    margin: 52px 0px 0px 0px;
     position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    
    ">
    @for($i = 0; $i<32; $i++)
            <img src="{{ base_path('uploads/users/'.$customer->customer_logo) }}" style="width: {{$product_type->logo_width_print}}px; margin: 28px 28px 0px 0px !important; padding:0px;">
    @endfor
</div>


</body>
</html>
