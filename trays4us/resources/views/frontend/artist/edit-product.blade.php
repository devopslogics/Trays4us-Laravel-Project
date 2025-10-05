@extends('layouts.frontend')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">
    <style>
        .rounded_image_outer .cropper-view-box,.rounded_image_outer .cropper-face { border-radius: 50%;}

        .rounded_image_outer .edit_first_section .cropper-face:before
        {
            content: '';
            position: absolute;
            left: 0px;
            top: 0px;
            transform: scale(1);
            z-index: 999;
            bottom: 0;
            width: 100%;
            background-size: cover;
            background-image: url({{ asset('/assets/frontend-assets/images/rounded-image-li-border.png') }});
            opacity: 0.9;
        }
        .tray-type-1612 .edit_first_section .cropper-face:before
        {
            content: '';
            position: absolute;
            left: 0px;
            top: 0px;
            transform: scale(1);
            z-index: 999;
            bottom: 0;
            width: 100%;
            background-size: cover;
            background-image: url({{ asset('/assets/frontend-assets/images/1612-border.png') }});
            opacity: 0.9;
        }
        .tray-type-4x4 .edit_first_section .cropper-face:before
        {
            content: '';
            position: absolute;
            left: 0px;
            top: 0px;
            transform: scale(1);
            z-index: 999;
            bottom: 0;
            width: 100%;
            background-size: cover;
            background-image: url({{ asset('/assets/frontend-assets/images/4x4-border.png') }});
            opacity: 0.9;
        }
        .tray-type-1105 .edit_first_section .cropper-face:before
        {
            content: '';
            position: absolute;
            left: 0px;
            top: 0px;
            transform: scale(1);
            z-index: 999;
            bottom: 0;
            width: 100%;
            background-size: cover;
            background-image: url({{ asset('/assets/frontend-assets/images/1105-border.png') }});
            opacity: 0.9;
        }
        .tray-type-1108 .edit_first_section .cropper-face:before
        {
            content: '';
            position: absolute;
            left: 0px;
            top: 0px;
            transform: scale(1);
            z-index: 999;
            bottom: 0;
            width: 100%;
            background-size: cover;
            background-image: url({{ asset('/assets/frontend-assets/images/1108-border.png') }});
            opacity: 0.9;
        }
        .ui-widget-content {
    background: #00bb1e;
}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active {
    border: 3px solid #faff00 !important;
    background: #000000 !important;
    font-weight: normal;
    border-radius: 50% !important;

    padding: 16px !important;
    top: -15px !important;
    color: #454545 !important;
}
.ui-widget-header {

    background: #000000;
}
.ui-slider-horizontal {
    height: 4px !important;
}
.ui-widget.ui-widget-content {
    border: 0px solid #c5c5c5 !important;
}
        .cropper-line , .cropper-point{ background-color: initial; }
        .cropper-dashed {border: none;}
        .cropper-face { background-color: transparent !important; left: 0; top: 0; opacity: 1 !important;}
        .edit_image_resolution {
    border-bottom: 1px solid #212529 !important;
}
.edit_second_section {
    max-width: 380px;
}
.ui-widget.ui-widget-content {
    margin: 52px 0px;
    position: relative;
    width: 100%;
    max-width: 450px;

}
.tfu-edit-section-crop {
    max-width: 540px;
}
.artist_images_row, .artist-images-desc_row {
    margin-bottom: 32px;
}
.zoom_persent {
    background: black;
    padding: 1px 10px;
display: flex;
align-items: center;
    height: 46px;
}
 .edit_first_section .cropper-face:before {
    content: '';
    position: absolute;
    left: 0px;
    border: 4px solid #00BB1E;
}
.tfu-edit-border {
    width: 1px;
    background: #000;
    height: 761px;
    padding: 0px;
}
.tfu-edit-section-crop #cropper_slider::before {
    content: '';
    width: 12px;
    height: 12px;
    background: #000;
    position: absolute;
    top: -4px;
    border-radius: 20px;
}
.tfu-edit-section-crop #cropper_slider::after {
    content: '';
    width: 18px;
    height: 18px;
    background: #00bb1e;
    position: absolute;
    top: -7px;
    right: -10px;
    border-radius: 20px;
}
span.tfu-ui-span-corner {
    width: 16px;
    height: 16px;
    background: #000;
    position: absolute;
    border-radius: 20px;
    border: 2px solid #00bb1e;
    top: -6px;
}
.tfu-edit-section-crop {
    padding: 10px;
}
        @media (max-width: 576px) {
            .tray-type-R157 #edit_image_container {
             width: 350px !important;
             height: 350px !important;
             margin: 0;
         }
          .tray-type-1612 #edit_image_container {
            width: 340PX !important;
             height: 265px !important;
             margin: 0;
          }
        }
        @media (max-width: 420px) {
            .tray-type-R157  #edit_image_container {
             width: 300px !important;
             height: 300px !important;
             margin: 0;
         }
         .tray-type-1105 #edit_image_container {
             width: 330px !important;
             height: 170px !important;
         }
         .tray-type-1108  #edit_image_container {
             width: 330px !important;
             height: 255px !important;
         }

        }

