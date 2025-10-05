<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Trays4Us | Signin</title>
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/admin2.css">
</head>
<body>
<div class="main-wrapper">
    <div class="login-page">
        <div class="login-body container">
            <div class="loginbox">
                <div class="login-right-wrap">
                    <div class="account-header">
                        <div class="account-logo text-center mb-4">
                            <a href="<?php echo route('tfubacksecurelogin'); ?>">
                                <img src="assets/images/logo.svg" alt class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="login-header">
                        <h3><span style="text-align: center;display: block;">Login</span></h3>
                    </div>

                    <form action="{{ route('admin_verify2fa_post') }}" method="POST">
                        @include('partials.flash-message')
                        @csrf
                        <div class="form-group">
                            <label class="control-label">Enter the 2FA code sent to your email:</label>
                            <input type="text" class="form-control" id="2fa_code" name="2fa_code" required autofocus>
                        </div>

                        @if ($errors->has('2fa_code'))
                            <span class="text-danger">{{ $errors->first('2fa_code') }}</span>
                        @endif

                        <div class="text-center">
                            <button class="btn btn-primary btn-block account-btn" type="submit">Verify Code</button>
                        </div>
                    </form>
                    <?php /*
                     <div class="text-center forgotpass mt-4"><a href="forgot-password.html">Forgot Password?</a></div>

                     <div class="login-or">
                        <span class="or-line"></span>
                        <span class="span-or">or</span>
                     </div>
                     <div class="social-login">
                        <span>Login with</span>
                        <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a><a href="#" class="google"><i class="fab fa-google"></i></a>
                     </div>
                     <div class="text-center dont-have">Don’t have an account? <a href="register.html">Register</a></div> */ ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('/assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/js/admin.js') }}"></script>


</body>
</html>
