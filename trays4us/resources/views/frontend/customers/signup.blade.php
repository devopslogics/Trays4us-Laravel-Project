@extends('layouts.frontend')
@section('content')


    <section class="tfu-create-account-wrapper" >

        <div class=" tfu-general-breadcumb-wrapper" >
            {{-- <ul class="shop-breadcrumb">
                <li><a href="{{ route('my-account') }}">My Account</a></li>
                <li>Create Account /</li>
            </ul> --}}
            <div class="tfu-general-heading" >
                <h1>APPLY FOR WHOLESALE ACCOUNT</h1>
            </div>
            <?php /*
            <ul class="shop-breadcrumb">
                <li><a href="{{ route('home') }}" > Home </a></li>
                <li><a href="#" >APPLY FOR WHOLESALE ACCOUNT</a></li>
            </ul> */ ?>

       </div>

       <div class="container-fluid" >
        <div class="row" >
            <div class="col-xl-12" >
                <div class="ftu-account-form-control tfu_form_outer" >

                    @include('partials.flash-message')
                    <form action="{{ route('customer-signup-submitted') }}" method="post" enctype="multipart/form-data" class="" id="custom_sgnup">
                        {{ csrf_field() }}

                        <div class="ftu-mb-input text-center">
                            <label for="company" class="form-label ftu-mb-label">Company name</label>
                            <input type="text" name="company"  class="tfu-company-handle form-control" id="company" value="{{old('company')}}">
                        </div>

                        <div class="ftu-mb-input text-center">
                            <label for="first_name" class="form-label ftu-mb-label">First name</label>
                            <input type="text" name="first_name"  class="tfu-company-handle form-control" id="first_name" value="{{old('first_name')}}">
                        </div>

                        <div class="ftu-mb-input text-center">
                            <label for="last_name" class="form-label ftu-mb-label">Last name</label>
                            <input type="text" name="last_name"  class="tfu-company-handle form-control" id="last_name" value="{{old('last_name')}}">
                        </div>

                        <div class="ftu-mb-input text-center">
                            <label for="shiping_address1" class="form-label ftu-mb-label">Shipping address 1</label>
                            <input type="text" name="shiping_address1" class="tfu-address-handle form-control" id="shiping_address1" value="{{old('shiping_address1')}}">
                        </div>

                        <div class="ftu-mb-input text-center">
                            <label for="shiping_address2" class="form-label ftu-mb-label">Shipping address 2</label>
                            <input type="text" name="shiping_address2" class="tfu-address-handle form-control" id="shiping_address2" value="{{old('shiping_address2')}}">
                        </div>

                        <div class="ftu-mb-input text-center">
                            <label for="city" class="form-label ftu-mb-label">City</label>
                            <input type="text" name="city" class="form-control" id="city" value="{{old('city')}}">
                        </div>

                        <div class="ftu-mb-input text-center">
                            <label for="postal_code" class="form-label ftu-mb-label">Postal Code</label>
                            <input type="number" name="postal_code" class="tfu-zipcode-handle form-control zip-code" id="postal_code" value="{{old('postal_code')}}">
                        </div>


                        <div class="ftu-mb-input text-center">
                            <label for="country" class="form-label ftu-mb-label">Country</label>
                            <select class="form-control" name="country" id="country">
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}" {{ old('country',$country->defulat == 1) == $country->id ? 'selected' : ''}}>{{$country->country_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="ftu-mb-input text-center">
                            <label for="state" class="form-label ftu-mb-label">State</label>
                            <select class="form-control" name="state" id="state">
                            </select>
                        </div>

                        <div class="ftu-mb-input text-center">
                            <label for="customer_phone" class="form-label ftu-mb-label">Phone</label>
                            <input type="tel" name="phone"  class="tfu-phone-handle form-control numeric_only" id="customer_phone" value="{{old('customer_full_phone')}}">
                            <span id="phone_error" style="float: left;margin: 5px;"></span>
                        </div>

                        <div class="ftu-mb-input text-center">
                            <label for="ftuInputEmail" class="form-label ftu-mb-label">E-Mail</label>
                            <input type="email" name="email" class="tfu-email-handle form-control" id="ftuInputEmail" aria-describedby="emailHelp" value="{{old('email')}}" autocomplete="off">

                        </div>

                        <div class="ftu-mb-input text-center">
                            <label for="ftu_password" class="form-label ftu-mb-label">Password</label>
                            <input type="password" name="password" class="tfu-email-handle form-control" id="ftu_password" value="{{old('password')}}" autocomplete="new-password">
                        </div>

                        <div class="ftu-mb-input text-center">
                            <label for="confirm_password" class="form-label ftu-mb-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="tfu-email-handle form-control" id="password_confirmation" value="{{old('password_confirmation')}}" autocomplete="off">
                        </div>


                        <button type="submit" class="ftu-account-submit" id="add_customer">Submit</button>

                    </form>

                </div>
            </div>
        </div>

        <div class="row" >
            <div class="col-xl-12" >
                <div class="tfu-account-useraccount">
                    <p>By creating an account, you agree to <span><a href="{{ route('term-condition') }}" >Trays4Us's Conditions</a></span> of <span><a href="{{ route('privacy-policy') }}" >Use and Privacy Notice.</a></span></p>
                    <p>Already a user -<span><a href="{{ route('sign-in') }}" >Sign In</a></span></p>
                </div>
            </div>
        </div>
       </div>

    </section>

