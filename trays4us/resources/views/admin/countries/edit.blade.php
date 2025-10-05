@extends('layouts.admin.dashboard')
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

                    <form action="{{ route('edit-artist-submitted') }}" method="post" enctype="multipart/form-data" class="edit_artist_submitted">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$artist->id}}">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" name="full_name" id="full_name" value="{{$artist->full_name}}">
                                </div>
                            </div>

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
                                    <label>Company Name</label>
                                    <input type="text" class="form-control" name="company_name" value="{{$artist->company_name}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Artist Photo</label>
                                    <input type="file" class="form-control" name="artist_photo" value="">
                                </div>
                                @if( !empty($artist->artist_photo) && \Storage::disk('uploads')->exists('/users/' . $artist->artist_photo))
                                    <div class="form-group">
                                        <div class="avatar">
                                            <img class="avatar-img rounded" alt src="{{ url('uploads/users/'.$artist->artist_photo) }}">
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address" value="{{$artist->address}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Postal Code</label>
                                    <input type="text" class="form-control zip-code" name="postal_code" value="{{$artist->postal_code}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select class="form-control select" name="country" id="country">
                                        <option>Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}" {{ $artist->country == $country->id ? 'selected' : ''}}>{{$country->country_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <select class="form-control select" name="city" id="city">
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

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-check-label" for="is_feature_checkbox">Is Feature ? </label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_feature" value="1" id="is_feature_checkbox" {{$artist->is_feature == 1 ? 'checked' : ''}}>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12ss">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" id="description">{{$artist->description}}</textarea>
                                </div>
                            </div>

                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary" id="update_artist">Update</button>
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
    <script src="https://cdn.ckeditor.com/4.21.0/standard-all/ckeditor.js"></script>
    <script type="text/javascript">

        var input = document.querySelector("#artist_phone");
        var iti2 = window.intlTelInput(input, {
            geoIpLookup: function(callback) {
                fetch("https://ipapi.co/json")
                    .then(function(res) { return res.json(); })
                    .then(function(data) { alert(data.country_code); callback(data.country_code); })
                    .catch(function() { callback("us"); });
            },
            hiddenInput: "full_artist_phone",
            initialCountry: "auto",
            separateDialCode:true,
            utilsScript: "{{asset('assets/phone_number/js/utils.js')}}",
        });
        //-------------------------------------------------------------------------------------------------------------

        CKEDITOR.replace( 'description', {
            toolbarGroups: [
                { name: 'document',	   groups: [ 'mode', 'document' ] },			// Displays document group with its two subgroups.
                { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },			// Group's name will be used to create voice label.
                '/',																// Line break - next group will be placed in new line.
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'links' }
            ]

            // NOTE: Remember to leave 'toolbar' property with the default value (null).
        });

        //-------------------------------------------------------------------------------------------------------------
        $(document).ready(function() {
            var errorMap = ['{{ __("Please enter a valid number") }}', 'Invalid country code', 'The phone number is too short', 'The phone number is too long','{{ __("Please enter a valid number") }}','{{ __("Please enter a valid number") }}'];

            $('#country').change(function () {
                var country_id = $(this).val();
                if (country_id) {
                    get_state_by_country_id(country_id);
                } else {
                    $('#city').empty().hide();
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

            function get_state_by_country_id(country_id) {
                $.ajax({
                    url: "{{ route('get-state-by-country-id') }}",
                    type: 'GET',
                    data: { country_id: country_id },
                    dataType: 'json',
                    success: function (data) {
                        $('#city').empty().show();
                        $('#city').append('<option value="">Select State</option>');
                        $.each(data, function (key, value) {
                            $('#city').append('<option value="' + value.id + '">' + value.state_name + '</option>');
                        });
                    }
                });
            }

        });
    </script>

@endpush
