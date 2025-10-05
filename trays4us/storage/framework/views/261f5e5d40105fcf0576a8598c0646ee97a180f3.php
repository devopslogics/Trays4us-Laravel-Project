<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/tags.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/jquery-ui.min.css')); ?>">
    <style>
        .products-container {
            display: flex;
            flex-wrap: wrap;
            padding: 5px;
            border: 1px solid #ccc;
        }
        .product-item {
            background-color: #e0e0e0;
            padding: 5px 10px;
            margin: 2px;
            border-radius: 4px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Bulk Tag Manager</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <form action="<?php echo e(route('bulk-tag-manager-submitted')); ?>" method="post" enctype="multipart/form-data" name="add_product" id="add_product_form" class="add_product">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="selected_products" id="selected-products">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Artist</label>
                                    <select class="form-control" name="artist_id">
                                        <option  value="">Select  Artist</option>
                                        <?php $__currentLoopData = $artists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $artist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $artist_name = $artist->first_name.' '.$artist->last_name;
                                                if($artist->display_name)
                                                   $artist_name = $artist->display_name;
                                            ?>
                                            <option value="<?php echo e($artist->id); ?>" <?php echo e(old('artist_id') == $artist->id ? 'selected' : ''); ?>><?php echo e($artist_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group tag_wrapper">
                                    <label>Tags</label>
                                    <input type="hidden" name="tag_ids" id="tag_ids" class="tag-ids"  value="<?php echo e(old('tag_ids')); ?>">

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
                                    <label>Product OR SKU</label>
                                    <div class="products-container" id="products-container">
                                        <input type="text" id="product-input" class="form-control" placeholder="Type product name or SKU...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>
                        <div class="text-end"> <button type="submit" class="btn btn-primary">Submit</button>

                            <a href="<?php echo e(route('products')); ?>" class="btn btn-link">Cancel</a>
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

    <script src="<?php echo e(asset('assets/js/jquery-ui.min.js')); ?>"></script>
    <script>

        $(document).ready(function () {
            let selectedProducts = [];

            // Initialize jQuery UI Autocomplete
            $("#product-input").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo e(route('get-products-by-autocomplete')); ?>",  // Replace with your actual server endpoint
                        type: "GET",
                        dataType: "json",
                        data: {
                            query: request.term,
                            selected_product_ids: selectedProducts  // Pass the selected product IDs to the server
                        },
                        success: function (data) {
                            response(data.result);  // Send the filtered data back to jQuery UI for autocomplete
                        }
                    });
                },
                minLength: 2,  // Minimum characters to start search
                select: function (event, ui) {
                    // Prevent the input from being added directly
                    event.preventDefault();

                    // Add selected product to products container if not already selected
                    if (!selectedProducts.includes(ui.item.product_id)) {
                        selectedProducts.push(ui.item.product_id);
                        addProduct(ui.item.label, ui.item.product_id);
                        updateHiddenInput(); // Update the hidden input field
                    }

                    // Clear the input after selection
                    $("#product-input").val('');
                }
            });

            // Add product to the container
            function addProduct(name, productId) {
                let productItem = $('<span class="product-item"></span>').text(name);
                let removeBtn = $('<span>&times;</span>').css({ marginLeft: '5px', cursor: 'pointer' });

                // Remove product on click
                removeBtn.on('click', function () {
                    selectedProducts = selectedProducts.filter(item => item !== productId);
                    productItem.remove();
                    updateHiddenInput(); // Update the hidden input field after removal
                });

                productItem.append(removeBtn);
                $("#products-container").prepend(productItem);
            }

            // Update the hidden input field with selected product IDs
            function updateHiddenInput() {
                $("#selected-products").val(selectedProducts.join(','));  // Join product IDs with commas
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

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/admin/product-tags/bulk-tag-manager.blade.php ENDPATH**/ ?>