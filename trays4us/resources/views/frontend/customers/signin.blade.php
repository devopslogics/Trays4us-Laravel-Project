<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.frontend.headers-style')
</head>

<body>
@include('partials.frontend.header')

<section class="tfu-sign-in-wrapper" >

  <div class=" tfu-general-breadcumb-wrapper" >
        {{-- <ul class="shop-breadcrumb">
            <li><a href="{{ route('my-account') }}">My Account</a></li>
            <li>Sign in /</li>
        </ul> --}}
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
         <a href="{{ route('auth.google') }}" class="tfu-google" > <img src="{{ asset('/assets/frontend-assets/svg/google_web_neutral.svg') }}"  /></a>
         <a href="{{ route('auth.facebook') }}" class="tfu-facebook"  ><img src="{{ asset('/assets/frontend-assets/svg/facebook_web_neutral.svg') }}"  /></a>
      
        </div>
        <img  class="tfu-or-line" src="{{ asset('/assets/frontend-assets/svg/or-signin.svg') }}" />
         <div class="ftu-signin-form-control tfu_form_outer" >
             @include('partials.flash-message')
             <form action="{{ route('signin_submitted') }}" method="post" enctype="multipart/form-data" class="" >
                 {{ csrf_field() }}
                <div class="ftu-mb-input text-center">
                    <label for="ftuInputEmail" class="form-label ftu-mb-label">E-Mail</label>
                    <input type="email" class="tfu-email-handle form-control" name="email" id="tfu_email" value="{{old('email')}}">
                </div>
                <div class="ftu-mb-input  text-center">
                    <label for="ftuInputPassword" class="form-label ftu-mb-label">Password</label>
                    <input type="password" class="tfu-password-handle form-control" name="password" id="tfu_password" value="{{old('password')}}">
                </div>
                <button type="submit" class="ftu-signin-submit">Submit</button>
            </form>


         </div>
      </div>
    </div>

    <div class="row" >
      <div class="col-xl-12" >
         <div class="tfu-signin-useraccount">
             <p>New User - <span><a href="{{ route('sign-up') }}" >Apply for a wholesale account</a></span></p>
             <p> <span><a class="help" href="javascript:void(0)"  rel="nofollow" id="forgot_password">Forgot Password</a></span></p>
             <p> <span><a class="help" href="mailto:info@trays4.us?subject=Need Help">Contact Support</a></span></p>
         </div>
      </div>
    </div>
  </div>

</section>

@include('partials.frontend.footer')
<script src="{{ asset('/assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/js/sweetalert2.min.js') }}"></script>
@include('partials.frontend.common-js')
<script>
    $(document).ready(function () {
        $("#forgot_password").click(function (event) {
            Swal.fire({
                title: '{{ __("Enter your email") }}',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: '{{ __("Submit") }}',
                showLoaderOnConfirm: true,
                inputValidator: (value) => {
                    if (value === '' || !isEmail(value)) {
                        return '{{ __("Email is invalid") }}'
                    }
                }, preConfirm: (login) => {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('forgot_password_customer') }}",
                        data: {email: login}
                    }).done(function (data) {
                        if (data === '1') {
                            Swal.fire(
                                '{{ __("Sent") }}',
                                '{{ __("The password reset link is sent to your registered e-mail!") }}',
                                'success'
                            )
                        } else {
                            Swal.update({
                                title: '{{ __("Error") }}',
                                text: '{{ __("Email not found. Please try again.") }}',
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