@endsection

@push('scripts')

    <link rel="stylesheet" href="{{asset('assets/phone_number/css/intlTelInput.css')}}">
    <script src="{{asset('assets/phone_number/js/intlTelInput.js')}}"></script>

    <script type="text/javascript">

        var input = document.querySelector("#customer_phone");
        var iti2 = window.intlTelInput(input, {
            geoIpLookup: function(callback) {
                fetch("https://ipapi.co/json")
                    .then(function(res) { return res.json(); })
                    .then(function(data) {  callback(data.country_code); })
                    .catch(function() { callback("us"); });
            },
            hiddenInput: "customer_full_phone",
            initialCountry: "auto",
            separateDialCode:true,
            utilsScript: "{{asset('assets/phone_number/js/utils.js')}}",
        });

        $(document).ready(function() {
            var errorMap = ['{{ __("Please enter a valid number") }}', 'Invalid country code', 'The phone number is too short', 'The phone number is too long','{{ __("Please enter a valid number") }}','{{ __("Please enter a valid number") }}'];

            var country_id = $('#country').val();
            if (country_id > 0) {
                get_state_by_country_id(country_id);
            }

            $('#country').change(function () {
                var country_id = $(this).val();
                if (country_id) {
                    get_state_by_country_id(country_id);
                } else {
                    $('#state').empty().hide();
                }
            });

            //-----------------------------------------------------------------------------------------

            $("#customer_phone").blur(function(){
                if ($(this).val().trim()) {
                    if (iti2.isValidNumber()) {
                        $('#phone_error').html('');
                    } else {
                        var errorCode = iti2.getValidationError();
                        $('#phone_error').html(errorMap[errorCode]);
                        $('#phone_error').css('color','red');
                    }
                }
            });


            $('#add_customer').click(function () {

                if($('#company').val() && $('#address').val() && $('#postal_code').val() && $('#country').val()) {
                    if($("#customer_phone").val()) {
                        if (!iti2.isValidNumber()) {
                            var errorCode = iti2.getValidationError();
                            $('#phone_error').html(errorMap[errorCode]);
                            $('#phone_error').css('color','red');
                            $("#customer_phone").focus();
                            return false;
                        }
                    }

                }

            });

            //---------------------------------------------------------------------------------------


            function get_state_by_country_id(country_id) {
                $.ajax({
                    url: "{{ route('get-state-by-country-id') }}",
                    type: 'GET',
                    data: { country_id: country_id },
                    dataType: 'json',
                    success: function (data) {
                        $('#state').empty().show();
                        $('#state').append('<option value="">Select State</option>');
                        $.each(data, function (key, value) {
                            $('#state').append('<option value="' + value.id + '">' + value.state_name + '</option>');
                        });

                        var selectedCity = '{{ old('state') }}';
                        if ($('#state option[value="' + selectedCity + '"]').length > 0) {
                            $('#state').val(selectedCity);
                        } else {
                            $('#state').val('');
                        }
                    }
                });
            }

        });
    </script>

@endpush
