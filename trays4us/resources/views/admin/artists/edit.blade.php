@extends('layouts.admin.dashboard')

@push('styles')
    <style>
        .cat_image_preview { position: relative;display: inline-block;}
        .cat_image_preview:hover .edit {display: block;}
        .edit {padding-top: 7px; padding-right: 7px; position: absolute;right: 0;top: 0;display: none;}
        .edit a {color: #000;}
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Edit artist</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('edit-artist-submitted') }}" method="post" enctype="multipart/form-data" id="edit_artist_form" class="edit_artist_submitted">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="artist_id" value="{{$artist->id}}">


                        <fieldset class="ftu-filedset-input" >
                           <legend>Artist Info </legend>
                            <div class="row">

                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{$artist->first_name}}">
                                </div>
                              </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Surname</label>
                                        <input type="text" class="form-control" name="last_name" id="last_name" value="{{$artist->last_name}}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Company Name</label>
                                        <input type="text" class="form-control" name="company_name" value="{{$artist->company_name}}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Display Name</label>
                                        <input type="text" class="form-control" name="display_name" value="{{$artist->display_name}}">
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
                                    <input type="text" class="form-control numeric_only" id="artist_phone"  name="artist_phone" value="{{$artist->artist_phone}}">
                                    <span id="phone_error"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="artist_email" value="{{$artist->artist_email}}">
                                </div>
                            </div>

                               <div class="col-md-6">
                                <div class="form-group">
                                    <label>Shipping address line 1</label>
                                    <input type="text" class="form-control" name="shiping_address1" value="{{$artist->shiping_address1}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Shipping address line 2</label>
                                    <input type="text" class="form-control" name="shiping_address2" value="{{$artist->shiping_address2}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="city" value="{{$artist->city}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Postal Code</label>
                                    <input type="number"  class="form-control zip-code" name="postal_code" value="{{$artist->postal_code}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select class="form-control" name="country" id="country">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}" {{ $artist->country == $country->id ? 'selected' : ''}}>{{$country->country_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <select class="form-control" name="state" id="state">
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" {{  $state->id == $artist->city ? 'selected' : ''}}>{{$state->state_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Website</label>
                                    <input type="text" class="form-control" name="website" value="{{$artist->website}}">
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
                                @if( !empty($artist->artist_logo) && \Storage::disk('uploads')->exists('/users/' . $artist->artist_logo))
                                    <div class="form-group">
                                        <div class="cat_image_preview avatar" style="margin-right: 5px;">
                                            <img class="avatar-img rounded" id="avatar2" src="{{ url('uploads/users/'.$artist->artist_logo) }}" alt="avatar" style="">
                                            <div class="edit"><a href="javascript:void(0)"  rel="nofollow" class="btn octf1-btn btn-set del-artist-logo"><i class="fas fa-trash"></i></a></div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Artist Photo (453 x 453)</label>
                                    <input type="file" class="form-control" name="artist_photo" value="">
                                </div>
                                @if( !empty($artist->artist_photo) && \Storage::disk('uploads')->exists('/users/' . $artist->artist_photo))
                                    <div class="form-group">
                                        <div class="cat_image_preview avatar" style="margin-right:5px;">
                                            <img class="avatar-img rounded" alt src="{{ url('uploads/users/'.$artist->artist_photo) }}">
                                            <div class="edit"><a href="javascript:void(0)"-  rel="nofollow" class="btn octf1-btn btn-set del-artist-photo"><i class="fas fa-trash"></i></a></div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-check-label" for="is_visible">Show on License Artwork page ? </label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_visible" value="1" id="is_visible" {{$artist->is_visible == 1 ? 'checked' : ''}}>
                                    </div>
                                </div>
                            </div>

                            <?php /*
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-check-label" for="is_feature">Make Feature ? </label>
                                    <input class="form-check-input" type="checkbox" name="is_feature" value="1" id="is_feature" {{$artist->is_feature == 1 ? 'checked' : ''}}>
                                </div>
                            </div> */ ?>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="6" cols="100" >{!! $artist->description !!}</textarea>
                                    <p><span id="remain">{{700- strlen($artist->description) ?? '700'}}</span> characters remaining</p>
                                </div>
                            </div>

                           </div>

                           </fieldset>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary" id="update_artist">Update</button>
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
        //-------------------------------------------------------------------------------------------------------------
        /*
        CKEDITOR.replace( 'description', {
            toolbarGroups: [
                { name: 'document',	   groups: [ 'mode', 'document' ] },			// Displays document group with its two subgroups.
                { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },			// Group's name will be used to create voice label.
                '/',																// Line break - next group will be placed in new line.
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'links' }
            ]

            // NOTE: Remember to leave 'toolbar' property with the default value (null).
        }); */

        //-------------------------------------------------------------------------------------------------------------
        $(document).ready(function() {

            var errorMap = ['{{ __("Please enter a valid number") }}', 'Invalid country code', 'The phone number is too short', 'The phone number is too long','{{ __("Please enter a valid number") }}','{{ __("Please enter a valid number") }}'];

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

            $('#update_artist').click(function () {
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

            $('.del-artist-logo').on('click', function(event){
                event.preventDefault();
                $('#loading').show();
                _this = $(this);
                $.ajax({
                    url:"{{ route('delete-artist-logo') }}",
                    data: { artist_id: $('#artist_id').val() },
                    type: "GET",
                    success: function(data){
                        $('#loading').hide();
                        _this.closest('.cat_image_preview').find('img').remove();
                    }
                });
            });

            //----------------------------------------------------------------------------------------------

            $('.del-artist-photo').on('click', function(event){
                event.preventDefault();
                $('#loading').show();
                _this = $(this);
                $.ajax({
                    url:"{{ route('delete-artist-photo') }}",
                    data: { artist_id: $('#artist_id').val() },
                    type: "GET",
                    success: function(data){
                        $('#loading').hide();
                        _this.closest('.cat_image_preview').find('img').remove();
                    }
                });
            });

            //----------------------------------------------------------------------------------------------

            $("#edit_artist_form").submit(function(event) {
                event.preventDefault();
                URL = $("#edit_artist_form").attr('action');
                _this = $(this);
                $.ajax({
                    url:$("#edit_artist_form").attr('action'),
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

                            //$(".alert-success-div").show();
                            //$(".alert-success-div strong").text(result.message);
                            //$("html, body").animate({ scrollTop: $('.alert-success-div').offset().top - 100 }, 500);

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

            //----------------------------------------------------------------------------------------------

            var maxchars = 700;

            $('body').on('keyup paste', '#description', function () {
                $(this).val($(this).val().substring(0, maxchars));
                var tlength = $(this).val().length;
                remain = maxchars - parseInt(tlength);
                $('#remain').text(remain);
            });

            //----------------------------------------------------------------------------------------------
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
                    }
                });
            }

        });


    </script>

@endpush
