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

                    @include('partials.flash-message')

                    <form action="{{ route('reset_update_password') }}" method="post" enctype="multipart/form-data" class="" >
                        {{ csrf_field() }}
                        <input type="hidden" class="form-control" name="token" value="{{ $token }}">
                        <div class="ftu-mb-input text-center">
                            <label for="password" class="form-label ftu-mb-label">Password</label>
                            <input type="password" class="tfu-email-handle form-control" name="password" id="password" value="{{old('email')}}">
                        </div>
                        <div class="ftu-mb-input  text-center">
                            <label for="password_confirmation" class="form-label ftu-mb-label">Confirm Password</label>
                            <input type="password" class="tfu-password-handle form-control" name="password_confirmation" id="password_confirmation" value="{{old('password')}}">
                        </div>
                        <button type="submit" class="ftu-signin-submit">Submit</button>
                    </form>


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
</body>
</html>
