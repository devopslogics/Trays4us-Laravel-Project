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

        if(isset($_GET['html']) && $_GET['html'] == 1) {
            $sourcePath = url('uploads/products/'.$filename);
            $customer_logo = url('uploads/users/'.$product->user_logo);
            $care_instruction = url('assets/images/5-care-instructions.png');


			$logo_dimensions = getimagesize(base_path('uploads/users/'.$product->user_logo));
			$logo_width = $logo_dimensions[0]; // Width
			$logo_height = $logo_dimensions[1]; // Height

			// Determine which dimension is larger
			$img_style = '';
			if ($logo_width > $logo_height) {
				// If width is greater than height, set height to auto
				$img_style = 'width: 100%; height: auto;';
			} else {
				// If height is greater than width, set width to auto
				$img_style = 'height: 100%; width: auto;';
			}

				$logo_dimensions = getimagesize(base_path('uploads/users/'.$product->user_logo));
			$logo_width = $logo_dimensions[0]; // Width
			$logo_height = $logo_dimensions[1]; // Height

			// Determine which dimension is larger
			$img_style = '';
			if ($logo_width > $logo_height) {
				// If width is greater than height, set height to auto
				$img_style = 'width: 100%; height: auto;';
			} else {
				// If height is greater than width, set width to auto
				$img_style = 'height: 100%; width: auto;';
			}


        } else  {
            $sourcePath = base_path('uploads/products/'.$filename);
			$type = pathinfo($sourcePath, PATHINFO_EXTENSION);
			$data = file_get_contents($sourcePath);
			$sourcePath = 'data:image/' . $type . ';base64,' . base64_encode($data);


            $customer_logo = base_path('uploads/users/'.$product->user_logo);

			$type = pathinfo($customer_logo, PATHINFO_EXTENSION);
			$data = file_get_contents($customer_logo);
			$customer_logo = 'data:image/' . $type . ';base64,' . base64_encode($data);


            $care_instruction = base_path('assets/images/5-care-instructions.png');

			$type = pathinfo($care_instruction, PATHINFO_EXTENSION);
			$data = file_get_contents($care_instruction);
			$care_instruction = 'data:image/' . $type . ';base64,' . base64_encode($data);

			$logo_dimensions = getimagesize(base_path('uploads/users/'.$product->user_logo));
			$logo_width = $logo_dimensions[0]; // Width
			$logo_height = $logo_dimensions[1]; // Height

			// Determine which dimension is larger
			$img_style = '';
			if ($logo_width > $logo_height) {
				// If width is greater than height, set height to auto
				$img_style = 'width: 100%; height: auto;';
			} else {
				// If height is greater than width, set width to auto
				$img_style = 'height: 100%; width: auto;';
			}


        }

    @endphp

    <style>
        @page {
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }
        .full-page-image {
            width: 100%;
            box-sizing: border-box;
            position: relative;
        }
        .full-page-image img {
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }
        .content {
            width: 100%;
            box-sizing: border-box;
            text-align: center;
            page-break-inside: avoid; /* Avoid breaking this section across pages */
        }
        .content img {
            width: 100%; /* Ensure the image does not overflow horizontally */
            max-height: 1000px; /* Set max height to 1000px to fit within the page */
            object-fit: contain; /* Scale image to fit within the defined height */
        }
        .content p{
            font-weight:light;
        }
    </style>
</head>
<body>

<div class="full-page-image">
    <img src="{{$sourcePath}}" alt="Artist Logo">
</div>

<div style="page-break-after: always;"></div>

<div class="content" style=" padding: 0px 0px; position: relative;  " >
    <div style=" width:{{$product_type->logo_width_print}}px; height:{{$product_type->logo_height_print}}px;
        margin: 0 auto; top: 50%;     position: absolute; left: 50%;
        transform: translate(-50%, -50%);
        " >
        <img src="{{$customer_logo}}"
             style="position: absolute;
                 top: 50%;
                 left: 50.1%;
                 transform: translate(-50%, -50%);
                 object-fit: contain;
                 max-width: 100%;
                 max-height: 100%;
             {!! $img_style !!} /* Apply the dynamic width or height */
                 vertical-align: middle;"
             alt="Artist Logo">
    </div>
    @if($product_type->fx == 1)

        <div  style="position: absolute; left:50%; transform: translate(-50%, -50%); bottom:{{$product_type->care_instructions_top}}px;  margin: {{$product_type->parent_div_margin}}; " >
            <img src="{{$care_instruction}}" style="position: absolute;   height: auto; {{($product_type->care_instruction_width) ? 'width:'.$product_type->care_instruction_width : ''}}px ; max-height: auto;" alt="">
        </div>
    @endif
</div>
<!-- position: absolute; top: 35%;  -->

</body>
</html>
