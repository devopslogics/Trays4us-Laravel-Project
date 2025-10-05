<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
              //echo $sourcePath.'---'.$customer_logo;
        } else  {

             $sourcePath = base_path('uploads/products/'.$filename);
			 $type = pathinfo($sourcePath, PATHINFO_EXTENSION);
			 $data = file_get_contents($sourcePath);
			 $sourcePath = 'data:image/' . $type . ';base64,' . base64_encode($data);

              $customer_logo = base_path('uploads/users/'.$product->user_logo);

			$type = pathinfo($customer_logo, PATHINFO_EXTENSION);
			$data = file_get_contents($customer_logo);
			$customer_logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

    @endphp

    <style>
        @page {
        margin:0px 0px 0px 0px;
        }

        * {
  box-sizing: border-box;
}

        body {
            padding: 0;
            margin: 0;
            width: 100%;
            height:100%;
        }




    </style>
</head>
<body>

<div class="full-page-image" style="
     padding:0px 0px 0px 0px;
    margin: 448px 0px 0px 0px;
    font-size: 0;
   position: absolute;
" >
    @for($i = 0; $i<32; $i++)
        <img src="{{$sourcePath}}" alt="Artist Logo" style="width: 1240px;  height: 1240px;  display: inline-block;   box-shadow: none;
    border: none;  margin:60px 59px 59px 59px; padding:0px;">
    @endfor
</div>

<div style="page-break-after: always;   "></div>

<div class="customer-logo" style="
    padding: 448px 0px 0px -1px;
    margin: 0px 0px 0px 0px;
    font-size: 0px;
    position: absolute;
">
    @for($i = 0; $i < 32; $i++)
        <div style="width: 450px; height: 450px; transform: rotate(180deg); margin: 454.5px 453px 454.5px 455px; display: inline-block; position: relative;">
            <img src="{{ $customer_logo }}" style="max-width: 100%; max-height: 100%; object-fit: contain; vertical-align: middle; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        </div>
    @endfor
</div>


</body>
</html>
