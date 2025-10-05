<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/jquery-ui.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php
    use Illuminate\Support\Str;
?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Products</h3>
            </div>
            <div class="col-auto text-right">
                <a href="<?php echo e(route('customizer-processing-time')); ?>" class="btn btn-white add-buttosn ml-3"><i class="fa-solid fa-spinner"></i></a>
                <a href="<?php echo e(route('product-mass-upload')); ?>" class="btn btn-white add-buttosn ml-3">Upload multiple</a>
                <a href="<?php echo e(route('export-product')); ?>" class="btn btn-white add-buttosn ml-3">Export</a>
                <a class="btn btn-white removeAll ml-3"><i class="far  fa-trash-alt mr-1"></i></a>
                <a class="btn btn-white filter-btn ml-3" href="javascript:void(0);" id="filter_search">
                    <i class="fas fa-filter"></i>
                </a>
                <a href="<?php echo e(route('add-product')); ?>" class="btn btn-primary add-button ml-3">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
    </div>

    <?php

        $query_str = '';
        if(isset($_GET['artist_id']) AND !empty($_GET['artist_id'])) {
            $query_str .= '&artist_id='.$_GET['artist_id'];
        }

        if(isset($_GET['product_name']) AND !empty($_GET['product_name'])) {
            $query_str .= '&product_name='.$_GET['product_name'];
        }

        if(isset($_GET['product_sku']) AND !empty($_GET['product_sku'])) {
            $query_str .= '&product_sku='.$_GET['product_sku'];
        }

        $dir_pname = $dir_psku = $dir_artist = $dir_customer  = $dir_badge = $dir_theme = $dir_last_updated = 'asc';
        $pname_icon = $psku_icon =  $artist_icon = $customer_icon = $badge_icon = $theme_icon = $last_updated_icon = '<i class="fa-solid fa-sort"></i>';
        if(isset($_GET['sort_by']) AND $_GET['sort_by'] == 'order_by_pname') {
             $dir_pname = $_GET['order'] == 'desc' ? 'asc': 'desc';
             $pname_icon = $_GET['order'] == 'desc' ? '<i class="fa-solid fa-sort-down"></i>': '<i class="fa-solid fa-sort-up"></i>';
         }

         if(isset($_GET['sort_by']) AND $_GET['sort_by'] == 'order_by_psku') {
             $dir_psku = $_GET['order'] == 'desc' ? 'asc': 'desc';
             $psku_icon = $_GET['order'] == 'desc' ? '<i class="fa-solid fa-sort-down"></i>': '<i class="fa-solid fa-sort-up"></i>';
         }

         if(isset($_GET['sort_by']) AND $_GET['sort_by'] == 'order_by_artist') {
             $dir_artist = $_GET['order'] == 'desc' ? 'asc': 'desc';
             $artist_icon = $_GET['order'] == 'desc' ? '<i class="fa-solid fa-sort-down"></i>': '<i class="fa-solid fa-sort-up"></i>';
         }

         if(isset($_GET['sort_by']) AND $_GET['sort_by'] == 'order_by_customer') {
             $dir_customer = $_GET['order'] == 'desc' ? 'asc': 'desc';
             $customer_icon = $_GET['order'] == 'desc' ? '<i class="fa-solid fa-sort-down"></i>': '<i class="fa-solid fa-sort-up"></i>';
         }

        if(isset($_GET['sort_by']) AND $_GET['sort_by'] == 'order_by_badge') {
             $dir_badge = $_GET['order'] == 'desc' ? 'asc': 'desc';
             $badge_icon = $_GET['order'] == 'desc' ? '<i class="fa-solid fa-sort-down"></i>': '<i class="fa-solid fa-sort-up"></i>';
         }

        if(isset($_GET['sort_by']) AND $_GET['sort_by'] == 'order_by_theme') {
             $dir_theme = $_GET['order'] == 'desc' ? 'asc': 'desc';
             $theme_icon = $_GET['order'] == 'desc' ? '<i class="fa-solid fa-sort-down"></i>': '<i class="fa-solid fa-sort-up"></i>';
         }
        if(isset($_GET['sort_by']) AND $_GET['sort_by'] == 'order_by_last_updated') {
             $dir_last_updated = $_GET['order'] == 'desc' ? 'asc': 'desc';
             $last_updated_icon = $_GET['order'] == 'desc' ? '<i class="fa-solid fa-sort-down"></i>': '<i class="fa-solid fa-sort-up"></i>';
         }

    ?>

    <div class="card filter-card" id="filter_inputs" style="display: <?php echo e($filter_flag ? 'block' : ''); ?>">
        <div class="card-body pb-0">
            <form action="" method="get">
                <div class="row filter-row">

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>Arist</label>
                            <select class="form-control" name="artist_id">
                                <option value="">Select Artist</option>
                                <?php $__currentLoopData = $artists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $artist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($artist->id); ?>" <?php echo e((isset($_GET['artist_id']) AND $_GET['artist_id'] == $artist->id)   ? 'selected': ''); ?>>
                                        <?php echo e($artist->display_name ? $artist->display_name :   $artist->first_name.' '.$artist->last_name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>Customer Name</label>
                            <input class="form-control" type="text" name="" id="customer_name2" value="<?php echo e($customers->first_name ?? ''); ?> <?php echo e($customers->last_name ?? ''); ?>">
                            <input type="hidden" id="customer_id" name="customer_id" value="<?php echo e(isset($_GET['customer_id']) ? $_GET['customer_id']: ''); ?>">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>Product Name OR Display Name</label>
                            <input class="form-control" type="text" name="product_name" value="<?php echo e(isset($_GET['product_name']) ? $_GET['product_name']: ''); ?>">
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>Product SKU</label>
                            <input class="form-control" type="text" name="product_sku" value="<?php echo e(isset($_GET['product_sku']) ? $_GET['product_sku']: ''); ?>">
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Submit</button>
                            <a href="<?php echo e(route('products-listing')); ?>" class="btn btn-primary btn-block" style="line-height: 34px;">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0 table-fit" id="items">
                            <thead>
                            <tr>
                                <th></th>
                                <th><input type="checkbox" id="checkboxesMain" class=""></th>
                                <th><a href="<?php echo e(route('products-listing', ['sort_by' => 'order_by_pname', 'order' => $dir_pname]).$query_str); ?>"> Product <?php echo $pname_icon; ?></a></th>
                                <th><a href="<?php echo e(route('products-listing', ['sort_by' => 'order_by_psku', 'order' => $dir_psku]).$query_str); ?>">SKU <?php echo $psku_icon; ?></a></th>
                                <th>Featured image</th>
                                <th><a href="<?php echo e(route('products-listing', ['sort_by' => 'order_by_artist', 'order' => $dir_artist]).$query_str); ?>">Artist Display Name<?php echo $artist_icon; ?></a></th>
                                <th><a href="<?php echo e(route('products-listing', ['sort_by' => 'order_by_customer', 'order' => $dir_customer]).$query_str); ?>">Company Name <?php echo $customer_icon; ?></a></th>
                                <th><a href="<?php echo e(route('products-listing', ['sort_by' => 'order_by_badge', 'order' => $dir_badge]).$query_str); ?>">Badge <?php echo $badge_icon; ?></a></th>
                                <th><a href="<?php echo e(route('products-listing', ['sort_by' => 'order_by_theme', 'order' => $dir_theme]).$query_str); ?>">Style <?php echo $theme_icon; ?></a></th>
                                <th><a href="<?php echo e(route('products-listing', ['sort_by' => 'order_by_last_updated', 'order' => $dir_last_updated]).$query_str); ?>">Last Updated <?php echo $last_updated_icon; ?></a></th>
                                <th class="text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php if($products->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                     <?php
                                        $badgeText = $product->badge->badge ?? '';
                                        $shortenedBadgeText = Str::words($badgeText, 2, '...');

                                        $styleNameText = $product->style->style_name ?? '';
                                        $shortenedStyleNameText = Str::words($styleNameText, 2, '...');
                                     ?>
                                        <tr id="tr_<?php echo e($product->id); ?>">
                                            <td>
                                                <span class="numeric_number" style="color: #FF6600;font-weight: bold;"><?php echo e($index + $products->firstItem()); ?></span>
                                            </td>
                                            <td>
                                                <input type="checkbox" class="checkbox" data-id="<?php echo e($product->id); ?>">
                                            </td>
                                            <td><a href="<?php echo e(route('product-detail', ['slug' => $product->product_slug])); ?>" target="_blank" style="text-decoration: underline;"><?php echo $product->product_name; ?></a></td>
                                            <td><?php echo e($product->product_sku); ?></td>
                                            <td> <img class="avatar-img rounded" alt src="<?php echo e(url('uploads/products/small-'.$product->feature_image)); ?>" width="40%"></td>
                                            <td><?php echo e($product->artist->display_name ? $product->artist->display_name :   $product->artist->first_name.' '.$product->artist->last_name); ?></td>
                                            <td><?php echo e($product->customer->company ?? ''); ?></td>
                                            <td  title="<?php echo e($product->badge->badge ?? ''); ?>"><?php echo e($shortenedBadgeText); ?></td>
                                            <td  title="<?php echo e($product->style->style_name ?? ''); ?>"><?php echo e($shortenedStyleNameText); ?></td>
                                            <td><?php echo e($product->updated_at); ?></td>
                                            <td class="text-end">
                                                <a href="<?php echo e(route('edit-product',['id'=>$product->id])); ?>" class="btn btn-sm bg-success-light mr-1"> <i class="far fa-edit mr-1"></i> </a>

                                                <a href="<?php echo e(route('change-product-status',['id'=>base64_encode($product->id.":2")])); ?>"
                                                   class="btn btn-sm bg-danger-light mr-1 change_status"
                                                   title="Delete"
                                                   data-msg="Are you sure want to delete">
                                                    <i class="far  fa-trash-alt mr-1"></i>
                                                </a>
                                                <?php if($product->status == 0): ?>
                                                    <a href="<?php echo e(route('change-product-status',['id'=>base64_encode($product->id.":1")])); ?>"
                                                       class="btn btn-sm bg-success-light mr-1 change_status"
                                                       title="Activate"
                                                       data-msg="Are you sure want to activate">
                                                        <i class="fas fa-eye-slash"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?php echo e(route('change-product-status',['id'=>base64_encode($product->id.":0")])); ?>"
                                                       class="btn btn-sm bg-success-light mr-1 change_status"
                                                       title="Deactivate"
                                                       data-msg="Are you sure want to Deactivate">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <?php if($product->type == 2): ?>
                                                    <a href="<?php echo e(route('generate-pdf-customizer-product',['id'=>$product->id])); ?>"
                                                       class="btn btn-sm bg-success-light mr-1" target="_blank">
                                                        <i class="fa-solid fa-file-pdf"></i>
                                                    </a>
                                                    <a href="<?php echo e(url('uploads/products/'.$product->customer_uploaded_image)); ?>"
                                                       class="btn btn-sm bg-success-light mr-1" target="_blank">
                                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                    </a>
                                                <?php endif; ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7">Record not found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>
                    <?php echo e($products->withQueryString()->links('pagination.custom')); ?>

                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/jquery-ui.min.js')); ?>"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        //-----------------------------------------------------------------------------------------

        $('#checkboxesMain').on('click', function(e) {
            if ($(this).is(':checked', true)) {
                $(".checkbox").prop('checked', true);
            } else {
                $(".checkbox").prop('checked', false);
            }
        });

        //------------------------------------------------------------------------------------------

        $('.checkbox').on('click', function() {
            if ($('.checkbox:checked').length == $('.checkbox').length) {
                $('#checkboxesMain').prop('checked', true);
            } else {
                $('#checkboxesMain').prop('checked', false);
            }
        });

        //-----------------------------------------------------------------------------------------

        $('.removeAll').on('click', function(e) {
            var productIdArr = [];
            $(".checkbox:checked").each(function() {
                productIdArr.push($(this).attr('data-id'));
            });
            if (productIdArr.length <= 0) {
                alert("Choose min one item to remove.");
            } else {
                if (confirm("Are you sure?")) {
                    var productId = productIdArr.join(",");
                    $.ajax({
                        url: "<?php echo e(route('delete-bluk-product')); ?>",
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: 'ids=' + productId,
                        success: function(data) {
                            if (data['status'] == true) {
                                $(".checkbox:checked").each(function() {
                                    $(this).parents("tr").remove();
                                });
                                alert(data['message']);
                            } else {
                                alert('Error occured.');
                            }
                        },
                        error: function(data) {
                            alert(data.responseText);
                        }
                    });
                }
            }
        });

        //--------------------------------------------------------------------------------------------------


    });

        $( function() {

            $('#customer_name2').autocomplete({
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
                    $('#customer_name2').val(ui.item.label); // Assign label to customer_name input
                    $('#customer_id').val(ui.item.customer_id); // Assign value to customer_id input
                }
            });

        } );
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/admin/products/listing.blade.php ENDPATH**/ ?>