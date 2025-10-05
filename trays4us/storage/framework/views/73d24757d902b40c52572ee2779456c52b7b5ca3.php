<?php $__env->startPush('styles'); ?>
    <style>
        .tfu-current-preview-your-work .tray-type-110533:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            transform: scale(1.07);
            z-index: 99;
            bottom: 0;
            width: 100%;
            background-size: cover;
            background-image: url(<?php echo e(asset('/assets/frontend-assets/images/1105.png')); ?>);
        }
        .chexbox-artist b {
            display: flex;
    color: #FF6600;
}
.chexbox-artist {
    display: flex;
    border: 1px solid #858585;
    height: 36px;
    width: 115px;
    justify-content: start;
    align-items: center;
    border-radius: 6px;
    padding: 8px 17px;
}
.btn-second_section .btn-primary {
    white-space: nowrap;
}

@media (max-width: 1200px) {
    .chexbox-check {
    padding: 0 6px;
}
input.tfu_product_ids +label {
    width: 42px;
}
ul.preview_uploades_img_section {
    min-height: 220px;
}

}

        @media (max-width: 767px) {
            ul.preview_uploades_img_section {
        min-height: 160px !important;
    }
    .btn-second_section {
        flex-wrap: wrap;
    }
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

    <section class="tfu-license-artwork-wrapper">
        <div class="container-fluid p-0">
            <div class="tfu-general-breadcumb-wrapper">

                <div class="tfu-general-heading">
                    <h1>Preview</h1>
                </div>

                <ul class="shop-breadcrumb">
                    <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
                    <li>Preview Your Artwork</li>
                </ul>

            </div>


            <form action="<?php echo e(route('save-preview-your-work')); ?>" method="post" enctype="multipart/form-data" name="preview_work_form" id="preview_work_form">
                <?php echo csrf_field(); ?>

                <div class="row artist_images_row preview_artist">
                <div class="preview_title p-0">
                    <h3 class="p-0">Artwork Name</h3>
                    <h2 class="p-0"><?php echo e($temp_products[0]->product_name ?? ''); ?></h2>
                    <?php if(Session::has('message')): ?>
                        <p class="alert alert-info"><?php echo e(Session::get('message')); ?></p>
                    <?php endif; ?>
                </div>

                <?php if($temp_products->isNotEmpty()): ?>
                    <?php $__currentLoopData = $temp_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $temp_product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php
                            $getProductTypeDetail = array();
                            if(isset($temp_product->pt_sub_id) AND $temp_product->pt_sub_id > 0)
                              $getProductTypeDetail  = \App\Traits\Definations::getProductTypeDetail($temp_product->pt_sub_id);

                              $tray_type_html_class = 'tray-type-'.$getProductTypeDetail->child->sku;

                             $html_class  = 'rectangle_image';
                            if(isset($temp_product->product_sku) AND !empty($temp_product->product_sku))
                              $html_class  = \App\Traits\Definations::getCustomProductHtmlClass($temp_product->product_sku);

                            $width = '60';
                            if($getProductTypeDetail->child->logo_width > 0) {
                              $width = ($getProductTypeDetail->child->logo_width/1500) * $getProductTypeDetail->child->logo_width;
                            }

                            $checkbox_checked = "";
                            if($temp_product->is_create)
                                $checkbox_checked = "checked";
                        ?>

                        <div class="d-flex preview_checkbox_section">
                            <div class="col-12 col-lg-12">
                                <div class="row justify-content-end">
                                    <div class="col-10  col-md-10 col-lg-10 d-flex flex-wrap justify-content-end chexbox-check">

                                        <div class="chexbox-artist  text-end position-relative">
                                            <b style="display: flex;margin: 0px 0px 0px 0px;color: #FF6600;">Save</b>
                                            <input type="checkbox" id="product_id" name="product_id[]" value="<?php echo e($temp_product->id); ?>" class="tfu_product_ids" <?php echo e($checkbox_checked); ?>>
                                            <label for="checkbox" class="position-absolute"></label>
                                        </div>

                                      <?php /* <a href="{{ route('customer.download-product',['id' => $temp_product->id]) }}"  class="btn-edit align-self-end" id="artist-preview-edit" >Download test</a> */ ?>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-10 col-sm-10 col-md-11 col-lg-10">
                                        <ul class="d-flex gap-3 list-unstyled align-items-center preview_uploades_img_section">

                                                <li class=""><img src="<?php echo e(url('uploads/customizer-products/customer-'.$temp_product->crop_image.'?id='.time())); ?>" class="<?php echo e($html_class); ?> <?php echo e($tray_type_html_class); ?>" alt=""></li>
                                                <?php if($getProductTypeDetail->child->fx == 1): ?>
                                                    <li class="tfu_custom_artist_logo">
                                                        <img src="<?php echo e(asset('/assets/images/'.$getProductTypeDetail->child->tray_blank_image)); ?>" alt="aaaaa">
                                                            <div class="logo-preview">
                                                                <img src="<?php echo e(url('uploads/users/'.$customer->customer_logo)); ?>" class="tfu_artist_logo_on_tray" alt="" style="max-width: <?php echo e($width); ?>px">
                                                            </div>
                                                    </li>
                                                <?php endif; ?>
                                        </ul>


                                        <?php /*<div class="note_image"><p><b>Note: The uploaded image could have a higher resolution for the best print quality.</b></p></div> */ ?>

                                      </div>

                                    <div class="col-9 col-lg-6 ">
                                        <p class="images_label"><?php echo e($getProductTypeDetail->child->type_name ?? ''); ?> <?php echo e($getProductTypeDetail->type_name ?? ''); ?></p>
                                    </div>


                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-10 col-lg-10 d-flex pt-2 justify-content-end ">
                                        <a href="<?php echo e(url('uploads/customizer-products/customer-'.pathinfo($temp_product->crop_image, PATHINFO_FILENAME).'.png'.'?id='.time())); ?>"  download class="btn-edit align-self-end" id="artist-preview-edit" >Download</a>
                                        <?php /*<a href="{{ route('customer.download-product',['id' => $temp_product->id]) }}"  class="btn-edit align-self-end" >Download</a> */ ?>
                                       <a href="<?php echo e(route('customer.edit-product',['id' => $temp_product->id])); ?>" class="btn-edit align-self-end" id="artist-preview-edit" style="margin-left: 15px;">Edit</a>
                                   </div>
                                </div>

                            </div>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>

            <div class="row artist-images-desc_row gap-4 gap-lg-0">
                <div class="w-100 border-top border-dark pt-3 pb-5 d-flex flex-wrap justify-content-between p-0 button_section gap-3 gap-lg-0">
                  <div class="col-12 col-lg-3 col-xl-5 btn-first-section">
                        <a href="mailto:info@trays4.us" class="btn btn-secondary w-100">Support</a>
                  </div>
                  <div class="btn-second_section col-12 col-lg-8 col-xl-6 d-flex justify-content-between gap-3 flex-col-wrap flex-sm-wrap flex-md-wrap flex-lg-nowrap  ">
                    <div class="cancel_accept_group d-flex gap-3 col-12 col-lg-7 align-items-center">
                          <a href="<?php echo e(route('upload-your-work')); ?>" class="btn btn-secondary w-100">Back</a>
                          <a href="<?php echo e(route('upload-your-work')); ?>" class="btn btn-secondary w-100">Cancel</a>
                    </div>
                    <button type="submit" class="btn btn-primary" id="save_to_my_account" >Save Selected To My Account</button>
                  </div>
                </div>

                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <div class="alert alert-success alert-block alert-success-div mb-0" style="display: none !important">
                    <button type="button" class="close" data-bs-dismiss="alert">×</button>
                    <strong></strong>
                </div>


                <div class="col-12 p-0 pt-3 pb-5 artwork-terms">
                    <p class="text-black">By saving you confirm that you agree to these <a href="<?php echo e(route('term-condition')); ?>" class="text-underline text-black">terms.</a></p>
                </div>
            </div>

            </form>

        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

    <script>
        $(function() {
            $("#preview_work_form").submit(function(e) {
                e.preventDefault();
                $(".print-error-msg").css('display','none');
                $(".alert-success-div").hide();
                $('#tfu_loading').show();
                $('.tfu-cancel-loading').show();
                $.ajax({
                    url: "<?php echo e(route('save-preview-your-work')); ?>",
                    method: 'POST',
                    data:new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if(response.status == 'success') {
                            window.location.href = response.redirect_url;
                        } else {
                            $('#tfu_loading').hide();
                            $(".print-error-msg").find("ul").html('');
                            $(".print-error-msg").css('display','block');
                            $(".print-error-msg").find("ul").append('<li>'+response.message+'</li>');
                            $("html, body").animate({ scrollTop: $('.print-error-msg').offset().top - 100 }, 500);
                        }

                    },
                    error: function(response) {

                    }
                });
            });


            //-------------------------------------------------------------------------------------------------------


            $('.tfu_product_ids').change(function () {
                let checkboxStatus = $(this).is(':checked') ? 1 : 0;
                let product_id = $(this).val();

                $.ajax({
                    url: "<?php echo e(route('customer.is_real_product_create')); ?>",  // Replace with your route or endpoint URL
                    type: "POST",
                    dataType: "json",
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>", // Include CSRF token for Laravel
                        status: checkboxStatus,
                        product_id: product_id
                    },
                    success: function (response) {
                        console.log("Status updated successfully:", response);
                    },
                    error: function (error) {
                        console.error("Error updating status:", error);
                    }
                });
            });

            //-------------------------------------------------------------------------------------------------

        });

    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/frontend/artist/preview-aritst-work.blade.php ENDPATH**/ ?>