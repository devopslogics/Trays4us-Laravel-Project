@extends('layouts.admin.dashboard')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dropzone.css') }}">
    <link rel="stylesheet" href="{{asset('assets/css/tags.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.min.css')}}">
    <style>
       .sortable {
            padding: 0;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .sortable li {
            float: left;
            overflow:hidden;
            border:1px solid red;
            text-align: center;
            margin:5px;
            list-style: none;
        }
        li.sortable-placeholder {
            border: 1px dashed #CCC;
            background: none;
        }
        #add_product_form .dropzoneDragArea {
    padding: 60px 0px 60px 0px;
}
    </style>
@endpush

@section('content')
   <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Add Product</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('add-product-submitted') }}" method="post" enctype="multipart/form-data" name="add_product" id="add_product_form" class="add_product dropzone">
                        {{ csrf_field() }}

                        <input type="hidden" class="student_id" name="product_id" id="product_id" value="">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Product Name</label>
                                    <input type="text" class="form-control" name="product_name" value="{!! old('product_name') !!}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>SKU</label>
                                    <input type="text" class="form-control"  name="product_sku" value="{{old('product_sku')}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Parent Product type</label>
                                    <select class="form-control" name="parent_product_type" id="parent_product_type">
                                        <option value="">Select Parent Type</option>
                                        @foreach($parent_product_types as $parent_product_type)
                                            <option value="{{$parent_product_type->id}}" {{ old('parent_product_type') == $parent_product_type->id ? 'selected' : ''}}>{{$parent_product_type->type_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" class="form-control" name="price" value="{{old('price')}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sub Product Type</label>
                                    <select class="form-control" name="sub_product_type" id="sub_product_type">
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Case Pack</label>
                                    <input type="text" class="form-control" name="case_pack" id="case_pack" value="{{old('case_pack')}}" readonly>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Minimums</label>
                                    <select class="form-control" name="design_type" id="product_customizable">
                                        <option  value="">Select Minimum</option>
                                        @foreach($customizables as $customizable)
                                            <option value="{{$customizable->id}}" {{ old('product_customizable', $customizable->defulat == 1) == $customizable->id ? 'selected' : ''}}>{{$customizable->customizable_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>MOQ(Minimum Order Quantity)</label>
                                    <input type="text" class="form-control" name="minimum_order_quantity" id="minimum_order_quantity" value="{{ old('minimum_order_quantity')}}" readonly>
                                </div>
                            </div>

                            <div class="col-md-6 align-self-center">
                                <div class="form-group">
                                    <label>Badge</label>
                                    <select class="form-control" name="badge" id="badge">
                                        <option value="">Select Badge</option>
                                        @foreach($badges as $badge)
                                            <option value="{{$badge->id}}" data-custom="{{ $badge->custom }}" {{ old('badge') == $badge->id ? 'selected' : ''}}>{{$badge->badge}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Artist</label>
                                    <select class="form-control" name="artist_id">
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
                                <div class="form-group tag_wrapper">
                                    <label>Tags</label>
                                    <input type="hidden" name="tag_ids" id="tag_ids" class="tag-ids"  value="{{ old('tag_ids') }}">

                                    <div class="tags-input">
                                        <div class="myTags" id="">
                                            <span class="data">
                                                <?php /*
                                                <span class="tag"><span class="text" _value="Nairobi 047">jQuery</span><span class="close">&times;</span></span>
                                                <span class="tag"><span class="text" _value="24">Script</span><span class="close">&times;</span></span>
                                                */ ?>
                                            </span>

                                            <span class="autocomplete">
                                                <input type="text">
                                                <div class="autocomplete-items">
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Style</label>
                                    <select class="form-control" name="style_id">
                                        <option value="">Select Style</option>
                                        @foreach($themes as $theme)
                                            <option value="{{$theme->id}}" {{ old('style_id') == $theme->id ? 'selected' : ''}}>{{$theme->style_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select class="form-control" name="country_id" id="country_id">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}" {{ old('country_id') == $country->id ? 'selected' : ''}}>{{$country->country_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <select class="form-control" name="state_id" id="state_id">
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" id="custom_editor" rows="4" cols="50">{{old('description')}}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Product Gallery</label>
                                    <div id="dropzoneDragArea" class="dz-default dz-message dropzoneDragArea">
                                        <span class="dz-default dz-message">Drop files here or click to upload (600x600)</span>
                                        <div class="dropzone-previews"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="text-end"> <button type="submit" class="btn btn-primary">Submit</button>

                            <a href="{{ route('products-listing') }}" class="btn btn-link">Cancel</a>
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
    <script src="{{asset('assets/js/tags.js')}}"></script>
    <script src="{{ asset('assets/js/dropzone.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script>
        $(document).ready(function () {

            //-------------------------------------- Get sub category by parent id   ----------------------

            $('#parent_product_type').change(function () {
                var parentId = $(this).val();
                if (parentId) {
                    get_sub_product_type_by_id(parentId);
                } else {
                    $('#sub_product_type').empty().hide();
                }
            });

            //----------------------------- Get state by country id on change event -----------------------

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

            //---------------------------------------------------------------------------------------------

            $('#badge').change(function () {
                var custom = $('#badge option:selected').attr('data-custom');
                $('#customer_only').css("display", "none");
                $("#customer_id").val('');
                $("#customer_name").val('');
                if(custom > 0) {
                    $('#customer_only').css("display", "block");
                }
            });

            //---------------------------------------------------------------------------------------------

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

            //---------------------------------------------------------------------------------------------

            $(document).on("change","#sub_product_type",function() {
                var type_id = $(this).val();
                $.ajax({
                    url: "{{ route('get-case-pack-by-types') }}",
                    type: 'GET',
                    data: { type_id: type_id},
                    dataType: 'json',
                    success: function (data) {

                        /*
                        $('#minimum_order_quantity').val('');
                        if(data.minimum_order_quantity && data.minimum_order_quantity > 0) {
                            $('#minimum_order_quantity').val(data.minimum_order_quantity);
                        } */

                        $('#case_pack').val('');
                        if(data.case_pack && data.case_pack > 0) {
                            $('#case_pack').val(data.case_pack);
                        }
                        get_minimam_order_quantity_by_design();
                    }
                });
            });

            //-----------------------------------------------On page load ---------------------------------

           // get_minimam_order_quantity_by_design();

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

            //-------------------------------------------------------------------------------------------------

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
                paramName: "product_gallery",
                url: "{{ route('store-product-gallery') }}",
                previewsContainer: '.dropzone-previews',
               // previewTemplate : $('.preview').html(),
                dictDefaultMessage: "Drop files here or click to upload (600x600)",
                addRemoveLinks: true,
                autoProcessQueue: false,
               // maxFilesize: 2,
                parallelUploads: 100,
                uploadMultiple: true,
                acceptedFiles: "image/*",
                maxFiles: 10,
                params: {
                    _token: token
                },
                init: function() {
                    var myDropzone = this;
                    $("#add_product_form").submit(function(event) {
                        event.preventDefault();
                        URL = $("#add_product_form").attr('action');
                        _this = $(this);
                        $('#loading').show();
                        $.ajax({
                            url:$("#add_product_form").attr('action'),
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
                                    var product_id = result.product_id;
                                    $("#product_id").val(product_id);
                                    myDropzone.processQueue();
                                    //alert('hihi');
                                    //console.log(result);
                                   // if(_add_file <= _remove_file) {
                                        $('#loading').hide();
                                        //window.location.href = result.redirect_url;
                                   // }
                                    /*
                                    $(".alert-success-div").show();
                                    // console.log(data.message)
                                    $(".alert-success-div strong").text(result.message);
                                    $("html, body").animate({ scrollTop: $('.alert-success-div').offset().top - 100 }, 500);
                                    $('#add_product_form')[0].reset();
                                    $('#myTags .data').html();
                                    */
                                } else {
                                    $('#loading').hide();
                                    $(".print-error-msg").find("ul").html('');
                                    $(".print-error-msg").css('display','block');
                                    $.each( result.error, function( key, value ) {
                                        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                                    });
                                    $("html, body").animate({ scrollTop: $('.print-error-msg').offset().top - 100 }, 500);
                                }
                               // $('#loading').hide();
                            }
                        })
                    });

                    this.on('sending', function(file, xhr, formData){
                        let product_id = document.getElementById('product_id').value;
                        formData.append('product_id', product_id);
                        formData.append('add_gallery', 1);
                    });


                    this.on("success", function (file, response) {
                       // alert("Student added successfully!!");
                        //location.reload();
                        //this.removeAllFiles(true);
                        console.log(response);
                        $('#loading').hide();
                        window.location.href = response.redirect_url;
                        //$('#add_product_form')[0].reset();
                    });

                    this.on('completemultiple', function(file, json) {
                         //$('.sortable').sortable('enable');
                    });


                    this.on("removedfile", function (file) {
                        _remove_file++;
                        console.log('added file : '+_remove_file);
                    });

                    this.on("addedfile", function(file) {
                        _add_file++;
                        console.log('added file : '+_add_file);

                    });
                }
            });

            $('.dropzone').sortable({
                items: '.dz-preview',
                cursor: 'move',
                opacity: 0.5,
                containment: '.dropzone',
                distance: 20,
                tolerance: 'pointer',
                stop: function () {
                    var queue = myDropzone.files;
                    var newQueue = [];
                    $('.dropzone .dz-preview .dz-filename [data-dz-name]').each(function (count, el) {
                        var name = el.innerHTML;
                        queue.forEach(function (file) {
                            if (file.name === name) {
                                newQueue.push(file);
                            }
                        });
                    });
                    myDropzone.files = newQueue;
                }
            });

        });
    </script>

@endpush
