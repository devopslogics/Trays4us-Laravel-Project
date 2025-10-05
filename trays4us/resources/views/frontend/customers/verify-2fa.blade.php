@php
    $redirect_url = route('frontend.products');
    $is_customer = Session::get("is_customer");
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.frontend.headers-style')
</head>

<body>
@include('partials.frontend.header')

<section class="tfu-sign-in-wrapper" >


    <div class="row" >
        <div class="col-xl-12" >
            <div class="ftu-signin-form-control tfu_form_outer" >
                @include('partials.flash-message')
                <h4>TWO FACTOR AUTHENTICATION</h4>

                <form class="form-horizontal" id="login-form" onsubmit="return false;">
                    @include('partials.flash-message')
                    {{ csrf_field() }}
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

                    <input type="hidden" id="otp_user_id" value="{{ $is_customer->id ?? '' }}">
                </form>

            </div>
        </div>
    </div>


</section>

@include('partials.frontend.footer')
@include('partials.frontend.footer-js')
@include('partials.frontend.common-js')

<script type="text/javascript">
    $(document).ready(function () {

        /* Send Ajax Request on Verify Button Otp */
        jQuery('#verify_otp_btn').click(function (e) {

            var txt = $('#otp');
            if (txt.val() != null && txt.val() != '') {

                jQuery.ajax({
                    url: "{{ route('verify.otp') }}",
                    method: 'post',
                    data: {
                        '_token': '{{ csrf_token() }}',
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
                            window.location.href = '{{ $redirect_url }}';
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
                url: "{{ route('resend.otp') }}",
                method: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
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
