<?php
    $redirect_url = route('frontend.products');
    $is_customer = Session::get("is_customer");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $__env->make('partials.frontend.headers-style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body>
<?php echo $__env->make('partials.frontend.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<section class="tfu-sign-in-wrapper" >


    <div class="row" >
        <div class="col-xl-12" >
            <div class="ftu-signin-form-control tfu_form_outer" >
                <?php echo $__env->make('partials.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <h4>TWO FACTOR AUTHENTICATION</h4>

                <form class="form-horizontal" id="login-form" onsubmit="return false;">
                    <?php echo $__env->make('partials.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo e(csrf_field()); ?>

                    <p>A one-time-password has been sent to your email.</p>
                    <div class="form-group mb-3">
                        <label for="">Enter One Time Password:</label>
                        <input class="form-control" name="otp" id="otp" type="text">
                    </div>


                    <div id="verify_error_section" style="display: none" class="alert alert-danger">
                        <small id="verify_error_message"></small>
                    </div>
                    <div id="otp-alert" class="alert alert-success" style="display: none">
                        <strong style="float: left;display: block;width: 100%;">OTP resend successfully</strong>
                    </div>

                    <div class="row mt-3">
                        <div class="col-6">
                            <button id="verify_otp_btn" class="add_field_button btn octf-btn ftu-btn-block" type="button"> Verify
                            </button>
                        </div>

                        <div class="col-6">
                            <button id="resend-otp-btn" class="add_field_button btn octf-btn ftu-btn-block" type="button"> Resend OTP </button>
                        </div>
                    </div>

                    <input type="hidden" id="otp_user_id" value="<?php echo e($is_customer->id ?? ''); ?>">
                </form>

            </div>
        </div>
    </div>


</section>

<?php echo $__env->make('partials.frontend.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('partials.frontend.footer-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('partials.frontend.common-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script type="text/javascript">
    $(document).ready(function () {

        /* Send Ajax Request on Verify Button Otp */
        jQuery('#verify_otp_btn').click(function (e) {

            var txt = $('#otp');
            if (txt.val() != null && txt.val() != '') {

                jQuery.ajax({
                    url: "<?php echo e(route('verify.otp')); ?>",
                    method: 'post',
                    data: {
                        '_token': '<?php echo e(csrf_token()); ?>',
                        customer_id: $('#otp_user_id').val(),
                        otp: $('#otp').val()
                    },
                    beforeSend: function () {
                        // disable both buttons
                        $('#resend-otp-btn').attr('disabled', true);
                        $('#verify_otp_btn').attr('disabled', true);

                        $('#verify_error_section').fadeOut();
                    },
                    success: function (result) {
                        if (result.status == 200) {
                            /* Hide Verify Error Message */
                            $('#verify_error_section').fadeOut();
                            $('#verify_error_message').text('');

                            // enable buttons.
                            $('#resend-otp-btn').attr('disabled', false);
                            $('#verify_otp_btn').attr('disabled', false);

                            // redirect
                            window.location.href = '<?php echo e($redirect_url); ?>';
                        }
                        if (result.status == 403) {
                            // enable buttons.
                            $('#resend-otp-btn').attr('disabled', false);
                            $('#verify_otp_btn').attr('disabled', false);

                            /* Show Verify Error Message */
                            $('#otp').val('');
                            $('#otp').focus();

                            $('#verify_error_section').fadeIn();
                            $('#verify_error_message').text(result.response);
                        }
                    }
                });
            } else {
                $('#verify_error_section').css('display', 'block');
                $('#verify_error_message').text('Please Enter Password');
            }
        });


        /* RESEND OTP BUTTON */
        jQuery('#resend-otp-btn').click(function (e) {

            // hide error messages.
            $('#verify_error_section').css('display', 'none');

            // resend otp request.
            jQuery.ajax({
                url: "<?php echo e(route('resend.otp')); ?>",
                method: 'post',
                data: {
                    '_token': '<?php echo e(csrf_token()); ?>',
                    customer_id: $('#otp_user_id').val()
                },
                beforeSend: function () {
                    // disable both buttons
                    $('#resend-otp-btn').attr('disabled', true);
                    $('#verify_otp_btn').attr('disabled', true);
                },
                success: function (result) {
                    if (result.status == 200) {

                        // enable both buttons.
                        $('#resend-otp-btn').attr('disabled', false);
                        $('#verify_otp_btn').attr('disabled', false);

                        /* Hide Verify Error Message */
                        $("#otp-alert").fadeIn();

                        // hide otp alert.
                        setTimeout(function () {
                            $("#otp-alert").fadeOut();
                        }, 2000);

                    }
                    if (result.status == 403) {
                        /* Show Verify Error Message */
                        $('#resend-otp-btn').attr('disabled', false);
                        $('#verify_otp_btn').attr('disabled', false);
                    }
                }
            });
        });
    });
</script>
</body>
</html>
<?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/frontend/customers/verify-2fa.blade.php ENDPATH**/ ?>