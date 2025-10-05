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
            <h1>SIGN IN</h1>
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
        <div class="tfu-social-icons" >
         <a href="<?php echo e(route('auth.google')); ?>" class="tfu-google" > <img src="<?php echo e(asset('/assets/frontend-assets/svg/google_web_neutral.svg')); ?>"  /></a>
         <a href="<?php echo e(route('auth.facebook')); ?>" class="tfu-facebook"  ><img src="<?php echo e(asset('/assets/frontend-assets/svg/facebook_web_neutral.svg')); ?>"  /></a>
      
        </div>
        <img  class="tfu-or-line" src="<?php echo e(asset('/assets/frontend-assets/svg/or-signin.svg')); ?>" />
         <div class="ftu-signin-form-control tfu_form_outer" >
             <?php echo $__env->make('partials.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
             <form action="<?php echo e(route('signin_submitted')); ?>" method="post" enctype="multipart/form-data" class="" >
                 <?php echo e(csrf_field()); ?>

                <div class="ftu-mb-input text-center">
                    <label for="ftuInputEmail" class="form-label ftu-mb-label">E-Mail</label>
                    <input type="email" class="tfu-email-handle form-control" name="email" id="tfu_email" value="<?php echo e(old('email')); ?>">
                </div>
                <div class="ftu-mb-input  text-center">
                    <label for="ftuInputPassword" class="form-label ftu-mb-label">Password</label>
                    <input type="password" class="tfu-password-handle form-control" name="password" id="tfu_password" value="<?php echo e(old('password')); ?>">
                </div>
                <button type="submit" class="ftu-signin-submit">Submit</button>
            </form>


         </div>
      </div>
    </div>

    <div class="row" >
      <div class="col-xl-12" >
         <div class="tfu-signin-useraccount">
             <p>New User - <span><a href="<?php echo e(route('sign-up')); ?>" >Apply for a wholesale account</a></span></p>
             <p> <span><a class="help" href="javascript:void(0)"  rel="nofollow" id="forgot_password">Forgot Password</a></span></p>
             <p> <span><a class="help" href="mailto:info@trays4.us?subject=Need Help">Contact Support</a></span></p>
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
<script>
    $(document).ready(function () {
        $("#forgot_password").click(function (event) {
            Swal.fire({
                title: '<?php echo e(__("Enter your email")); ?>',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: '<?php echo e(__("Submit")); ?>',
                showLoaderOnConfirm: true,
                inputValidator: (value) => {
                    if (value === '' || !isEmail(value)) {
                        return '<?php echo e(__("Email is invalid")); ?>'
                    }
                }, preConfirm: (login) => {
                    $.ajax({
                        method: "GET",
                        url: "<?php echo e(route('forgot_password_customer')); ?>",
                        data: {email: login}
                    }).done(function (data) {
                        if (data === '1') {
                            Swal.fire(
                                '<?php echo e(__("Sent")); ?>',
                                '<?php echo e(__("The password reset link is sent to your registered e-mail!")); ?>',
                                'success'
                            )
                        } else {
                            Swal.update({
                                title: '<?php echo e(__("Error")); ?>',
                                text: '<?php echo e(__("Email not found. Please try again.")); ?>',
                                icon: 'error',
                                showConfirmButton: true // Show the confirm button after displaying the error
                            });
                        }
                    });
                    return false;
                }
            })
        });

    });

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
</script>
</body>
</html>
<?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/frontend/customers/signin.blade.php ENDPATH**/ ?>