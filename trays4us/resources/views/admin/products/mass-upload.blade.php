@extends('layouts.admin.dashboard')
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dropzone.css') }}">
    <link rel="stylesheet" href="{{asset('assets/css/tags.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.min.css')}}">
    <style>
        .sortable {padding: 0;-webkit-touch-callout: none;-webkit-user-select: none;-khtml-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;}
        .sortable li {float: left; overflow:hidden; border:1px solid red;text-align: center;  margin:5px;list-style: none;}
        li.sortable-placeholder {border: 1px dashed #CCC;  background: none;}
        .dropzone .dz-preview .dz-image img {width: 120px;}
    </style>

@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Mass Upload</h3>
                    </div>
                </div>
            </div>
                <div class="card">
                    <div class="ftu-mass-upload card-body">
                        <div class="row" >
                            <div class="col-xl-12">
                                <h2>Image Upload Instructions</h2>
                                <ul>

                                    <li><strong>1st: Featured main product image with a SKU number</strong>
                                        <ul>
                                            <li>Alan Claude_Maine Flag_1108-10876.png</li>
                                        </ul>
                                    </li>

                                    <li><strong>2nd: Optional product-specific images with a SKU number</strong>
                                        <ul>
                                            <li>Alan Claude_Maine Flag_1108-10876_img2.png</li>
                                            <li>Alan Claude_Maine Flag_1108-10876_img3.png</li>
                                        </ul>
                                    </li>

                                    <li><strong>3rd: Optional common Images without a SKU number</strong>
                                        <ul>
                                            <li>Alan Claude_common1.png</li>
                                            <li>Alan Claude_common2.png</li>
                                        </ul>
                                    </li>


                                    <li><strong>4th: Optional Product Back Image with a SKU number</strong>
                                        <ul>
                                            <li>Alan Claude_Maine Flag_1108-10876_back.png</li>
                                        </ul>
                                    </li>
                            </ul>
                            </div>
                        </div>

                        <form action="{{ route('add-product-submitted') }}" method="post" enctype="multipart/form-data" class="ftu-form-user-uploaded dropzone" id="mass_upload_save">

                            <div class="row" >

                            <div class="col-xl-12">

                                <div id="dropzoneDragArea" class="dz-default dz-message dropzoneDragArea">
                                    <span class="dz-default dz-message">Drop files here or click to upload (600x600)</span>
                                    <div class="col-xl-12">
                                        <div class="dropzone-previews"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12">
                               <div class="ftu-mass-image-path" id="mu_image_name">
                               </div>
                            </div>


                            <div class="col-xl-12" >

                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="staticEmail" class=" col-form-label">Parent Product type</label>
                                            <select class="form-control" name="parent_product_type" id="parent_product_type">
                                                <option value="">Select Parent type</option>
                                                @foreach($parent_product_types as $parent_product_type)
                                                    <option value="{{$parent_product_type->id}}" {{ old('parent_product_type') == $parent_product_type->id ? 'selected' : ''}}>{{$parent_product_type->type_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price" class="col-form-label">Price</label>
                                            <input type="text" class="form-control" name="price" id="price" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="staticEmail" class="col-form-label">Sub Product type</label>

                                            <select class="form-control" name="sub_product_type" id="sub_product_type">
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="case_pack" class="col-form-label">Case pack</label>
                                            <input type="text" class="form-control" name="case_pack" id="case_pack" value="" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="staticEmail" class="col-form-label">Minimums</label>
                                            <select class="form-control" name="product_customizable" id="product_customizable">
                                                <option  value="">Select Minimum</option>
                                                @foreach($customizables as $customizable)
                                                    <option value="{{$customizable->id}}" {{ old('product_customizable', $customizable->defulat == 1) == $customizable->id ? 'selected' : ''}}>{{$customizable->customizable_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="minimum_order_quantity" class="col-form-label">MOQ(Minimum order quantity)</label>
                                            <input type="text" class="form-control" name="minimum_order_quantity" id="minimum_order_quantity" value="" readonly>
                                        </div>
                                    </div>


                                    <div class="col-md-6 align-self-center">
                                        <div class="form-group">
                                            <label>Badge</label>
                                            <select class="form-control" name="badge" id="badge">
                                                <option value="">Select Badge</option>
                                                @foreach($badges as $badge)
                                                    <option value="{{$badge->id}}" data-custom="{{ $badge->custom }}">{{$badge->badge}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="staticEmail" class="col-form-label">Artist</label>
                                            <select class="form-control" name="artist_id" id="artist_id">
                                                <option  value="">Select  Artist</option>
                                                @foreach($artists as $artist)
                                                    @php
                                                        $artist_name = $artist->first_name.' '.$artist->last_name;
                                                        if($artist->display_name)
                                                           $artist_name = $artist->display_name;
                                                    @endphp
                                                    <option value="{{$artist->id}}" {{ old('artist_id') == $artist->id ? 'selected' : ''}}>{{$artist_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group" id="customer_only" style="display: none">
                                            <label>Visible to customer only</label>
                                            <?php /*
                                            <select class="form-control" name="customer_id" id="customer_id">
                                                <option  value="">Select  Customer</option>
                                                @foreach($customers as $customer)
                                                    <option value="{{$customer->id}}">{{$customer->first_name}} {{$customer->last_name}}</option>
                                                @endforeach
                                            </select> */ ?>

                                            <input class="form-control" type="text" name="customer_name" id="customer_name" value="">
                                            <input type="hidden" id="customer_id" name="customer_id" value="{{ isset($_GET['customer_id']) ? $_GET['customer_id']: '' }}">

                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="tag_wrapper">
                                                <label for="staticEmail" class="col-form-label">Tags</label>
                                                <input type="hidden" name="tag_ids" class="tag-ids" id="parent_tag_ids" value="">
                                                <div class="tags-input">
                                                    <div class="myTags" id="">
                                                        <span class="data"></span>
                                                        <span class="autocomplete">
                                                        <input type="text" class="tfu_auto" fdprocessedid="7t76h">
                                                        <div class="autocomplete-items"></div>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="staticEmail" class="col-form-label">Style</label>
                                            <select class="form-control" name="style_id" id="style_id">
                                                <option value="">Select Style</option>
                                                @foreach($themes as $theme)
                                                    <option value="{{$theme->id}}" {{ old('style_id') == $theme->id ? 'selected' : ''}}>{{$theme->style_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="staticEmail" class="col-form-label">Country</label>
                                            <select class="form-control" name="country_id" id="country_id">
                                                <option value="">Select Country</option>
                                                @foreach($countries as $country)
                                                    <option value="{{$country->id}}">{{$country->country_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">State</label>
                                            <select class="form-control" name="state_id" id="state_id">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">Description</label>
                                            <textarea class="form-control" name="description" id="custom_editor" rows="4" cols="50"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" id="mass_upload_preview_btn">Preview</button>
                                        </div>
                                    </div>

                                </div>

                            </div>


                                <div id="ajax_preview">

                                </div>

                                <img src="{{ asset('/assets/images/ftu-line-upload.svg') }}"  />

                                <div class="tfu-uploaded-success-btn">
                                    <button type="button" class="btn btn-primary" id="mass_upload_save_btn">Proceed to Upload</button>
                                </div>


                                <div class="alert alert-danger print-error-msg" style="display:none;margin-top: 10px;">
                                    <ul></ul>
                                </div>

                        </div>
                        </form>
                     </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('assets/js/tags.js')}}"></script>
    <script src="{{ asset('assets/js/dropzone.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>


    <script>
        $(document).ready(function () {

            //-------------------------------------- Get sub category by parent id   -----------------

            $('#parent_product_type').change(function () {
                var parentId = $(this).val();
                if (parentId) {
                    get_sub_product_type_by_id(parentId);
                } else {
                    $('#sub_product_type').empty().hide();
                }
            });

            //----------------------------- Get state by country id on change event -------------------
            var country_id = $('#country_id').val();
            if (country_id > 0) {
                get_state_by_country_id(country_id);
            }

            $('#country_id').change(function () {
                var country_id = $(this).val();
                if (country_id) {
                    get_state_by_country_id(country_id);
                } else {
                    $('#state_id').empty().hide();
                }
            });

            //------------------------------------------------------------------------------------------------

            $(document).on("change","#sub_product_type",function() {
                var type_id = $(this).val();
                $.ajax({
                    url: "{{ route('get-case-pack-by-types') }}",
                    type: 'GET',
                    data: { type_id: type_id },
                    dataType: 'json',
                    success: function (data) {
                        $('#case_pack').val('');
                        if(data.case_pack && data.case_pack > 0) {
                            $('#case_pack').val(data.case_pack);
                        }
                        get_minimam_order_quantity_by_design();
                    }
                });
            });

            //-----------------------------------------------------------------------------------------------

            $('#badge').change(function () {
                var custom = $('#badge option:selected').attr('data-custom');
                $('#customer_only').css("display", "none");
                $("#customer_id").val('');
                $("#customer_name").val('');
                if(custom > 0) {
                    $('#customer_only').css("display", "block");
                }
            });


            //-----------------------------------------------------------------------------------------------

            $('#customer_name').autocomplete({
                minLength: 3,
                source: function (request, response) {
                    $.ajax({
                        url: "{{ route('customer-autocomplete') }}",
                        method: "GET",
                        data: { query: request.term },
                        dataType: "json",
                        success: function (data) {
                            response(data.map(function(customer) {
                                return {
                                    label: customer.company + ' ( '+customer.id+' )',
                                    value: customer.company + ' ( '+customer.id+' )',
                                    customer_id: customer.id
                                };
                            }));
                        },
                        error: function (result) {
                            alert("Error");
                        }
                    });
                },
                select: function (event, ui) {
                    $('#customer_name').val(ui.item.label);
                    $('#customer_id').val(ui.item.customer_id);
                }
            });


            //-----------------------------------------------------------------------------------------------

            $(document).on("change","#product_customizable",function() {
                get_minimam_order_quantity_by_design();
            });

            //------------------------------------------------------------------------------------------------

            function get_minimam_order_quantity_by_design() {
                var type_id = $('#sub_product_type').val();
                var customizable_id = $('#product_customizable').val();
                $.ajax({
                    url: "{{ route('get-minimum-order-quantity-by-design') }}",
                    type: 'GET',
                    data: { type_id: type_id,customizable_id : customizable_id },
                    dataType: 'json',
                    success: function (data) {

                        $('#minimum_order_quantity').val('');
                        if(data.minimum_order_quantity && data.minimum_order_quantity > 0) {
                            $('#minimum_order_quantity').val(data.minimum_order_quantity);
                        }
                    }
                });
            }

            //------------------------------------------------------------------------------------------------

            function get_sub_product_type_by_id(parentId) {
                $.ajax({
                    url: "{{ route('get-sub-product-type-by-id') }}",
                    type: 'GET',
                    data: { parent_id: parentId },
                    dataType: 'json',
                    success: function (data) {
                        $('#sub_product_type').empty().show();
                        $('#sub_product_type').append('<option value="">Select Sub-Product Type</option>');
                        $.each(data, function (key, value) {
                            $('#sub_product_type').append('<option value="' + value.id + '">' + value.type_name + '</option>');
                        });
                    }
                });
            }

            //------------------------------------------------------------------------------------------------

            function get_state_by_country_id(country_id) {
                $.ajax({
                    url: "{{ route('get-state-by-country-id') }}",
                    type: 'GET',
                    data: { country_id: country_id },
                    dataType: 'json',
                    success: function (data) {
                        $('#state_id').empty().show();
                        $('#state_id').append('<option value="">Select State</option>');
                        $.each(data, function (key, value) {
                            $('#state_id').append('<option value="' + value.id + '">' + value.state_name + '</option>');
                        });

                        var selectedCity = '{{ old('state_id') }}';
                        if ($('#state_id option[value="' + selectedCity + '"]').length > 0) {
                            $('#state_id').val(selectedCity);
                        } else {
                            $('#state_id').val('');
                        }

                    }
                });
            }

            //-------------------------------------------------------------------------------------------

        });

        function runSuggestions(element,query) {
            let sug_area=$(element).parents().eq(2).find('.autocomplete .autocomplete-items');
            $.getJSON( "{{ route('get-autocomplete-product-tag') }}?tag="+query, function( data ) {
                _tag_input_suggestions_data = data;
                $('.tags-input .autocomplete-items').html('');
                $.each(data,function (key,value) {
                    let template = $("<div>"+value.name+"</div>").hide()
                    sug_area.append(template)
                    template.show()
                })


            });
        }

    </script>

    <script>
        Dropzone.autoDiscover = false;
        // Dropzone.options.demoform = false;
        var _add_file = _remove_file = 0;
        let token = $('[name="_token"]').val();
        $(function() {

            var myDropzone = new Dropzone("#dropzoneDragArea", {
                paramName: "mass_upload",
                url: "{{ route('mass-upload-save') }}",
                previewsContainer: '.dropzone-previews',
                // previewTemplate : $('.preview').html(),
                dictDefaultMessage: "Drop files here or click to upload (600x600)",
                addRemoveLinks: true,
                autoProcessQueue: false,
                // maxFilesize: 2,
                parallelUploads: 50,
                uploadMultiple: true,
                acceptedFiles: "image/*",
                maxFiles: 50,
                params: {
                    _token: token
                },
                init: function() {
                    var myDropzone = this;
                    $("#mass_upload_save_btn").prop('disabled', true); // Mass upload save button in database
                    $("#mass_upload_preview_btn").prop('disabled', false); // Mass upload just for preview before save

                    $("#mass_upload_preview_btn").click(function (e) {
                        e.preventDefault();
                        $('#loading').show();
                        $(".print-error-msg").find("ul").html('');
                        $(".print-error-msg").css('display','none');
                        // Check if there are files in the queue
                        if (myDropzone.getQueuedFiles().length > 0) {
                            myDropzone.processQueue();
                            $("#mass_upload_preview_btn").prop('disabled', true);
                        } else {
                            $('#loading').hide();
                            $(".print-error-msg").find("ul").html('');
                            $(".print-error-msg").css('display','block');
                            $(".print-error-msg").find("ul").append('<li>Please select images for mass upload</li>');
                            $("html, body").animate({ scrollTop: $('.print-error-msg').offset().top - 100 }, 100);
                        }
                    });


                    this.on('sending', function(file, xhr, formData){
                        formData.append("_token", '{{ csrf_token() }}');
                        formData.append("artist_id", jQuery("#artist_id").val());
                        if(jQuery("#customer_id").val() != null)
                            formData.append("customer_id", jQuery("#customer_id").val());
                        formData.append("customer_name", jQuery("#customer_name").val());
                        formData.append("badge", jQuery("#badge").val());
                        formData.append("style_id", jQuery("#style_id").val());
                        formData.append("price", jQuery("#price").val());
                        formData.append("minimum_order_quantity", jQuery("#minimum_order_quantity").val());
                        formData.append("case_pack", jQuery("#case_pack").val());
                        formData.append("product_customizable", jQuery("#product_customizable").val());
                        formData.append("country_id", jQuery("#country_id").val());
                        if(jQuery("#state_id").val() != null)
                            formData.append("state_id", jQuery("#state_id").val());
                        formData.append("description", jQuery("#custom_editor").val());
                        formData.append("parent_product_type", jQuery("#parent_product_type").val());
                        formData.append("sub_product_type", jQuery("#sub_product_type").val());
                        formData.append("tag_ids", jQuery("#parent_tag_ids").val());
                    });


                   this.on("success", function (file, result) {
                       $('#loading').hide();
                       $("#mass_upload_save_btn").prop('disabled', false);
                       $('#ajax_preview').html(result.html);
                       file.status = 'queued';
                       console.log(result);
                       if(result.catch_error) {
                           console.log('catch_error');
                           $(".print-error-msg").find("ul").html('');
                           $(".print-error-msg").css('display','block');
                           $(".print-error-msg").find("ul").append('<li>Something is wrong in data provided, please recheck</li>');
                           $("#mass_upload_save_btn").prop('disabled', true); // Mass upload save button in database
                           $("#mass_upload_preview_btn").prop('disabled', false); // Mass upload just for preview before save
                           myDropzone.removeFile(file);
                       }
                       else if(result.improper) {
                           console.log('Improper');
                           $(".print-error-msg").css('display','block');
                           $(".print-error-msg").find("ul").html('');
                           $.each( result.improper_name_html, function( key, value ) {
                               $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                           });
                       }
                       else if($.isEmptyObject(result.error)){
                           console.log('Validation error');
                           $(".print-error-msg").find("ul").html('');
                           $(".print-error-msg").css('display','none');
                       }   else {
                           console.log('Valid error');
                           $(".print-error-msg").find("ul").html('');
                           $(".print-error-msg").css('display','block');
                           $.each( result.error, function( key, value ) {
                               $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                           });
                           $("html, body").animate({ scrollTop: $('.print-error-msg').offset().top - 100 }, 50);

                           $("#mass_upload_save_btn").prop('disabled', true); // Mass upload save button in database
                           $("#mass_upload_preview_btn").prop('disabled', false); // Mass upload just for preview before save
                       }


                   });

                   this.on('completemultiple', function(file, json) {
                       //file.status = 'queued';
                   });


                   this.on("removedfile", function (file) {
                       _remove_file++;
                       console.log('added file : '+_remove_file);
                       update_image_area(myDropzone.files);
                       $("#mass_upload_save_btn").prop('disabled', true); // Mass upload save button in database
                       $("#mass_upload_preview_btn").prop('disabled', false); // Mass upload just for preview before save
                   });
                   this.on("addedfile", function(file) {
                       _add_file++;
                       console.log('added file : '+_add_file);
                       update_image_area( myDropzone.files);
                       $("#mass_upload_save_btn").prop('disabled', true); // Mass upload save button in database
                       $("#mass_upload_preview_btn").prop('disabled', false); // Mass upload just for preview before save
                   });
                }
            });


            // Create real product from temprory product

            $("#mass_upload_save_btn").click(function(event) {
                event.preventDefault();
                $('#loading').show();
                var tagIdsObject = {};
                var productNameObj = {};

                // Process each hidden input field
                $(".massu_tag_ids").each(function() {
                    var tag_sku = $(this).attr("data-sku");
                    var tag_val = $(this).val();
                    if(tag_val) {
                        tagIdsObject[tag_sku] = tag_val;
                    }
                });

                $(".mu_product_name").each(function() {
                    var product_sku = $(this).attr("data-sku");
                    var product_val = $(this).val();
                    if(product_val) {
                        productNameObj[product_sku] = product_val;
                    }
                });


                //console.log(tagIdsObject);return false;
                $.ajax({
                    url: "{{ route('create-product-from-mass-upload') }}",
                    method:"POST",
                    data:{
                        "_token": "{{csrf_token()}}",
                        "tag_ids": tagIdsObject,
                        "product_names": productNameObj,
                    },
                    dataType:'JSON',
                    success:function(result)
                    {
                        $(".print-error-msg").css('display','none');
                        $(".alert-success-div").hide();

                        if($.isEmptyObject(result.error)){
                            window.location.href = result.redirect_url;
                        } else {
                            $('#loading').hide();
                        }
                    }
                })
            });



            function update_image_area(files_array) {
                var mu_image_name = '';
                files_array.forEach(function (file) {
                    console.log(file.name);
                    mu_image_name += '<p>'+file.name+'<p>';
                });
                $('#mu_image_name').html(mu_image_name);
            }

        });
    </script>

@endpush
