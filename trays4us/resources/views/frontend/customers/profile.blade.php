@extends('layouts.frontend')
@push('styles')
    <style>


        .autocomplete-container {
            margin-bottom: 20px;
        }

        .input-container {
            display: flex;
            position: relative;
        }

        .input-container input {
            flex: 1;
            outline: none;

            border: 1px solid rgba(0, 0, 0, 0.2);
            padding: 10px;
            padding-right: 31px;
            font-size: 16px;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0px 2px 10px 2px rgba(0, 0, 0, 0.1);
            border-top: none;
            background-color: #fff;

            z-index: 99;
            top: calc(100% + 2px);
            left: 0;
            right: 0;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
        }

        .autocomplete-items div:hover {
            /*when hovering an item:*/
            background-color: rgba(0, 0, 0, 0.1);
        }

        .autocomplete-items .autocomplete-active {
            /*when navigating through the items using the arrow keys:*/
            background-color: rgba(0, 0, 0, 0.1);
        }

        .clear-button {
            color: rgba(0, 0, 0, 0.4);
            cursor: pointer;

            position: absolute;
            right: 5px;
            top: 0;

            height: 100%;
            display: none;
            align-items: center;
        }

        .clear-button.visible {
            display: flex;
        }

        .clear-button:hover {
            color: rgba(0, 0, 0, 0.6);
        }


    </style>
