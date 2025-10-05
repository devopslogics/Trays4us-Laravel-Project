@extends('layouts.admin.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Add artist</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('add-artist-submitted') }}" method="post" enctype="multipart/form-data" id="add_artist_form" class="add_artist_submitted">

                        {{ csrf_field() }}

                        <fieldset class="ftu-filedset-input" >
                           <legend>Artist Info </legend>

                           <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="first_name" id="first_name" value="{{old('first_name')}}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Surname</label>
                                        <input type="text" class="form-control" name="last_name" id="last_name" value="{{old('last_name')}}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Company Name</label>
                                        <input type="text" class="form-control" name="company_name" value="{{old('company_name')}}">
                                    </div>
                                </div>

                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label>Display Name</label>
                                       <input type="text" class="form-control" name="display_name" value="{{old('display_name')}}">
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
                                        <input type="tel" class="form-control numeric_only" id="artist_phone" name="artist_phone" value="{{old('full_artist_phone')}}">
                                        <span id="phone_error"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="artist_email" value="{{old('artist_email')}}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Shipping address line 1</label>
                                        <input type="text" class="form-control" name="shiping_address1" value="{{old('shiping_address1')}}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Shipping address line 2</label>
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
                                        <input type="number"  class="form-control zip-code" name="postal_code" value="{{old('postal_code')}}">
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


                        <fieldset class="ftu-filedset-input" >
                            <legend>Overview  </legend>
                            <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Artist Logo (800x200)</label>
                                    <input type="file" class="form-control" name="artist_logo" value="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Artist Photo (453x453)</label>
                                    <input type="file" class="form-control" name="artist_photo">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">

                                    <label class="form-check-label" for="is_visible">Show on License Artwork page ? </label>
                                    <input class="form-check-input" type="checkbox" name="is_visible" value="1" id="is_visible" checked>

                                </div>
                            </div>

                            <?php /*
                            <div class="col-md-6">
                                <div class="form-group">

                                    <label class="form-check-label" for="is_feature_checkbox">Make Feature ? </label>
                                    <input class="form-check-input" type="checkbox" name="is_feature" value="1" id="is_feature_checkbox">

                                </div>
                            </div> */ ?>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="6" cols="100" maxlength="700">{{old('description')}}</textarea>
                                    <p><span id="remain">700</span> characters remaining</p>
                                </div>
                            </div>

                            </div>

                           </fieldset>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary" id="add_artist">Submit</button>
                            <a href="{{ route('artists') }}" class="btn btn-link">Cancel</a>
                        </div>
                    </form>

                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <div class="alert alert-success alert-block alert-success-div mb-0" style="display: none !important">
                        <button type="button" class="close" data-bs-dismiss="alert">×</button>
                        <strong></strong>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <link rel="stylesheet" href="{{asset('assets/phone_number/css/intlTelInput.css')}}">
    <script src="{{asset('assets/phone_number/js/intlTelInput.js')}}"></script>
    <script src="https://cdn.ckeditor.com/4.21.0/standard-all/ckeditor.js"></script>

    <script type="text/javascript">

        var input = document.querySelector("#artist_phone");
        var iti2 = window.intlTelInput(input, {
            geoIpLookup: function(callback) {
                fetch("https://ipapi.co/json")
                    .then(function(res) { return res.json(); })
                    .then(function(data) {  callback(data.country_code); })
                    .catch(function() { callback("us"); });
            },
            hiddenInput: "full_artist_phone",
            initialCountry: "auto",
            separateDialCode:true,
            utilsScript: "{{asset('assets/phone_number/js/utils.js')}}",
        });

        //---------------------------------------------------------------------------------------------------
        /*
        CKEDITOR.replace( 'description', {
            toolbarGroups: [
                { name: 'document',	   groups: [ 'mode', 'document' ] },			// Displays document group with its two subgroups.
                { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },			// Group's name will be used to create voice label.
                '/',																// Line break - next group will be placed in new line.
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'links' }
            ]
        });  */

        //----------------------------------------------------------------------------------------------------
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

            //-----------------------------------------------------------------------------------------------

            $("#artist_phone").blur(function(){
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


            $('#add_artist').click(function () {
                if($('#full_name').val()) {
                    if($("#artist_phone").val()) {
                        if (!iti2.isValidNumber()) {
                            var errorCode = iti2.getValidationError();
                            $('#phone_error').html(errorMap[errorCode]);
                            $('#phone_error').css('color','red');
                            $("#artist_phone").focus();
                            return false;
                        }
                    }

                }

            });

            //-----------------------------------------------------------------------------------------------

            $("#add_artist_form").submit(function(event) {
                event.preventDefault();
                URL = $("#add_artist_form").attr('action');
                _this = $(this);
                $.ajax({
                    url:$("#add_artist_form").attr('action'),
                    method:"POST",
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(result)
                    {
                        $(".print-error-msg").css('display','none');
                        $(".alert-success-div").hide();

                        if($.isEmptyObject(result.error)){
                            window.location.href = result.redirect_url;
                            /*
                            $(".alert-success-div").show();
                            $(".alert-success-div strong").text(result.message);
                            $("html, body").animate({ scrollTop: $('.alert-success-div').offset().top - 100 }, 500);
                            $('#add_artist_form')[0].reset(); */
                        } else {
                            $(".print-error-msg").find("ul").html('');
                            $(".print-error-msg").css('display','block');
                            $.each( result.error, function( key, value ) {
                                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                            });
                            $("html, body").animate({ scrollTop: $('.print-error-msg').offset().top - 100 }, 500);
                        }
                    }
                })
            });

            //-----------------------------------------------------------------------------------------------

            var maxchars = 700;

            $('body').on('keyup paste', '#description', function () {
                $(this).val($(this).val().substring(0, maxchars));
                var tlength = $(this).val().length;
                remain = maxchars - parseInt(tlength);
                $('#remain').text(remain);
            });

            //-----------------------------------------------------------------------------------------------

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
