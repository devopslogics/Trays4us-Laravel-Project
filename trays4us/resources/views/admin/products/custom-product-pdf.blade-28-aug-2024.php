<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @page {
            size: {{$page_type}}; /* Set page size */
            margin: 0; /* Remove margins */
        }
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden; /* Prevent scrollbars */
        }
        .full-page-image {
            width: 100%;
            height: 100vh; /* Full viewport height */
            box-sizing: border-box;
            position: relative;
        }
        .full-page-image img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensure image covers the container */
            position: absolute;
            top: 0;
            left: 0;
        }

        .content {
            width: 100%;
            box-sizing: border-box;
            text-align: center;
        }
    </style>
</head>
<body>

@php
    $filename = $product->feature_image;
    $prefix = 'customer-';

    // Check if the string starts with the prefix
    if (strpos($filename, $prefix) === 0) {
        $filename = substr($filename, strlen($prefix));
    }
	$sourcePath = base_path('uploads/products/'.$filename);
@endphp

<div class="full-page-image">
    <img src="{{$sourcePath}}">
</div>

<div style="page-break-after: always;"></div>

<div class="content" style="padding: 280px 0px">
    <img src="{{ base_path('uploads/users/'.$customer->customer_logo) }}" style="width: 250px; height: auto;" alt="Artist Logo">
</div>
<div class="content" style="">
    <p style="display: inline-block; margin: 20px; color: gray; width: 102px; font-family: 'Noto Sans', sans-serif;">Not for use in microwave</p>
    <p style="display: inline-block; margin: 20px; color: gray; width: 102px; font-family: 'Noto Sans', sans-serif;">Not dishwasher safe</p>
    <p style="display: inline-block; margin: 20px; color: gray; width: 102px; font-family: 'Noto Sans', sans-serif;">Made of bitch wood</p>
    <p style="display: inline-block; margin: 20px; color: gray; width: 102px; font-family: 'Noto Sans', sans-serif;">Custom trays by Trays4us</p>
    <p style="display: inline-block; margin: 20px; color: gray; width: 102px; font-family: 'Noto Sans', sans-serif;">Made in Finland</p>
</div>

</body>
</html>