</style>
@endpush
@section('content')

    <section class="tfu-license-artwork-wrapper">
        <div class="container-fluid p-0">
            <div class="tfu-general-breadcumb-wrapper">

                <div class="tfu-general-heading">
                    <h1>Preview</h1>
                </div>

                <ul class="shop-breadcrumb">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Design Tool</li>
                </ul>

            </div>

            @php
                $getProductTypeDetail = array();
                if(isset($temp_product->pt_sub_id) AND $temp_product->pt_sub_id > 0)
                  $getProductTypeDetail  = \App\Traits\Definations::getProductTypeDetail($temp_product->pt_sub_id);


                $tray_type_html_class = 'tray-type-'.$getProductTypeDetail->child->sku;
                $html_class  = 'rectangle_image';
                if(isset($temp_product->product_sku) AND !empty($temp_product->product_sku))
                  $html_class  = \App\Traits\Definations::getCustomProductHtmlClass($temp_product->product_sku);

               $moq_case_pack = array();
               if(isset($temp_product->product_customizable) AND isset($temp_product->pt_sub_id))
                    $moq_case_pack  = \App\Models\Helper::get_moq_case_pack($temp_product->product_customizable,$temp_product->pt_sub_id);

               $width = $getProductTypeDetail->child->width/10 ?? 600;
               $height = $getProductTypeDetail->child->height/10 ?? 600;

                if($getProductTypeDetail->child->fx == 0) {
                    $width = ($getProductTypeDetail->child->width/10)*2 ?? 600;
                    $height = ($getProductTypeDetail->child->height/10)*2 ?? 600;
                }

                $logo_width = '60';
                if($getProductTypeDetail->child->logo_width > 0) {
                  $logo_width = ($getProductTypeDetail->child->logo_width/1500) * $getProductTypeDetail->child->logo_width;
                }

                // This is all for defulat percetange

                $image_orginal_name = getimagesize(base_path('uploads/customizer-products/'.$temp_product->fetaure_image_orginal_name));
                $orginal_width = $image_orginal_name[0];
                $orginal_height = $image_orginal_name[1];
                $scalePercent = (($width * 100) /($orginal_width/10));

                $zoomPercentStyles = '';

                if ($scalePercent <= 100) {
                    $zoomPercentStyles = 'background-color: #00BB1E; color: white;';
                }

            @endphp

            <form action="{{ route('save-edit-product') }}" method="post" enctype="multipart/form-data" name="save_edit_product" id="save_edit_product">
                @csrf
                <input type="hidden" value="{{$temp_product->id}}" id="product_id">
                  <div class="row artist_images_row preview_artist edit_items_row align-items-start {{$html_class}}_outer {{$tray_type_html_class}}">

                    <div class="col-12 tfu-edit-section-crop">
                        <div class="edit_first_section">
                            <div class="edit_image_conntainer" id="edit_image_container" style="width: {{$width}}px;height: {{$height}}px">
                                <img src="{{ url('uploads/customizer-products/'.$temp_product->fetaure_image_orginal_name) }}" data-image-name="{{$temp_product->feature_image}}" id="custom_edit_image" alt="" class="{{$html_class}} {{$tray_type_html_class}} w-100">
                            </div>
                            <div class="zoom_in_out">
                                <div class="zoom_feature">
                                    <span class="zoom_in" id="zoom-in"><img src="{{ asset('/assets/images/zoom_in.svg') }}" alt=""></span>
                                    <canvas id="canvas" style="display: none;"></canvas>
                                </div>
                                <div class="zoom_persent"><span id="zoom-percentage" style="{{ $zoomPercentStyles }}">{{ round($scalePercent)}}%</span></div>
                                <div class="zoom_feature">
                                    <span class="zoom_out" id="zoom-out"><img src="{{ asset('/assets/images/zoom_out.svg') }}" alt=""></span>
                                    <canvas id="canvas" style="display: none;"></canvas>
                                </div>
                            </div>
                        </div>
                        <div id="cropper_slider" class="ep-slider-bar ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                            <span tabindex="0" class="tfu-ui-span-corner" style="left: 30%;"></span>
                            <div class="ui-slider-range ui-corner-all ui-widget-header ui-slider-range-min" style="width: 0%;"></div>
                            <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;"></span>

                        </div>
                        <p class="edit_image_sizes">Optimal image file size for this product:</p>
                        <ul class="mt-2 image-resolutions list-unstyled p-0">
                            <li class="m-0 p-0 d-flex gap-4 text-black">
                                <span class="edit_image_reso" >{{$getProductTypeDetail->child->width}} x {{$getProductTypeDetail->child->height}} px</span>
                                <span>{{$getProductTypeDetail->child->type_name}} {{$getProductTypeDetail->type_name}}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="tfu-edit-border d-none d-lg-block" >
                             
                    </div>

                    <div class="col-12 col-lg-6 edit_second_section ">
                        <h2 class="title_edit_image">{{ $temp_product->product_name ?? ''}}</h2>
                        <h3 class="edit_sub_title">{{ $getProductTypeDetail->child->type_name ?? '' }} {{ $getProductTypeDetail->type_name ?? ''}}</h3>
                        <div class="edit_image_price">
                            <p>${{ $temp_product->price ?? ''}}<span> {{ (isset($site_management->msrp_price) && $site_management->msrp_price > 0 ) ? 'MSRP $'.number_format(ceil($site_management->msrp_price * $temp_product->price),2)  : '' }}</span></p>
                        </div>
                        <ul class="order_details_edit_image list-unstyled p-0">
                            <li>Minimum Order {{ (isset($moq_case_pack->minimum_order_quantity) && $moq_case_pack->minimum_order_quantity > 0) ? $moq_case_pack->minimum_order_quantity  : 1 }}</li>
                            <li>Case Pack of {{ (isset($moq_case_pack->case_pack) && $moq_case_pack->case_pack > 0) ? $moq_case_pack->case_pack  : 1 }}</li>
                        </ul>
                        @if($getProductTypeDetail->child->fx == 1)
                            <div class="edit_logo_image tfu_custom_artist_logo">
                                <img src="{{ asset('/assets/images/'.$getProductTypeDetail->child->tray_blank_image) }}" alt="">
                                <div class="logo-preview">
                                    <img src="{{ url('uploads/users/'.$customer->customer_logo) }}" style="max-width: {{$logo_width}}px" class="tfu_artist_logo_on_tray" alt="">
                                </div>
                            </div>
                        @else
                            <div class="edit_logo_image tfu_custom_artist_logo">
                                <img src="{{ url('uploads/customizer-products/customer-'.$temp_product->crop_image) }}" alt="">
                            </div>
                        @endif
                    </div>

                  </div>
                  <div class="row">
                    <div class="col-12 p-0">
                        {{-- <p class="p-0" >Resolution of the image : <span id="image_dimension">{{ $orginal_width.'px x '.$orginal_height}}px</span></p>

                        <div class="col-12 p-3 edit_note text-center">
                            <p class="m-0"><b>Note: The uploaded image could have a higher resolution for the best print quality. </b></p>
                        </div> --}}
                        <div id="cropper_slider" class="ep-slider-bar"></div>
                    </div>

                    <div class="col-12 edit_image_resolution ">
                        
                        <div id="prog-wrapper" class="col-8 col-mx-auto mt-2" style="display: none;">
                            <h2>Uploading...</h2>
                            <div class="bar">
                                <div id="upload-prog" class="bar-item" role="progressbar" style="width: 0%;"></div>
                            </div>
                        </div>

                    </div>

                    <div class="row  border-dark pt-3 pb-5 d-flex justify-content-between  button_section gap-2">
                        <div class="col-12 col-sm-4 col-lg-6 ">
                            <button type="button" class="btn btn-secondary w-100" id="edit_support">Support</button>
                        </div>
                        <div class="col-12 col-sm-6  col-lg-5 col-xl-4 d-flex gap-4 justify-content-between justify-content-lg-end">
                            <a href="{{route('preview-your-work')}}" class="btn btn-secondary w-100" id="edit_cancel">Cancel</a>
                            <button type="button" class="btn  edit_primary_btn" id="edit_update">Update</button>
                        </div>
                    </div>

                    <div class="col-12 p-0 pt-3 pb-5 artwork-terms">
                        <p class="text-black">By uploading you confirm that you agree to these <a href="{{ route('term-condition') }}" class="text-underline text-black">terms.</a></p>
                    </div>

                </div>
            </form>
            <div id="result"></div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

    <script>

        function getRoundedCanvas(sourceCanvas) {
            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');
            var width = sourceCanvas.width;
            var height = sourceCanvas.height;

            canvas.width = width;
            canvas.height = height;
            context.imageSmoothingEnabled = true;
            context.drawImage(sourceCanvas, 0, 0, width, height);
            context.globalCompositeOperation = 'destination-in';
            context.beginPath();
            context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI, true);
            context.fill();
            return canvas;
        }

        window.addEventListener('DOMContentLoaded', function () {
            var image = document.getElementById('custom_edit_image');
            var button = document.getElementById('edit_update');
            var result = document.getElementById('result');
            var croppable = false;
            var zoomPercentageDisplay = document.getElementById('zoom-percentage');
            var resolutionDisplay = document.getElementById('image_dimension');
            var zoomLevel = 1;
            const optimalWidth = {{$getProductTypeDetail->child->width}};
            const optimalHeight = {{$getProductTypeDetail->child->height}};
            originalZoom = {{$scalePercent}}; // Initial value
            currentZoom = originalZoom; // Current zoom percentage
            let slideValGlobal = 1;
            let previousSlideVal = 1;
            var cropper = new Cropper(image, {
               // aspectRatio: {{$getProductTypeDetail->child->width/$getProductTypeDetail->child->height}},
                viewMode: 3,
                autoCropArea: 1,
                minCropBoxWidth: {{$getProductTypeDetail->child->width}},
                minCropBoxHeight: {{$getProductTypeDetail->child->height}},
                autoCrop: true,
                ready: function () {
                    croppable = true;
                },
            });

            button.onclick = function () {

                var croppedCanvas;
                var roundedCanvas;
                var roundedImage;

                if (!croppable) {
                    return;
                }

                // Crop
                croppedCanvas = cropper.getCroppedCanvas({
                    width: {{$getProductTypeDetail->child->width}},
                    height: {{$getProductTypeDetail->child->height}}
                });

                canvas = croppedCanvas;

                if($('.artist_images_row').hasClass('rounded_image_outer')){
                    canvas = getRoundedCanvas(croppedCanvas);
                }

                $('#tfu_loading').show();

                // Convert the canvas to a blob
                canvas.toBlob(function(blob) {
                    var image_name = $('#custom_edit_image').attr('data-image-name');
                    var product_id = $('#product_id').val();
                    // Create a URL for the blob
                    var url = URL.createObjectURL(blob);

                    // Read the blob as a data URL
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function() {
                        var base64data = reader.result;

                        // Send the base64 data and the original file extension via AJAX
                        $.ajax({
                            url: '{{ route('save-edit-product') }}',
                            method: 'POST',
                            data: {
                                image: base64data,
                                image_name: image_name,
                                product_id: product_id,
                                _token: '{{ csrf_token() }}' // Include CSRF token if needed
                            },
                            success: function(response) {
                                $('#tfu_loading').hide();
                                if(response.status == 'success') {
                                    window.location.href = response.redirect_url + '?refresh=' + new Date().getTime();
                                   // window.location.reload(true);
                                }
                            }
                        });
                    };
                });

            };

            <?php /*
            function updateZoomPercentageOnPageLoad() {
                naturalWidth = image.naturalWidth;
                naturalHeight = image.naturalHeight;

                const width = {{$width}}; // Laravel variable
                //const imageData = cropper.getImageData();
                //const canvasData = cropper.getCanvasData();
                const scalePercent = ((width * 100) /(naturalWidth/10));
                 originalZoom = scalePercent; // Initial value
                 currentZoom = originalZoom; // Current zoom percentage
                zoomPercentageDisplay.textContent = Math.round(scalePercent) + '%';
                if(scalePercent <= 100)
                {
                    $('.zoom_persent').css({
                        'background-color': '#00BB1E',
                        'color': 'white'
                    });
                }
                resolutionDisplay.textContent = `${naturalWidth} x ${naturalHeight} px`;
            }

            updateZoomPercentageOnPageLoad();
            */ ?>

            const cropper_slider = $("#cropper_slider");

            cropper_slider.slider({
                range: "min",
                min: 1,
                max: 10,
                step: 1,
                value: 1, // Set the initial value of the slider
                slide: function(event, ui) {
                    let slideVal = ui.value;
                    slideValGlobal = slideVal;

                    // If previous value is greater, it means zoom out
                    if (previousSlideVal > slideValGlobal) {
                        currentZoom = Math.min(currentZoom / 0.9, originalZoom); // Apply zoom out
                        cropper.zoom(-0.1);  // Zoom out by 10%
                    }
                    // If previous value is less, it means zoom in
                    else if (previousSlideVal < slideValGlobal) {
                        currentZoom = Math.min(currentZoom * 0.9, originalZoom); // Apply zoom in
                        cropper.zoom(0.1);  // Zoom in by 10%
                    }

                    // Update zoom percentage display
                    zoomPercentageDisplay.textContent = Math.round(currentZoom) + '%';

                    // Update the previous slider value
                    previousSlideVal = slideValGlobal;
                }
            });

            // Zoom In
            document.getElementById('zoom-in').addEventListener('click', function (e) {
                e.preventDefault();

                // Update slider value and zoom level
                if (slideValGlobal < 10) { // Limit the zoom-in to max value of 10
                    slideValGlobal += 1;
                    cropper_slider.slider("value", slideValGlobal); // Update the slider
                    currentZoom = Math.min(currentZoom * 0.9, originalZoom); // Apply the zoom formula (increase zoom)
                    zoomPercentageDisplay.textContent = Math.round(currentZoom) + '%'; // Update display

                    // Apply zoom using cropper.zoom() (zoom in)
                    cropper.zoom(0.1); // Zoom in by 10%
                }
            });

            // Zoom Out
            document.getElementById('zoom-out').addEventListener('click', function (e) {
                e.preventDefault();

                // Update slider value and zoom level
                if (slideValGlobal > 1) { // Limit the zoom-out to min value of 1
                    slideValGlobal -= 1;
                    cropper_slider.slider("value", slideValGlobal); // Update the slider

                    currentZoom = Math.min(currentZoom / 0.9, originalZoom); // Apply the zoom formula (decrease zoom)
                    zoomPercentageDisplay.textContent = Math.round(currentZoom) + '%'; // Update display

                    // Apply zoom using cropper.zoom() (zoom out)
                    cropper.zoom(-0.1); // Zoom out by 10%
                }
            });

        });


    </script>

@endpush
