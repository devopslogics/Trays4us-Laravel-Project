<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/dropzone.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/tags.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/jquery-ui.min.css')); ?>">
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
        .dropzoneDragArea {background-color: #fbfdff;border: 1px dashed #c0ccda;border-radius: 6px;padding: 60px;text-align: center;margin-bottom: 15px;cursor: pointer;}
        .dropzone .dz-preview .dz-image img {width: 120px;}
    </style>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Edit Product</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <?php
                        if(isset($product->product_customizable) AND isset($product_price->pt_sub_id))
                            $moq_case_pack  = \App\Models\Helper::get_moq_case_pack($product->product_customizable,$product_price->pt_sub_id);
                    ?>
                    <form action="<?php echo e(route('edit-product-submitted')); ?>" method="post" enctype="multipart/form-data" name="add_product" id="add_product_form" class="add_product dropzone">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>" id="product_id">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Product Name</label>
                                    <input type="text" class="form-control" name="product_name" value="<?php echo $product->product_name; ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>SKU</label>
                                    <input type="text" class="form-control"  name="product_sku" value="<?php echo e($product->product_sku); ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Parent Product type</label>
                                    <select class="form-control" name="parent_product_type" id="parent_product_type">
                                        <option  value="">Select Parent type</option>
                                        <?php $__currentLoopData = $parent_product_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent_product_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($parent_product_type->id); ?>" <?php echo e($product_price->pt_parent_id == $parent_product_type->id ? 'selected' : ''); ?>><?php echo e($parent_product_type->type_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" class="form-control" name="price" value="<?php echo e($product_price->price); ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sub Product type</label>
                                    <select class="form-control" name="sub_product_type" id="sub_product_type">
                                        <?php $__currentLoopData = $sub_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($sub_type->id); ?>" <?php echo e($product_price->pt_sub_id == $sub_type->id ? 'selected' : ''); ?>><?php echo e($sub_type->type_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Case Pack</label>
                                    <input type="text" class="form-control" name="case_pack" id="case_pack" value="<?php echo e($moq_case_pack->case_pack ?? 0); ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Minimums</label>
                                    <select class="form-control" name="design_type" id="product_customizable">
                                        <option  value="">Select Minimums</option>
                                        <?php $__currentLoopData = $customizables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customizable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($customizable->id); ?>" <?php echo e($product->product_customizable == $customizable->id ? 'selected' : ''); ?>><?php echo e($customizable->customizable_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>MOQ(Minimum Order Quantity)</label>
                                    <input type="text" class="form-control" name="minimum_order_quantity" id="minimum_order_quantity" value="<?php echo e($moq_case_pack->minimum_order_quantity ?? 0); ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-6 align-self-center">
                                <div class="form-group">
                                    <label>Badge</label>
                                    <select class="form-control" name="badge" id="badge">
                                        <option value="">Select Badge</option>
                                        <?php $__currentLoopData = $badges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $badge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($badge->id); ?>" data-custom="<?php echo e($badge->custom); ?>" <?php echo e($product->p_badge == $badge->id ? 'selected' : ''); ?>><?php echo e($badge->badge); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Artist</label>
                                    <select class="form-control" name="artist_id">
                                        <option value="">Select  Artist</option>
                                        <?php $__currentLoopData = $artists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $artist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $artist_name = $artist->first_name.' '.$artist->last_name;
                                                if($artist->display_name)
                                                   $artist_name = $artist->display_name;
                                            ?>
                                            <option value="<?php echo e($artist->id); ?>" <?php echo e($product->artist_id == $artist->id ? 'selected' : ''); ?>><?php echo e($artist_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group" id="customer_only" style="display: <?php echo e($product->customer_id > 0 ? 'block' : 'none'); ?>">
                                    <label>Visible to customer only</label>

                                    <?php /*
                                    <select class="form-control" name="customer_id" id="customer_id">
                                        <option  value="">Select  Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{$customer->id}}" {{ $customer->id == $product->customer_id ? 'selected' : ''}}>{{$customer->first_name}} {{$customer->last_name}}</option>
                                        @endforeach
                                    </select> */ ?>

                                    <input class="form-control" type="text" name="customer_name" id="customer_name" value="<?php echo e($product->customer->company ?? ''); ?> ( <?php echo e($product->customer_id ?? ''); ?> )">
                                    <input type="hidden" id="customer_id" name="customer_id" value="<?php echo e((isset($product->customer_id) && $product->customer_id > 0) ? $product->customer_id : ''); ?>">
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group tag_wrapper">
                                    <label>Tags</label>
                                    <input type="hidden" name="tag_ids" id="tag_ids" class="tag-ids"  value="<?php echo e(collect($productTagIds)->join(', ')); ?>">
                                    <?php /*
                                    <select class="form-control chzn-select" multiple="true" id="tags" name="tags">
                                        @if($tags)
                                            @foreach($tags as $tag)
                                                <?php
                                                $selected = '';
                                                if ($productTagIds->contains($tag->id))
                                                    $selected = 'selected';
                                                ?>
                                                <option value="{{$tag->id}}" {{$selected}}>{{$tag->tag_name}} </option>
                                            @endforeach
                                        @endif
                                    </select> */ ?>
                                    <div class="tags-input">
                                        <div class="myTags" id="">
                                            <span class="data">
                                                <?php if($product->tags): ?>
                                                    <?php $__currentLoopData = $product->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag_row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span class="tag"><span class="text" _value="<?php echo e($tag_row->id); ?>"><?php echo e($tag_row->tag_name); ?></span><span class="close">&times;</span></span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
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
                                        <option  value="">Select Style</option>
                                        <?php $__currentLoopData = $themes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $theme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($theme->id); ?>" <?php echo e($product->style_id == $theme->id ? 'selected' : ''); ?>><?php echo e($theme->style_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select class="form-control" name="country_id" id="country_id">
                                        <option  value="">Select Country</option>
                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($country->id); ?>" <?php echo e($product->country_id == $country->id ? 'selected' : ''); ?>><?php echo e($country->country_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <select class="form-control" name="state_id" id="state_id">
                                        <option value="">Select State</option>
                                        <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($state->id); ?>" <?php echo e($state->id == $product->state_id ? 'selected' : ''); ?>><?php echo e($state->state_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" id="custom_editor" rows="4" cols="50"><?php echo e($product->product_description); ?></textarea>
                                </div>
                            </div>
                            <?php /*
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Product Gallery</label>
                                    <input type="file" class="form-control" name="product_gallery[]" multiple>
                                </div>
                            </div>

                            <div class="row">
                                @if ($product->images->isNotEmpty())
                                    @foreach($product->images as $single_img)
                                        <div class="col-md-1 mr-2">
                                            <img class="" alt src="{{ url('uploads/products/'.$single_img->image_name) }}" width="80px">
                                        </div>
                                    @endforeach
                                @endif
                            </div> */ ?>

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
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="<?php echo e(route('products-listing')); ?>" class="btn btn-link">Cancel</a>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/tags.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/dropzone.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jquery-ui.min.js')); ?>"></script>
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

            $('#country_id').change(function () {
                var country_id = $(this).val();
                if (country_id) {
                    get_state_by_country_id(country_id);
                } else {
                    $('#state_id').empty().hide();
                }
            });

            //-----------------------------------------------------------------------------------------

            $(document).on("change","#sub_product_type",function() {
                var type_id = $(this).val();
                $.ajax({
                    url: "<?php echo e(route('get-case-pack-by-types')); ?>",
                    type: 'GET',
                    data: { type_id: type_id},
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

            //-----------------------------------------------On page load -----------------------------------------

            $(document).on("change","#product_customizable",function() {
                get_minimam_order_quantity_by_design();
            });

            //------------------------------------------------------------------------------------------------------

            $('#customer_name').autocomplete({
                minLength: 3,
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo e(route('customer-autocomplete')); ?>",
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

            $('#badge').change(function () {
                var custom = $('#badge option:selected').attr('data-custom');
                $('#customer_only').css("display", "none");
                $("#customer_id").val('');
                $("#customer_name").val('');
                if(custom > 0) {
                    $('#customer_only').css("display", "block");
                }
            });

            //------------------------------------------------------------------------------------------------------

            function get_minimam_order_quantity_by_design() {
                var type_id = $('#sub_product_type').val();
                var customizable_id = $('#product_customizable').val();
                $.ajax({
                    url: "<?php echo e(route('get-minimum-order-quantity-by-design')); ?>",
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
                    url: "<?php echo e(route('get-sub-product-type-by-id')); ?>",
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

            //-----------------------------------------------------------------------------------------

            function get_state_by_country_id(country_id) {
                $.ajax({
                    url: "<?php echo e(route('get-state-by-country-id')); ?>",
                    type: 'GET',
                    data: { country_id: country_id },
                    dataType: 'json',
                    success: function (data) {
                        $('#state_id').empty().show();
                        $('#state_id').append('<option value="">Select State</option>');
                        $.each(data, function (key, value) {
                            $('#state_id').append('<option value="' + value.id + '">' + value.state_name + '</option>');
                        });
                    }
                });
            }
        });

        function runSuggestions(element,query) {
            let sug_area=$(element).parents().eq(2).find('.autocomplete .autocomplete-items');
            $.getJSON( "<?php echo e(route('get-autocomplete-product-tag')); ?>?tag="+query, function( data ) {
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
        var gallery_images = <?php echo json_encode($product_gallery); ?>; // Remove the quotes around the JSON
        var _add_file = _remove_file = 0;
        var is_sortable = false;
        Dropzone.autoDiscover = false;
        var gallery_sortable = [];
        // Dropzone.options.demoform = false;
        let token = $('[name="_token"]').val();
        $(function() {
            var myDropzone = new Dropzone("div#dropzoneDragArea", {
                paramName: "product_gallery",
                url: "<?php echo e(route('store-product-gallery')); ?>",
                previewsContainer: 'div.dropzone-previews',
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
                    <?php $__currentLoopData = $product_gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    var mockFile = { name: "<?php echo e($image['name']); ?>", size: 12345, url : "<?php echo e($image['url']); ?>" , id : "<?php echo e($image['id']); ?>" }; // You might need to adjust the size
                    myDropzone.emit("addedfile", mockFile);
                    myDropzone.emit("addFile", mockFile);
                    myDropzone.emit("thumbnail", mockFile, "<?php echo e($image['url']); ?>");

                   // myDropzone.addFile(mockFile);
                  //  myDropzone.createThumbnailFromUrl(file, "<?php echo e($image['url']); ?>");
                    myDropzone.files.push(mockFile);
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    $("#add_product_form").submit(function(event) {
                        event.preventDefault();
                        $(this).find(':submit').attr('disabled','disabled');
                        $('#loading').show();
                        URL = $("#add_product_form").attr('action');
                        var formData = new FormData(this);
                        //alert(gallery_sortable.length);
                       // alert(is_sortable);
                        if (gallery_sortable.length > 0 && is_sortable && _add_file <= _remove_file) {
                           // alert();
                            formData.append('sort_gallery', JSON.stringify(gallery_sortable));
                        }
                        _this = $(this);
                        $.ajax({
                            url:$("#add_product_form").attr('action'),
                            method:"POST",
                            data: formData,
                            dataType:'JSON',
                            contentType: false,
                            cache: false,
                            processData: false,
                            success:function(result)
                            {
                                $(".print-error-msg").css('display','none');
                                $(".alert-success-div").hide();
                                if($.isEmptyObject(result.error)){

                                    myDropzone.processQueue();

                                    //if(_add_file <= _remove_file) {
                                        $('#loading').hide();
                                        window.location.href = result.redirect_url;
                                    //}

                                } else {
                                    _this.find(':submit').attr('disabled',false);
                                    $(".print-error-msg").find("ul").html('');
                                    $(".print-error-msg").css('display','block');
                                    $.each( result.error, function( key, value ) {
                                        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                                    });
                                    $("html, body").animate({ scrollTop: $('.print-error-msg').offset().top - 100 }, 500);
                                }
                                $('#loading').hide();
                            }
                        })
                    });

                    this.on('sending', function(file, xhr, formData){
                        let product_id = document.getElementById('product_id').value;
                        formData.append('product_id', product_id);
                        formData.append('update', product_id);
                        if (gallery_sortable.length > 0) {
                            formData.append('sort_gallery', JSON.stringify(gallery_sortable));
                        }
                        formData.append('edit_gallery', 1);
                       // alert('ccccccccc');
                    });
                    this.on("success", function (file, response) {
                        // alert("Student added successfully!!");
                        //location.reload();
                        //this.removeAllFiles(true);
                        //$('#add_product_form')[0].reset();
                        //alert('bbbbbbbb');
                        //console.log(response);
                        $('#loading').hide();
                        window.location.href = response.redirect_url;
                    });
                    this.on("queuecomplete", function () {

                    });
                    this.on("removedfile", function (file) {
                        console.log(file);
                        if (file.url && file.url.trim().length > 0) {
                            $.ajax({
                                url: "<?php echo e(route('delete-product-image')); ?>",
                                type: 'GET',
                                data: { id: file.id },
                                dataType: 'json',
                                success: function (data) {
                                }
                            });
                        } else {
                            _remove_file++;
                        }
                        console.log('removed file : '+_remove_file);
                    });

                    this.on("addedfile", function(file) {
                        _add_file++;
                        console.log('added file : '+_add_file);
                        if (file.previewElement.classList.contains('existing-image')) {
                            file.previewElement.addEventListener("click", function () {
                                myDropzone.removeFile(file);
                            });
                        }
                    });

                }
            });

            /*
            $.each(gallery_images, function(key,value){
                var mockFile = { name: value.name, size: 2345 , url : value.url , id : value.id  };
                myDropzone.options.addedfile.call(myDropzone, mockFile);
                myDropzone.options.thumbnail.call(myDropzone, mockFile, value.url);
            }); */


            $('.dropzone').sortable({
                items: '.dz-preview',
                cursor: 'move',
                opacity: 0.5,
                containment: '.dropzone',
                distance: 20,
                tolerance: 'pointer',
                stop: function () {
                    var queue = myDropzone.files;
                    var newQueue =   [];
                    gallery_sortable = [];
                    //-------------------------------------------------------------------------------------

                    $('.dropzone .dz-preview .dz-filename [data-dz-name]').each(function (count, el) {
                        var name = el.innerHTML;
                        queue.forEach(function (file) {
                            if (file.name === name) {
                                newQueue.push(file);
                            }
                        });
                    });
                    //-------------------------------------------------------------------------------------

                    is_sortable = true;
                    var counter = 1;

                    newQueue.forEach(function (file) {
                        file_id = file.id;
                        if (file.id == undefined) {
                            file_id = 'new_'+counter;
                            counter++;

                        }
                        //gallery_sortable[file_id] =  file.name;
                        gallery_sortable.push({ id: file_id, name: file.name });
                    });

                    //-------------------------------------------------------------------------------------
                    myDropzone.files = newQueue;
                    console.log(newQueue);
                    console.log(gallery_sortable);
                }
            });

        });
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/admin/products/edit.blade.php ENDPATH**/ ?>