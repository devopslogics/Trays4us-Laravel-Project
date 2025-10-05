@extends('layouts.frontend')
@section('content')


    <section class="tfu-create-account-wrapper" >

        <div class=" tfu-general-breadcumb-wrapper" >
            {{-- <ul class="shop-breadcrumb">
                <li><a href="{{ route('my-account') }}" >My Account  </a></li>
                <li><a href="javscript:void(0)">Change password /</a></li>
            </ul> --}}
            <div class="tfu-general-heading" >
                <h1>Change password</h1>
            </div>
       </div>


        <div class="" >
            <div class="col-xl-12" >
                <div class="ftu-account-form-control tfu_form_outer" >

                    @include('partials.flash-message')
                    <form action="{{ route('change-password-save') }}"  method="post" enctype="multipart/form-data" class="">
                        {{ csrf_field() }}

                        <div class="mb-5 text-center">
                            <label for="customer_phone" class="form-label mb-3">Current Password</label>
                            <input type="password" name="current_password"   class="tfu-phone-handle form-control" id="current_password" value="{{old('current_password')}}">
                        </div>

                        <div class="mb-5 text-center">
                            <label for="new_password" class="form-label mb-3">New Password</label>
                            <input type="password" name="password" class="tfu-email-handle form-control" id="password"  value="{{old('password')}}">
                        </div>

                        <div class="mb-5 text-center">
                            <label for="new_confirm_password" class="form-label mb-3">New Confirm Password</label>
                            <input type="password" name="password_confirmation" class="tfu-email-handle form-control" id="new_confirm_password"  value="{{old('password_confirmation')}}">
                        </div>

                        <button type="submit" class="ftu-account-submit" id="">Update Password</button>
                    </form>

                </div>
            </div>
        </div>


    </section>

@endsection

