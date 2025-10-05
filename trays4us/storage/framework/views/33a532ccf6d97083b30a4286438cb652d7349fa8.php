<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/dropzone.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/tags.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/jquery-ui.min.css')); ?>">
    <style>
        .dropzone .dz-message { margin: 0 !important;}
        .dropzone .dz-preview .dz-progress ,.dropzone .dz-preview .dz-error-message,.dropzone .dz-preview .dz-success-mark, .dropzone .dz-preview .dz-error-mark ,.dropzone .dz-preview .dz-details{display: none;}
        /*.artist_gallery .dz-preview .dz-image {max-height: 250px !important;}*/
        .artist_gallery .dz-preview.dz-image-preview{width: 100%;max-width: 250px;margin:0px 0px;}
        .artist_gallery .dz-preview .dz-image ,.artist_logo_img .dz-preview .dz-image{width: 100%;height: auto;overflow: hidden !important;}
        .artist_logo_img .dz-preview .dz-image{max-height:250px;}
        .artist_gallery .dz-preview .dz-image img {    object-fit: contain; height: 100%; width: 100%; }
        .dropzone .dz-preview.dz-file-preview .dz-image img {width: 100%;object-fit: contain !important;height: 100% !important;}
        .dropzone  .dz-preview .dz-image {    width: 100% !important;  height: 230px; }
        .dropzone .dz-preview:hover .dz-image img { filter: none !important; }
        .artist_logo_img .dz-preview.dz-image-preview {margin: 0px;width: 100%;max-width: 250px;}
        .swal2-timer-progress-bar {background: #FF6600;height: 13px;}
        .dropzone .dz-preview.dz-file-preview .dz-image { border-radius: unset !important;}
        .top_images_gallery p strong , .top_artist_logo p strong { cursor: pointer; }
        .dropzone .dz-preview {  min-height: initial;  }
        .dropzone .dz-preview .dz-remove { font-size: 14px; text-align: center; padding: 16px 0px 5px 0px; line-height: 0; margin: 0; display: block; cursor: pointer; border: none; text-decoration: none !important; color: #ec4c4c; }
        .dropzone .dz-preview {    margin: 0px; }
        .dropzone .dz-preview .dz-image img { object-fit: contain !important; height: 100% !important; }
        input.tfu_product_ids +label { left: 0; }
        .chexbox-artist { display: flex; gap: 28px; margin-bottom: 16px; }
        .image-resolutions-p span {  font-size: 18px; }
        .tfu-image-sku-type { width: 264px;   text-align: left; }
        .tfu-step-item{width: 100%;max-width: 236px;}
        .tfu-step-optimize{}
        .tfu-step-optimize,.tfu-step-item,.tfu-step-create{font-size: 18px; font-weight: bold;}
        .tfu-step-create {width: 44px;}
        .artwork-upload-images-text {   font-size: 21px; font-family: 'Bitter';   width: 570px;  margin-top: 12px; }
        .tfu-resolution-note { border: 1px solid #858585;border-radius: 5px;text-align: center;margin-bottom: 20px;padding: 20px;}
        .tfu-resolution-note p { padding: 0; margin: 0; font-family: 'Noto Sans';font-weight: 700; font-size: 21px;text-align: center;max-width: 597px;margin: auto;}
        .tfu-resolution-note { border: 1px solid #858585; border-radius: 5px; text-align: center; margin-bottom: 20px; padding: 18px 0px; }
        .back_logo .align-items-end {align-items: center !important;}
        span.tfu-logo-resolutions {   font-weight: 700;  font-family: 'Noto Sans'; }
        .artist_images_row, .artist-images-desc_row {padding: 25px 0px;justify-content: space-between;}
        .upload-images-dimension {position: absolute;bottom: 0px;left: 50%;transform: translate(-50%, 0%);background: #454545;color: #fff;padding: 4px 15px;font-family: Noto Sans;font-size: 15px;font-weight: 700;line-height: 20.43px;text-align: center;}
        .upload-images-dimension.dimension-logo{width:123px;}
        .upload-images-dimension.dimension-images{min-width: 299px;}
        .tfu_resolutions_highlight {font-weight: 700;}
        .top_images_gallery p:hover,.top_artist_logo p:hover {color: #454545 !important;transform: scale(1.1);}

    @media (max-width: 1400px) {

        .image-resolutions p, .backlogo_top p, .back-logo_bottom p, h3.sizes_title, .image-resolutions li span, .edit_note p, h3.edit_sub_title {
            font-size: 18px;
        }
        .tfu-image-sku-type {width: 210px;}
        .tfu-step-item {width: 100%;max-width: 180px;}
        .tfu-step-optimize, .tfu-step-item, .tfu-step-create {font-size: 16px;}
        .artist-images-desc_row , .tfu-upload-wrap {flex-wrap: nowrap !important;}
        .artist_images_row, .artist-images-desc_row {flex-wrap: nowrap;}
        .chexbox-artist input.tfu_product_ids {width: 43px;}
    }

    @media (max-width: 1200px) {
        .image-resolutions-p span {font-size: 16px;}
    }

    @media (max-width: 992px) {
    .artist-images-desc_row , .tfu-upload-wrap {flex-wrap: wrap !important;}
    .artist_images_row, .artist-images-desc_row {flex-wrap: wrap;}
    .artwork-images_sizes_section { margin-top: 10px; }
    }

    @media (max-width: 767px) {
        .tfu-step-create{width: 34px;}
        .artwork-upload-images-text { width: 100%; }
        .tfu-image-sku-type {   width: 100%;max-width:182px;  text-align: left; }
        .tfu-step-optimize {font-size: 18px; float: right; }
        .tfu-step-item { max-width:154px; font-size: 18px;}
        .image-resolutions-p span {   font-size: 15px; }
        .tfu-resolution-note {padding: 18px 18px;}
        .tfu-resolution-note p { font-size: 16px;}
        .tfu-current-upload-your-work input.tfu_product_ids +label {height: 24px;width: 32px; }
        input.tfu_product_ids +label, .chexbox-artist input.tfu_product_ids {min-height: 22px;height: 22px;width: 34px;}
        .image-resolutions-p {width: 100%;}
        .back_logo {padding: 14px;}
        .image-resolutions-p span {font-size: 15px;white-space: nowrap;}
        input.tfu_product_ids:checked + label:after {left: 12px;width: 9px;height: 19px;}
    }

    @media (max-width: 576px) {
    .image-resolutions-p span {font-size: 13px;}
    .tfu-step-item , .tfu-step-create , .tfu-step-optimize {font-size: 16px;white-space: nowrap;}
    }

</style>

<?php $__env->stopPush(); ?>


<?php $__env->startSection('content'); ?>

    <section class="tfu-license-artwork-wrapper">
        <div class="container-fluid p-0">

            <div class="tfu-general-breadcumb-wrapper">

                <div class="tfu-general-heading">
                    <h1>Upload Your Artwork</h1>
                </div>

                <ul class="shop-breadcrumb">
                    <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
                    <li>Upload Your Artwork</li>
                </ul>

            </div>

            <!-- Artist Images Upload -->
            <form action="<?php echo e(route('save-artist-work')); ?>" method="post" enctype="multipart/form-data" name="add_artist_work" id="add_artist_work" class="dropzone" onsubmit="return false;">

            <?php echo csrf_field(); ?>

                <div class="row artist_images_row">

                    <div class="col-12 col-lg-8 artwork_gallery p-0 overflow-hidden position-relative">
                        <h4>Step 01</h4>
                        <div id="dropzoneDragArea" class="dz-default dz-message dropzoneDragArea">
                            <div class="top_images_gallery p-2 m-0">
                                <p class="mb-0 text-white text-center"><strong><span class="dz-default dz-message">Click Here To <br>Upload ( JPG, PNG )</span></strong></p>
                            </div>
                            <div class="artist_gallery d-flex flex-wrap justify-content-center align-items-center">
                                <div id="upload_image">
                                    <img src="<?php echo e(asset('/assets/images/T4Us_Blank_Front_5.png')); ?>" alt="">
                                    <img src="<?php echo e(asset('/assets/images/T4Us_Blank_Front_6.png')); ?>" alt="">
                                    <img src="<?php echo e(asset('/assets/images/T4Us_Blank_Front_2.png')); ?>" alt="">
                                    <img src="<?php echo e(asset('/assets/images/T4Us_Blank_Front_1.png')); ?>" alt="">
                                    <img src="<?php echo e(asset('/assets/images/T4Us_Blank_Front_3.png')); ?>" alt="">
                                </div>
                                <div class="dropzone-previews-image"></div>
                            </div>
                            <div class="upload-images-dimension dimension-images tfu_front_tray" style="display: none">Your image size is <span id="tfu_images_dimension"></span></div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 artist_logo p-0 overflow-hidden position-relative">
                        <h4>Step 02</h4>

                        <div id="logo_image_area" class="dz-default dz-message dropzoneDragArea">
                            <div class="top_artist_logo p-2 m-0">
                                <p class="mb-0 text-white text-center"><strong><span class="dz-default dz-message">Click Here To <br>Upload ( JPG, PNG )</span></strong></p>
                            </div>
                            <div class="artist_logo_img text-center">
                                <div id="upload_logo">
                                    <?php if( !empty($is_customer->customer_logo) && \Storage::disk('uploads')->exists('/users/' .$is_customer->customer_logo)): ?>
                                        <img src="<?php echo e(url('uploads/users/'.$is_customer->customer_logo)); ?>" alt="" data-logo="1" class="w-100">
                                    <?php else: ?>
                                        <img src="<?php echo e(asset('/assets/images/T4Us_Blank_Back_4.png')); ?>" alt="" data-logo="0" class="w-100">
                                    <?php endif; ?>
                                </div>
                                <div class="dropzone-previews-logo"></div>
                            </div>
                            <div class="upload-images-dimension dimension-logo tfu_tray_logo" style="display: none"><span></span></div>
                        </div>
                    </div>

                </div>

                <div class="row artist-images-desc_row  ">

                    <div class="col-12 col-lg-4 artwork_name p-0">
                    <h4>Step 03</h4>
                        <div class="form-input">
                            <label class="text-black" for="Artwork">Name for the Artwork *</label>
                            <input type="text" class="form-control border border-dark rounded" name="product_name" id="product_name">
                        </div>
                    </div>

                    <div class="col-12 col-lg-8 artwork-images_sizes_section p-2">
                        <!-- <h3 class="text-black p-0 sizes_title  text-black" style="margin-bottom: 22px;"><b>Optimal Image Sizes</b></h3> -->
                        <?php /*<p class="artwork-upload-images-text text-black"></p> */ ?>

                        <div class="row d-flex  justify-content-md-start  justify-content-evenly tfu-upload-wrap" >
                            <div class="col-12 col-md-7 col-lg-8 Front_logo">
                                <h3 class="text-black p-0 sizes_title text-black"><b>Front Image</b></h3>
                                <h3 class="text-black p-0 sizes_title" style="display: flex;gap: 28px;margin-bottom: 12px;">
                                    <span class="tfu-step-create">Create</span>
                                    <span class="tfu-step-item" >Item</span>
                                    <span class="tfu-step-optimize" >Optimal Size</span>
                                </h3>
                                <div class="mt-2 image-resolutions">
                                    <?php if($product_types->isNotEmpty()): ?>
                                        <?php $__currentLoopData = $product_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $__currentLoopData = $product_type->child_types_having_criteria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="chexbox-artist  position-relative">
                                                    <input type="checkbox" name="product_types[]" value="<?php echo e($childType->id); ?>" class="tfu_product_ids position-relative">
                                                    <label for="checkbox" class="position-absolute"></label>
                                                    <p class="m-0 p-0 d-flex gap-0 text-black image-resolutions-p"><span class="tfu-image-sku-type" ><?php echo e($childType->type_name); ?> <?php echo e($product_type->type_name); ?></span><span class="tfu-image-resolutions" data-width="<?php echo e($childType->width); ?>" data-height="<?php echo e($childType->height); ?>"><?php echo e($childType->width); ?> x <?php echo e($childType->height); ?> px</span> </p>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12 col-md-4  col-lg-4 back_logo p-lg-0">
                                <div class="backlogo_top mb-4 mb-lg-5">
                                    <h3 class="text-black p-0 sizes_title mb-0 text-black"><b>Back Logo <br>Longer side more than 750 pixels</b></h3>
                                    <p class="backlogo_description text-black p-0 m-0">All white will become transparent. Best with transparent background.</p>
                                </div>
                                <div class="back-logo_bottom d-flex gap-4 align-items-end">
                                <img src="<?php echo e(asset('/assets/images/back_logo.png')); ?>" alt="">
                                    <div class="description">
                                        <p class="m-0 p-0 d-flex gap-4 text-black back-logo-p"><span class="tfu-logo-resolutions" data-width="500" data-height="100">bigger side ≥ 750 px</span></p>
                                        <p class="m-0 p-0 d-flex gap-4 text-black back-logo-p"><span class="tfu-logo-resolutions" data-width="100" data-height="500">smaller side ≥ 200 px</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tfu-resolution-note" >
                              <p>The green color indicates that the uploaded artwork exceeds the maximum print resolution.</p>
                        </div>
                    </div>
                </div>
                <div class="row gap-4" >
                    <div class="col-12 border-top border-dark pt-3 pb-5 d-flex justify-content-between p-0 button_section">
                        <a href="mailto:support@trays4.us" class="btn btn-secondary w-100" id="">Support</a>
                        <button type="button" class="btn btn-primary artist_upload" id="artist_upload_save_btn">Upload</button>
                    </div>

                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <div class="alert alert-success alert-block alert-success-div mb-0" style="display: none !important">
                        <button type="button" class="close" data-bs-dismiss="alert">×</button>
                        <strong></strong>
                    </div>


                    <div class="col-12 p-0 pt-3 pb-5 artwork-terms">
                        <p class="text-black">By uploading you confirm that you agree to these <a href="<?php echo e(route('term-condition')); ?>" class="text-underline text-black">terms.</a></p>
                    </div>
                </div>
            </form>

        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/tags.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/dropzone.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jquery-ui.min.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Dropzone.autoDiscover = false;
        let token = $('[name="_token"]').val();
        let formData = new FormData();
        var current_logo_file = null
        var current_tray_image = null
        $(function() {

            var mainTrayDropzone = new Dropzone("#dropzoneDragArea", {
                paramName: "tray_image",
                url: "#", // Not used since we are sending files manually
                previewsContainer: '.dropzone-previews-image',
                thumbnailWidth: null,
                thumbnailHeight: null,
                dictDefaultMessage: "Drop files here or click to upload (600x600)",
                dictRemoveFile: "Delete",
                addRemoveLinks: true,
                autoProcessQueue: false,
                parallelUploads: 1,
                uploadMultiple: true,
                acceptedFiles: "image/*",
                maxFiles: 1,
                maxFilesize: 9999, // Increase max file size to 20 MB
                params: {
                    _token: token
                },
                init: function() {
                    var myDropzone = this;

                    this.on("addedfile", function(file) {
                        if (this.files.length > 1) {
                            this.removeAllFiles();
                            this.addFile(file);
                        } else {
                            $('#upload_image').hide();
                        }

						 // Remove file extension from the file name
                        var fileNameWithoutExtension = file.name.substring(0, file.name.lastIndexOf('.'));
                        // Assign the file name without extension to the text field
                        $('#product_name').val(fileNameWithoutExtension);

                        formData.append('tray_image', file);

                        // Reset all resolutions to default color
                        $('.resolution').parent().removeClass('highlight');

                        // Manually create thumbnail for large files
                        if (file.size > 10 * 1024 * 1024) { // Larger than 10 MB
                            var reader = new FileReader();
                            reader.onload = function(event) {
                                // Update the thumbnail image src attribute with the file data URL
                                file.previewElement.querySelector("[data-dz-thumbnail]").src = event.target.result;
                                file.previewElement.querySelector("[data-dz-thumbnail]").style.width = "100%"; // Ensure it fits the container

                                var image = new Image();
                                image.src = event.target.result;
                                image.onload = function() {
                                    var width = this.width;
                                    var height = this.height;
                                    $('.tfu_front_tray').show();
                                    $('#tfu_images_dimension').text(width + 'px x ' + height + 'px');
                                    //$('.tfu-front-size').remove();
                                   // var span = $('<span class="tfu-front-size">').text(width + 'px x ' + height + 'px');
                                   // $('.artist_gallery  .dz-remove').before(span);
                                    highlightMatchingResolutions('tfu-image-resolutions', width, height);
                                };
                                image.onerror = function() {
                                    console.error("Error loading image");
                                };
                            };
                            reader.onerror = function() {
                                console.error("Error reading file");
                            };
                            reader.readAsDataURL(file);
                        }
                    });

                    this.on("thumbnail", function(file, dataUrl) {
                        var image = new Image();
                        image.src = dataUrl;
                        image.onload = function() {
                            var width = this.width;
                            var height = this.height;
                            $('.tfu_front_tray').show();
                            $('#tfu_images_dimension').text(width + 'px x ' + height + 'px');
                            //$('.tfu-front-size').remove();
                            //var span = $('<span class="tfu-front-size">').text(width + 'px x ' + height + 'px');
                            //$('.artist_gallery  .dz-remove').before(span);
                            highlightMatchingResolutions('tfu-image-resolutions', width, height);
                        };
                        image.onerror = function() {
                            console.error("Error loading image");
                        };
                    });

                    this.on("error", function(file, message) {
                        console.error("Error:", message);
                        //alert("Error: Supported file formats are JPG, PNG");
                    });

                    this.on("removedfile", function(file) {
                        $('.image-resolutions-p').removeClass('tfu_resolutions_highlight');
                        $('.tfu_product_ids').prop('checked', false);
                        $('#upload_image').show();
                        $('.tfu_front_tray').hide();
						 $('#product_name').val('');
                        formData.delete('tray_image');
                    });

                }
            });

            // Logo image
            var logoDropzone = new Dropzone("#logo_image_area", {
                paramName: "artist_logo",
                url: "#", // Not used since we are sending files manually
                thumbnailWidth: null,
                thumbnailHeight: null,
                previewsContainer: '.dropzone-previews-logo',
                addRemoveLinks: true,
                autoProcessQueue: false,
                parallelUploads: 1,
                uploadMultiple: false,
                acceptedFiles: "image/*",
                maxFiles: 1,
                maxFilesize: 1,
                dictFileTooBig: "File is too big ({{filesize}} MB). Max filesize: {{maxFilesize}} MB.",
                dictRemoveFile: "Delete",
                params: {
                    _token: token
                },
                init: function() {
                    var myDropzone = this;
                    var is_customer_logo = false;
                    // Show already uploaded logo
                    <?php if( !empty($is_customer->customer_logo) && \Storage::disk('uploads')->exists('/users/' .$is_customer->customer_logo)): ?>
                        $('#upload_logo').hide();
                        var is_customer_logo = true;
                        var existingFile = "<?php echo e(url('uploads/users/'.$is_customer->customer_logo)); ?>"; // Replace with actual path to the uploaded logo file
                        if (existingFile) {

                            var img = new Image();
                            img.src = existingFile;

                            img.onload = function () {
                                var width = img.width;
                                var height = img.height;
                                $('.tfu_tray_logo').show();
                                $('.tfu_tray_logo span').text(width + 'x' + height);
                            };

                            var mockFile = {
                                name: existingFile.split('/').pop(),
                                url: existingFile // The URL for the existing logo
                            };

                            // Manually add the existing file to the Dropzone
                            myDropzone.emit("addedfile", mockFile);
                            myDropzone.emit("thumbnail", mockFile, existingFile); // Use the URL for the thumbnail
                            myDropzone.emit("complete", mockFile);
                            myDropzone.files.push(mockFile); // Add to the Dropzone file array
                        }
                    <?php endif; ?>


                    this.on("addedfile", function(file) {

                        if (this.files.length > 1) {
                            this.removeAllFiles();
                            this.addFile(file);
                            $('#upload_logo img').attr('new_logo',1);
                        } else {
                            $('#upload_logo').hide();
                            formData.append('artist_logo', file); // Append file to formData
                        }

                    });

                    this.on("thumbnail", function(file) {

                        var previewURL = URL.createObjectURL(file);
                        var dzPreview = $(file.previewElement).find('img');
                        dzPreview.attr("src", previewURL);


                        // Use FileReader to read the file data URL
                        var reader = new FileReader();
                        reader.onload = function(file) {
                            var image = new Image();
                            image.src = file.target.result;
                            image.onload = function(file) {
                                var width = this.width;
                                var height = this.height;
                                //$('.tfu-back-logo').remove();
                                //var span = $('<span class="tfu-back-logo">').text(width + 'px x ' + height + 'px');
                                //$('.artist_logo_img  .dz-remove').before(span);
                                $('.tfu_tray_logo').show();
                                $('.tfu_tray_logo span').text(width + 'x ' + height);

                                highlightMatchingResolutions('tfu-logo-resolutions',width, height);
                            };
                            image.onerror = function() {
                                console.error("Error loading image");
                            };
                        };
                        reader.onerror = function() {
                            console.error("Error reading file");
                        };
                        reader.readAsDataURL(file);
                    });

                    this.on("error", function(file, message) {
                        console.error("Error:", message);
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: message
                        });
                    });

                    this.on("removedfile", function (file) {
                        $('.back-logo-p').removeClass('tfu_resolutions_highlight');
                        $('#upload_logo').show();
                        $('#upload_logo img').attr('data-logo',0);
                        $('.tfu_tray_logo').hide();
                        formData.delete('artist_logo');
                        if(is_customer_logo) {
                            $('#upload_logo img').attr("src","<?php echo e(asset('/assets/images/T4Us_Blank_Back_4.png')); ?>");
                        }
                        this.options.maxFiles = 2;
                    });
                }
            });

            // Handle the Enter key press
            $("#add_artist_work").on("keypress", function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $("#artist_upload_save_btn").click();
                }
            });

            // Handle form submission
            $("#artist_upload_save_btn").click(function (e) {
                e.preventDefault();
                $('#tfu_loading').show();
                $('.tfu-cancel-loading').show();
                $(".print-error-msg").css('display','none');
                $(".alert-success-div").hide();
                formData.append("_token", token);
                // Add other form data to formData
                formData.append('product_name', $('#product_name').val());

                var data_logo = $('#upload_logo img').attr('data-logo');

                formData.append('new_logo', data_logo);

                var product_types = [];
                $('input.tfu_product_ids:checkbox:checked').each(function () {
                    product_types.push($(this).val());
                });

                formData.append('product_types', product_types);

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: (1000*60)*2, // Adjust the timer as needed
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                Toast.fire({
                    icon: 'warning',
                    html: 'This process may take up to 1 minute'
                });

                $.ajax({
                    url: "<?php echo e(route('save-artist-work')); ?>",
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        if(response.status == 1) {
                            window.location.href = response.redirect;
                        } else {
                            Swal.close();
                            $('#tfu_loading').hide();
                            $(".print-error-msg").find("ul").html('');
                            $(".print-error-msg").css('display','block');
                            $.each( response.error, function( key, value ) {
                                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                            });
                            $("html, body").animate({ scrollTop: $('.print-error-msg').offset().top - 100 }, 500);
                        }
                    },
                    error: function(response) {
                        //console.error('Error:', response);
                        // Handle the error response here
                    }
                });
            });

            // Highlight the area with matching resolutions
            function highlightMatchingResolutions(div_class, width, height) {
                $('.' + div_class).parent().removeClass('highlight');
                $('.' + div_class+' '+'.tfu_product_ids').prop('checked', false);
                console.log(width + '---' + height);
                // Highlight the matching resolutions
                $('.' + div_class).each(function() {
                    var spanWidth = parseInt($(this).data('width'));
                    var spanHeight = parseInt($(this).data('height'));
                    console.log("Width : " + width + " spanWidth : " + spanWidth);
                    console.log("height : " + height + " spanHeight : " + spanHeight);
                    if (width >= spanWidth && height >= spanHeight) {
                        $(this).parent().addClass('tfu_resolutions_highlight');
                        $(this).closest('.chexbox-artist').find('input[type="checkbox"]').prop('checked', true);
                    }
                });
            }

        });
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/frontend/artist/upload-aritst-work.blade.php ENDPATH**/ ?>