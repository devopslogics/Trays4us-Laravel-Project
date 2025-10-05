<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $__env->make('partials.frontend.headers-style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body>
<?php echo $__env->make('partials.frontend.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<section class="tfu-sign-in-wrapper" >

    <div class=" tfu-general-breadcumb-wrapper" >
        
        <div class="tfu-general-heading" >
            <h1>Reset Password</h1>
        </div>
        <?php /*
      <ul class="shop-breadcrumb">
          <li><a href="{{ route('home') }}" > Home </a></li>
          <li>Sign in</li>
      </ul> */ ?>

    </div>
    <div class="container-fluid">
        <div class="row" >
            <div class="col-xl-12" >
                <div class="ftu-signin-form-control tfu_form_outer" >
                    <?php /* <h3 class="client">Reset your account password</h3> */ ?>

                    <?php echo $__env->make('partials.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <form action="<?php echo e(route('reset_update_password')); ?>" method="post" enctype="multipart/form-data" class="" >
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" class="form-control" name="token" value="<?php echo e($token); ?>">
                        <div class="ftu-mb-input text-center">
                            <label for="password" class="form-label ftu-mb-label">Password</label>
                            <input type="password" class="tfu-email-handle form-control" name="password" id="password" value="<?php echo e(old('email')); ?>">
                        </div>
                        <div class="ftu-mb-input  text-center">
                            <label for="password_confirmation" class="form-label ftu-mb-label">Confirm Password</label>
                            <input type="password" class="tfu-password-handle form-control" name="password_confirmation" id="password_confirmation" value="<?php echo e(old('password')); ?>">
                        </div>
                        <button type="submit" class="ftu-signin-submit">Submit</button>
                    </form>


                </div>
            </div>
        </div>
    </div>

</section>

<?php echo $__env->make('partials.frontend.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script src="<?php echo e(asset('/assets/js/jquery-3.6.0.min.js')); ?>"></script>
<script src="<?php echo e(asset('/assets/js/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('/assets/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('/assets/js/sweetalert2.min.js')); ?>"></script>
<?php echo $__env->make('partials.frontend.common-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/frontend/customers/reset_password.blade.php ENDPATH**/ ?>