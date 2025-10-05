@extends('layouts.admin.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Add Customer</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('add-customer-submitted') }}" method="post" enctype="multipart/form-data" class="add_artist_submitted" autocomplete="off">
                        {{ csrf_field() }}
                        <fieldset class="ftu-filedset-input">
                            <legend>Customer Info </legend>
                            <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{old('first_name')}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" value="{{old('last_name')}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Company Name</label>
                                    <input type="text" class="form-control" name="company" value="{{old('company')}}">
                                </div>
                            </div>
                        </div>

                        </fieldset>

                        <fieldset class="ftu-filedset-input" >
                            <legend>Contact Info </legend>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="tel" class="form-control numeric_only" id="customer_phone" name="phone" value="{{old('customer_full_phone')}}">
                                        <span id="phone_error" style="float: left;margin: 5px;"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" value="{{old('email')}}" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" value="{{old('password')}}" autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="col-md-6"></div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Shipping address 1</label>
                                        <input type="text" class="form-control" name="shiping_address1" value="{{old('shiping_address1')}}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Shipping address 2</label>
                                        <input type="text" class="form-control" name="shiping_address2" value="{{old('shiping_address2')}}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" class="form-control" name="city" value="{{old('city')}}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Postal Code</label>
                                        <input type="text" class="form-control zip-code" name="postal_code" value="{{old('postal_code')}}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <select class="form-control" name="country" id="country">
                                            <option value="">Select Country</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}" {{ old('country', $country->defulat == 1) == $country->id ? 'selected' : ''}}>{{$country->country_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>State</label>
                                        <select class="form-control" name="state" id="state">
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Website</label>
                                        <input type="text" class="form-control" name="website" value="{{old('website')}}">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" id="add_customer">Submit</button>
                                    <a href="{{ route('customer') }}" class="btn btn-link">Cancel</a>
                                </div>

                    </form>


                </div>
            </div>
        </div>
    </div>
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

            //-----------------------------------------------------------------------------------------------

            var country_id = $('#country').val();
            if (country_id > 0) {
                get_state_by_country_id(country_id);
            }

            //-----------------------------------------------------------------------------------------------

            $('#country').change(function () {
                var country_id = $(this).val();
                if (country_id) {
                    get_state_by_country_id(country_id);
                } else {
                    $('#state').empty().hide();
                }
            });

            //-----------------------------------------------------------------------------------------------

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
                if($('#full_name').val()) {
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

            //-----------------------------------------------------------------------------------------------

            function get_state_by_country_id(country_id) {
                $.ajax({
                    url: "{{ route('get-state-by-country-id') }}",
                    type: 'GET',
                    data: { country_id: country_id},
                    dataType: 'json',
                    success: function (data) {
                        $('#state').empty().show();
                        $('#state').append('<option value="">Select State</option>');
                        $.each(data, function (key, value) {
                            $('#state').append('<option value="' + value.id + '" >' + value.state_name + '</option>');
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

            //-----------------------------------------------------------------------------------------------
        });
    </script>

@endpush
