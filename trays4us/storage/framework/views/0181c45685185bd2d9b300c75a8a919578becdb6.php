<?php $__env->startSection('content'); ?>

    <div class="row">

        <div class="col-md-12">

            <div class="page-header">

                <div class="row">

                    <div class="col">

                        <h3 class="page-title">Slider etting</h3>

                    </div>

                </div>

            </div>


            <div class="row">

                <div class="col-xl-12 col-lg-12 col-md-12 mt-3">

                    <div class="card">

                        <div class="card-body p-0">

                            <form action="<?php echo e(route('slider-setting-submitted')); ?>" method="post" enctype="multipart/form-data" class="site_setting">

                                <?php echo e(csrf_field()); ?>


                                <div class="tab-content pt-0">

                                    <div id="general" class="tab-pane active">

                                        <div class="card mb-0">





                                            <div class="card-body">

                                                <div class="row">



                                                <div class="col-md-12">

                                                    <div class="form-group">

                                                        <div class="form-check">

                                                            <label class="form-check-label" for="send_email">Auto-sliding homepage header slider ?</label>

                                                            <input class="form-check-input" type="checkbox" name="slider_auto" value="1" id="send_email" <?php echo e($site_managements->slider_auto == 1 ? 'checked': ''); ?>>

                                                        </div>

                                                    </div>

                                                </div>



                                                <div class="col-md-6">

                                                    <div class="form-group">

                                                        <label>Delay of the homepage header slider in milliseconds.</label>

                                                        <input type="text" class="form-control" name="slider_delay" value="<?php echo e($site_managements->slider_delay); ?>">

                                                    </div>

                                                </div>



                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="card-body pt-0">

                                        <button type="submit" class="btn btn-primary">Save Changes</button>

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>



        </div>

    </div>

<?php $__env->stopSection(); ?>



<?php $__env->startPush('scripts'); ?>

    <script>

        $(document).ready(function () {

        });

    </script>

<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/admin/homepage_slider/slider-setting.blade.php ENDPATH**/ ?>