<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/evol-colorpicker.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/jquery-ui.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/dropzone.css')); ?>">
    <style>
        .evo-cp-wrap{width: 488.656px;display: flex;gap: 10px;}
        .evo-colorind, .evo-colorind-ie, .evo-colorind-ff {border: solid 1px #c3c3c3;width: 25px;height: 25px;float: right;}
        .ui-widget.ui-widget-content {top: 75px;}
        .evo-cp-wrap {width: 488.656px;display: flex;gap: 10px;  align-items: center;}
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Add slider</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data" class="ftu-form-user-uploaded dropzone" id="homepage_slider_save">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">

                            <?php /*
                       <div class="col-md-6">
                           <div class="form-group">
                               <label>Slider Image (1916 x 550)</label>
                               <input class="form-control" type="file" name="slider_image">
                           </div>

                           @if( !empty($homepage_slider->slider_image) && \Storage::disk('uploads')->exists('/sliders/' . $homepage_slider->slider_image))
                               <div class="form-group">
                                   <div class="avatar">
                                       <img class="avatar-img rounded" alt src="{{ url('uploads/sliders/'.$homepage_slider->slider_image) }}">
                                   </div>
                               </div>
                           @endif
                       </div> */ ?>


                            <div class="col-xl-12">
                                <div id="dropzoneDragArea" class="dz-default dz-message dropzoneDragArea">
                                    <span class="dz-default dz-message">Slider Image (1916 x 550)</span>
                                    <div class="col-xl-12">
                                        <div class="dropzone-previews"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <p class="mt-3 mb-3"><b>Slide Text, Button and Links</b></p>
                                    <p>Alignment to the web page sides</p>
                                    <div class="col-auto">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="slider_direction" id="left" value="start" >
                                            <label class="form-check-label" for="left">Left</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="slider_direction" id="centered" value="center" checked>
                                            <label class="form-check-label" for="centered">Centered</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="slider_direction" id="right" value="end" >
                                            <label class="form-check-label" for="right">Right</label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <p class="mt-3 mb-3"><b>Title</b></p>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                            <label>Text Size</label>
                                            <input class="form-control" type="text" name="title_size" id="title_size" value="32">
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2">
                                        <div class="form-group" style="position:relative;">
                                            <label>Text Color #</label>
                                            <input class="form-control" type="text" name="title_color" id="title_color" value="#000000">
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2">
                                        <div class="form-group" style="position:relative;">
                                            <label>Text Box and its #</label>
                                            <input class="form-control" type="text" name="title_box_color" id="title_box_color" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Title Text</label>
                                    <input class="form-control" type="text" name="slider_title" id="slider_title" value="">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Link</label>
                                    <input class="form-control" type="text" name="slider_title_link" id="slider_title_link" value="">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Hide Title When Checked?</label>
                                    <input class="form-control" type="checkbox" name="slider_title_visibility" id="slider_title_visibility" value="0">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <p class="mt-3 mb-3"><b>Button</b></p>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Button Text</label>
                                    <input class="form-control" type="text" name="shop_btn_text" id="shop_btn_text" value="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Link</label>
                                    <input class="form-control" type="text" name="shop_now_link" id="shop_now_link" value="">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <p class="mt-3 mb-3"><b>Labels</b></p>
                            </div>

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Text Size</label>
                                            <input class="form-control" type="text" name="label_text_size" id="label_text_size" value="14">
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2">
                                        <div class="form-group" style="position:relative;">
                                            <label>Text Color #</label>
                                            <input class="form-control" type="text" name="label_color" id="label_color" value="#000000">
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2">
                                        <div class="form-group" style="position:relative;">
                                            <label>Text Box and its #</label>
                                            <input class="form-control" type="text" name="label_box_color" id="label_box_color">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Label</label>
                                    <input class="form-control" type="text" name="first_label" id="first_label">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Link</label>
                                    <input class="form-control" type="url" name="first_link" id="first_link">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Second Label</label>
                                    <input class="form-control" type="text" name="second_label" id="second_label">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Second Link</label>
                                    <input class="form-control" type="url" name="second_link" id="second_link">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Third Label</label>
                                    <input class="form-control" type="text" name="third_label" id="third_label">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Third Link</label>
                                    <input class="form-control" type="url" name="third_link" id="third_link">
                                </div>
                            </div>


                            <div class="col-md-12">
                                <p class="mt-3 mb-3"><b>Entire Banner</b></p>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Entire Banner Link</label>
                                    <input class="form-control" type="url" name="entire_banner_link" id="entire_banner_link">
                                </div>
                            </div>

                        </div>
                        <div class="mt-4">
                            <button class="btn btn-primary" type="submit" id="homepageslider_btn">Add</button>
                            <a href="<?php echo e(route('homepage-slider')); ?>" class="btn btn-link">Cancel</a>
                        </div>
                    </form>

                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <div class="alert alert-success alert-block alert-success-div mb-0" style="display: none !important">
                        <button type="button" class="close" data-bs-dismiss="alert">×</button>
                        <strong></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/evol-colorpicker.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/dropzone.js')); ?>"></script>

    <script>
        $(document).ready(function () {

            $("#title_color").colorpicker({
            });

            $("#title_box_color").colorpicker({

            });

            $("#label_color").colorpicker({

            });

            $("#label_box_color").colorpicker({

            });

        });
    </script>


    <script>
        Dropzone.autoDiscover = false;
        // Dropzone.options.demoform = false;
        var _add_file = _remove_file = 0;
        let token = $('[name="_token"]').val();
        $(function() {

            var myDropzone = new Dropzone("#dropzoneDragArea", {
                paramName: "slider_image",
                url: "<?php echo e(route('add-homepage-slider-submitted')); ?>",
                previewsContainer: '.dropzone-previews',
                // previewTemplate : $('.preview').html(),
                dictDefaultMessage: "Drop files here or click to upload (600x600)",
                addRemoveLinks: true,
                autoProcessQueue: false,
                // maxFilesize: 2,
                parallelUploads: 1,
                uploadMultiple: false,
                acceptedFiles: "image/*",
                maxFiles: 1,
                params: {
                    _token: token
                },
                init: function() {

                    var myDropzone = this;

                    $("#homepageslider_btn").click(function (e) {
                        e.preventDefault();
                        $('#loading').show();
                        $(".print-error-msg").find("ul").html('');
                        $(".print-error-msg").css('display','none');

                        // Check if there are files in the queue

                        if (myDropzone.getQueuedFiles().length > 0) {
                            myDropzone.processQueue();
                        } else {
                            sendDataWithoutImageChange();
                        }
                    });

                    this.on('addedfile', function(file) {
                        if (this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }
                    });

                    this.on('sending', function(file, xhr, formData){
                        formData.append('id', jQuery("#slider_id").val());
                        formData.append("_token", '<?php echo e(csrf_token()); ?>');
                        formData.append("slider_direction", jQuery('input[name="slider_direction"]:checked').val());
                        formData.append("title_size", jQuery("#title_size").val());
                        formData.append("title_color", jQuery("#title_color").val());
                        formData.append("title_box_color", jQuery("#title_box_color").val());
                        formData.append("slider_title", jQuery("#slider_title").val());
                        formData.append("slider_title_link", jQuery("#slider_title_link").val());
                        formData.append("shop_btn_text", jQuery("#shop_btn_text").val());
                        formData.append("shop_now_link", jQuery("#shop_now_link").val());
                        formData.append("label_text_size", jQuery("#label_text_size").val());
                        formData.append("label_color", jQuery("#label_color").val());
                        formData.append("label_box_color", jQuery("#label_box_color").val());
                        formData.append("first_label", jQuery("#first_label").val());
                        formData.append("first_link", jQuery("#first_link").val());
                        formData.append("second_label", jQuery("#second_label").val());
                        formData.append("second_link", jQuery("#second_link").val());
                        formData.append("third_label", jQuery("#third_label").val());
                        formData.append("third_link", jQuery("#third_link").val());
                        formData.append("entire_banner_link", jQuery("#entire_banner_link").val());
                    });


                    this.on("success", function (file, result) {
                        // alert('success');
                        //window.location.href = result.redirect_url;

                        $(".print-error-msg").css('display','none');
                        $(".alert-success-div").hide();
                        if($.isEmptyObject(result.error)){
                            window.location.href = result.redirect_url;
                        } else {

                            $(".print-error-msg").find("ul").html('');
                            $(".print-error-msg").css('display','block');
                            $.each( result.error, function( key, value ) {
                                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                            });
                            $("html, body").animate({ scrollTop: $('.print-error-msg').offset().top - 100 }, 500);
                        }
                        $('#loading').hide();

                    });

                    this.on('completemultiple', function(file, json) {
                        // alert('completemultiple');
                    });

                    this.on("removedfile", function (file) {
                        //alert('removedfile');

                    });


                }
            });

            function sendDataWithoutImageChange() {
                var formData = new FormData(document.getElementById('homepage_slider_save'));

                homepage_slider_data(formData);

                $.ajax({
                    url: "<?php echo e(route('add-homepage-slider-submitted')); ?>",
                    method:"POST",
                    data: formData,
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(result)
                    {
                        $(".print-error-msg").css('display','none');
                        $(".alert-success-div").hide();
                        if($.isEmptyObject(result.error)){
                            window.location.href = result.redirect_url;
                        } else {

                            $(".print-error-msg").find("ul").html('');
                            $(".print-error-msg").css('display','block');
                            $.each( result.error, function( key, value ) {
                                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                            });
                            $("html, body").animate({ scrollTop: $('.print-error-msg').offset().top - 100 }, 500);
                        }
                        $('#loading').hide();
                    }
                })
            }

            function homepage_slider_data(formData) {

            }


        });
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/admin/homepage_slider/add.blade.php ENDPATH**/ ?>