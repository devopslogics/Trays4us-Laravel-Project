<?php $__env->startSection('content'); ?>


    <section class="tfu-create-account-wrapper" >

        <div class=" tfu-general-breadcumb-wrapper" >
            
            <div class="tfu-general-heading" >
                <h1>Change password</h1>
            </div>
       </div>


        <div class="" >
            <div class="col-xl-12" >
                <div class="ftu-account-form-control tfu_form_outer" >

                    <?php echo $__env->make('partials.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <form action="<?php echo e(route('change-password-save')); ?>"  method="post" enctype="multipart/form-data" class="">
                        <?php echo e(csrf_field()); ?>


                        <div class="mb-5 text-center">
                            <label for="customer_phone" class="form-label mb-3">Current Password</label>
                            <input type="password" name="current_password"   class="tfu-phone-handle form-control" id="current_password" value="<?php echo e(old('current_password')); ?>">
                        </div>

                        <div class="mb-5 text-center">
                            <label for="new_password" class="form-label mb-3">New Password</label>
                            <input type="password" name="password" class="tfu-email-handle form-control" id="password"  value="<?php echo e(old('password')); ?>">
                        </div>

                        <div class="mb-5 text-center">
                            <label for="new_confirm_password" class="form-label mb-3">New Confirm Password</label>
                            <input type="password" name="password_confirmation" class="tfu-email-handle form-control" id="new_confirm_password"  value="<?php echo e(old('password_confirmation')); ?>">
                        </div>

                        <button type="submit" class="ftu-account-submit" id="">Update Password</button>
                    </form>

                </div>
            </div>
        </div>


    </section>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/frontend/customers/change-password.blade.php ENDPATH**/ ?>