@endpush
@section('content')


    <section class="tfu-create-account-wrapper" >

        <div class=" tfu-general-breadcumb-wrapper" >
            {{-- <ul class="shop-breadcrumb">
                <li><a href="{{ route('my-account') }}" >My Account  </a></li>
                <li><a href="javscript:void(0)"> Profile /</a></li>
            </ul> --}}
            <div class="tfu-general-heading" >
                <h1>Profile</h1>
            </div>
       </div>


        <div class="" >
            <div class="col-xl-12" >
                <div class="ftu-account-form-control tfu_form_outer" >

                    @include('partials.flash-message')

                    <form action="{{ route('profile-update-save') }}"  method="post" enctype="multipart/form-data" class="">
                        {{ csrf_field() }}
                        <input type="hidden" name="previous_url"  value="{{old('previous_url', url()->previous())}}">
                        <div class="mb-5 text-center">
                            <label for="company" class="form-label mb-3">Company name</label>
                            <input type="text" name="company"  class="tfu-company-handle form-control" id="company" value="{{old('company', $customer_detail->company)}}">
                        </div>

                        <div class="ftu-mb-input text-center">
                            <label for="first_name" class="form-label ftu-mb-label">First name</label>
                            <input type="text" name="first_name"  class="tfu-company-handle form-control" id="first_name" value="{{old('first_name', $customer_detail->first_name)}}">
                        </div>

                        <div class="ftu-mb-input text-center">
                            <label for="last_name" class="form-label ftu-mb-label">Last name</label>
                            <input type="text" name="last_name"  class="tfu-company-handle form-control" id="last_name" value="{{old('last_name', $customer_detail->last_name)}}">
                        </div>

                        <div class="ftu-mb-input text-center">
                            <label for="shiping_address1" class="form-label ftu-mb-label">Shipping address 1</label>
                            <input type="text" name="shiping_address1" class="tfu-address-handle form-control" id="shiping_address1" value="{{old('shiping_address1', $customer_detail->shiping_address1)}}" autocomplete="off">
                            <?php /*<div class="autocomplete-container" id="autocomplete-container"></div> */ ?>
                        </div>

                        <div class="ftu-mb-input text-center">
                            <label for="shiping_address2" class="form-label ftu-mb-label">Shipping address 2</label>
                            <input type="text" name="shiping_address2" class="tfu-address-handle form-control" id="shiping_address2" value="{{old('shiping_address2', $customer_detail->shiping_address2)}}" autocomplete="off">
                        </div>

                        <div class="ftu-mb-input text-center">
                            <label for="city" class="form-label ftu-mb-label">City</label>
                            <input type="text" name="city" class="tfu-address-handle form-control" id="city" value="{{old('city', $customer_detail->city)}}">
                        </div>

                        <div class="mb-5 text-center">
                            <label for="postal_code" class="form-label mb-3">Postal Code</label>
                            <input type="number" name="postal_code" class="tfu-zipcode-handle form-control zip-code" id="postal_code" value="{{old('postal_code', $customer_detail->postal_code)}}">
                        </div>


                        <div class="mb-5 text-center">
                            <label for="country" class="form-label mb-3">Country</label>
                            <select class="form-control" name="country" id="country">
                                <?php /*<option value="">Select Country</option> */ ?>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}" {{ $customer_detail->country_id == $country->id ? 'selected' : ''}} data-country_code="{{$country->country_code}}">{{$country->country_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-5 text-center">
                            <label for="state" class="form-label mb-3">State</label>
                            <select class="form-control" name="state" id="state">
                                <option value="">Select State</option>
                                @foreach($states as $state)
                                    <option value="{{$state->id}}" {{ old('state', $customer_detail->state_id) == $state->id ? 'selected' : ''}} data-stateobr="{{$state->abbrev}}">{{$state->state_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-5 text-center">
                            <label for="customer_phone" class="form-label mb-3">Phone</label>
                            <input type="tel" name="phone"   class="tfu-phone-handle form-control numeric_only" id="customer_phone" value="{{old('customer_full_phone', $customer_detail->phone)}}">
                            <span id="phone_error" style="float: left;margin: 5px;"></span>
                        </div>

                        <div class="mb-5 text-center">
                            <label for="ftuInputEmail" class="form-label mb-3">E-Mail</label>
                            <input type="email" name="email" class="tfu-email-handle form-control" id="ftuInputEmail" aria-describedby="emailHelp" value="{{$customer_detail->email}}" readonly>
                        </div>

                        <button type="submit" class="ftu-account-submit" id="update_customer">Update Profile</button>
                    </form>

                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')

    <link rel="stylesheet" href="{{asset('assets/phone_number/css/intlTelInput.css')}}">
    <script src="{{asset('assets/phone_number/js/intlTelInput.js')}}"></script>

    <script type="text/javascript">
        var errorMap = ['{{ __("Please enter a valid number") }}', 'Invalid country code', 'The phone number is too short', 'The phone number is too long','{{ __("Please enter a valid number") }}','{{ __("Please enter a valid number") }}'];

        var input = document.querySelector("#customer_phone");
        var iti2 = window.intlTelInput(input, {
            geoIpLookup: function(callback) {
                fetch("https://ipapi.co/json")
                    .then(function(res) { return res.json(); })
                    .then(function(data) { callback(data.country_code); })
                    .catch(function() { callback("us"); });
            },
            hiddenInput: "customer_full_phone",
            initialCountry: "auto",
            separateDialCode:true,
            utilsScript: "{{asset('assets/phone_number/js/utils.js')}}",
        });

        $(document).ready(function() {
            /*
            var country_id = $('#country').val();
            if (country_id > 0) {
               // get_state_by_country_id(country_id);
            }


            $('#country').change(function () {
                var country_id = $(this).val();
                if (country_id) {
                    get_state_by_country_id(country_id);
                } else {
                    $('#state').empty().hide();
                }
            }); */

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


            $('#update_customer').click(function () {

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

    <?php /*

    <script>

        function addressAutocomplete(containerElement, callback, options) {

            const MIN_ADDRESS_LENGTH = 3;
            const DEBOUNCE_DELAY = 300;

            // create container for input element
            const inputContainerElement = document.createElement("div");
            inputContainerElement.setAttribute("class", "input-container");
            containerElement.appendChild(inputContainerElement);

            // create input element
            const inputElement = document.getElementById("shiping_address1"); //document.createElement("input");
            //inputElement.setAttribute("type", "text");
            //inputElement.setAttribute("placeholder", options.placeholder);
            //inputContainerElement.appendChild(inputElement);

            // add input field clear button
            const clearButton = document.createElement("div");
            clearButton.classList.add("clear-button");
            addIcon(clearButton);
            clearButton.addEventListener("click", (e) => {
                e.stopPropagation();
                inputElement.value = '';
                callback(null);
                clearButton.classList.remove("visible");
                closeDropDownList();
            });

            //inputContainerElement.appendChild(clearButton);


            let currentTimeout;

            let currentPromiseReject;

            let focusedItemIndex;

            inputElement.addEventListener("input", function(e) {
                const currentValue = this.value;


                closeDropDownList();


                // Cancel previous timeout
                if (currentTimeout) {
                    clearTimeout(currentTimeout);
                }

                // Cancel previous request promise
                if (currentPromiseReject) {
                    currentPromiseReject({
                        canceled: true
                    });
                }

                if (!currentValue) {
                    clearButton.classList.remove("visible");
                }

                // Show clearButton when there is a text
                clearButton.classList.add("visible");

                // Skip empty or short address strings
                if (!currentValue || currentValue.length < MIN_ADDRESS_LENGTH) {
                    return false;
                }


                currentTimeout = setTimeout(() => {
                    currentTimeout = null;


                    const promise = new Promise((resolve, reject) => {
                        currentPromiseReject = reject;

                        // The API Key provided is restricted to JSFiddle website
                        // Get your own API Key on https://myprojects.geoapify.com
                        const apiKey = "453ec31beabb46ec8229bc804c5858d5";

                        var url = `https://api.geoapify.com/v1/geocode/autocomplete?text=${encodeURIComponent(currentValue)}&type=locality&format=json&limit=5&apiKey=${apiKey}`;

                        fetch(url)
                            .then(response => {
                                currentPromiseReject = null;

                                // check if the call was successful
                                if (response.ok) {
                                    response.json().then(data => resolve(data));
                                } else {
                                    response.json().then(data => reject(data));
                                }
                            });
                    });

                    promise.then((data) => {
                        // here we get address suggestions
                        currentItems = data.results;


                        const autocompleteItemsElement = document.createElement("div");
                        autocompleteItemsElement.setAttribute("class", "autocomplete-items");
                        inputContainerElement.appendChild(autocompleteItemsElement);


                        data.results.forEach((result, index) => {

                            const itemElement = document.createElement("div");

                            itemElement.innerHTML = result.formatted;
                            autocompleteItemsElement.appendChild(itemElement);


                            itemElement.addEventListener("click", function(e) {
                                inputElement.value = currentItems[index].formatted;
                                callback(currentItems[index]);

                                closeDropDownList();
                            });
                        });

                    }, (err) => {
                        if (!err.canceled) {
                            console.log(err);
                        }
                    });
                }, DEBOUNCE_DELAY);
            });


            inputElement.addEventListener("keydown", function(e) {
                var autocompleteItemsElement = containerElement.querySelector(".autocomplete-items");
                if (autocompleteItemsElement) {
                    var itemElements = autocompleteItemsElement.getElementsByTagName("div");
                    if (e.keyCode == 40) {
                        e.preventDefault();

                        focusedItemIndex = focusedItemIndex !== itemElements.length - 1 ? focusedItemIndex + 1 : 0;

                        setActive(itemElements, focusedItemIndex);
                    } else if (e.keyCode == 38) {
                        e.preventDefault();


                        focusedItemIndex = focusedItemIndex !== 0 ? focusedItemIndex - 1 : focusedItemIndex = (itemElements.length - 1);

                        setActive(itemElements, focusedItemIndex);
                    } else if (e.keyCode == 13) {

                        e.preventDefault();
                        if (focusedItemIndex > -1) {
                            closeDropDownList();
                        }
                    }
                } else {
                    if (e.keyCode == 40) {

                        var event = document.createEvent('Event');
                        event.initEvent('input', true, true);
                        inputElement.dispatchEvent(event);
                    }
                }
            });

            function setActive(items, index) {
                if (!items || !items.length) return false;

                for (var i = 0; i < items.length; i++) {
                    items[i].classList.remove("autocomplete-active");
                }


                items[index].classList.add("autocomplete-active");

                // Change input value and notify
                inputElement.value = currentItems[index].formatted;
                callback(currentItems[index]);
            }

            function closeDropDownList() {
                const autocompleteItemsElement = inputContainerElement.querySelector(".autocomplete-items");
                if (autocompleteItemsElement) {
                    inputContainerElement.removeChild(autocompleteItemsElement);
                }

                focusedItemIndex = -1;
            }

            function addIcon(buttonElement) {
                const svgElement = document.createElementNS("http://www.w3.org/2000/svg", 'svg');
                svgElement.setAttribute('viewBox', "0 0 24 24");
                svgElement.setAttribute('height', "24");

                const iconElement = document.createElementNS("http://www.w3.org/2000/svg", 'path');
                iconElement.setAttribute("d", "M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z");
                iconElement.setAttribute('fill', 'currentColor');
                svgElement.appendChild(iconElement);
                buttonElement.appendChild(svgElement);
            }


            document.addEventListener("click", function(e) {
                if (e.target !== inputElement) {
                    closeDropDownList();
                } else if (!containerElement.querySelector(".autocomplete-items")) {
                    // open dropdown list again
                    var event = document.createEvent('Event');
                    event.initEvent('input', true, true);
                    inputElement.dispatchEvent(event);
                }
            });
        }

        addressAutocomplete(document.getElementById("autocomplete-container"), (data) => {
            console.log("Selected option: ");
            console.log(data);
            //console.log(data.lat);
            //console.log(data.lon);

            if(data.postcode && $('#postal_code').val() == "")
                $('#postal_code').val(data.postcode);

            if(data.city && $('#city').val() == "")
                $('#city').val(data.city);


            if(data.state_code) {
                $('#state [data-stateobr="' + data.state_code + '"]').prop("selected", true);
            }

        }, {
            placeholder: "Enter an address here"
        });


    </script>

    */ ?>

@endpush
