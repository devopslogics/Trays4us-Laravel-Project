<style>
    .tfu_parent_type {
        margin: 0px 0px 0px 15px;
    }
    .tfu_customizable_name {
        padding: 0px 5px;
        margin: 16px 0px;
    }
    .row.tfu-type_inner {
        margin: 10px 0px 0px 16px;
    }
</style>
<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Design Types</h3>
            </div>
            <div class="col-auto text-right">
                <a href="<?php echo e(route('add-product-customizable')); ?>" class="btn btn-primary add-button ml-3">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-xl-4">
                            Design Type
                        </div>
                        <div class="col-xl-4">
                            MOQ(Minimum Order Quantity)
                        </div>
                        <div class="col-xl-4">
                            Action
                        </div>
                    </div>
                        <?php if($customizables->isNotEmpty()): ?>
                            <?php $__currentLoopData = $customizables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customizable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row">
                                <form action="<?php echo e(route('save-customizable-type-relation')); ?>" method="post" enctype="multipart/form-data" class="add_customizable_design d-flex">
                                    <?php echo e(csrf_field()); ?>

                                    <div class="col-xl-6">
                                        <div class="tfu_customizable_name">
                                            <input class="form-control" name="product_customizable" class="tfu_minimum_order_quantity" value="<?php echo e($customizable->customizable_name); ?>">
                                        </div>
                                        <div class="row tfu_product_types">
                                            <?php $__currentLoopData = $product_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-xl-12 tfu_parent_type"><b><?php echo e($product_type->type_name); ?></b></div>
                                                <div class="row tfu-type_inner">
                                                    <?php $__currentLoopData = $product_type->childTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="col-xl-7 tfu_child_type">
                                                            <p><?php echo e($child_type->type_name); ?></p>
                                                        </div>
                                                        <div class="col-xl-4 d-flex justify-content-end g-2">
                                                            <?php

                                                                $minimumOrderQuantity = $customizable->customizableTypeRelations()
                                                                    ->where('product_type_id', $child_type->id)
                                                                    ->where('product_customizable_id', $customizable->id)
                                                                    ->value('minimum_order_quantity');
                                                            ?>
                                                            <input class="form-control" name="minimum_order_quantity[<?php echo e($customizable->id); ?>][<?php echo e($child_type->id); ?>]" class="tfu_minimum_order_quantity" value="<?php echo e($minimumOrderQuantity); ?>" style="width: 100px">
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="text-center">
                                            <button type="button" class="btn btn-primary tfu_customizable_design_btn">Submit</button>
                                            <a href="" class="btn btn-link">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>


                    <?php /*<div class="table-responsive">
                        <table class="table table-hover table-center mb-0" id="items">
                            <thead>
                            <tr>
                                <th>Design Type</th>
                                <th>Date</th>
                                <th class="text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if ($customizables->isNotEmpty())
                                    @foreach($customizables as $customizable)
                                        <tr>
                                            <td>{{$customizable->customizable_name}}</td>
                                            <td>{{$customizable->created_at}}</td>

                                            <td class="text-end">
                                                <a href="{{ route('edit-product-customizable',['id'=>$customizable->id]) }}" class="btn btn-sm bg-success-light mr-1 edit_cat"> <i class="far fa-edit mr-1"></i> </a>

                                                <a href="{{ route('change-product-customizable-status',['id'=>base64_encode($customizable->id.":2")]) }}"
                                                   class="btn btn-sm bg-danger-light mr-1 change_status"
                                                   title="Delete"
                                                   data-msg="Are you sure want to delete">
                                                    <i class="far  fa-trash-alt mr-1"></i>
                                                </a>
                                                @if($customizable->status == 0)
                                                    <a href="{{ route('change-product-customizable-status',['id'=>base64_encode($customizable->id.":1")]) }}"
                                                       class="btn btn-sm bg-success-light mr-1 change_status"
                                                       title="Activate"
                                                       data-msg="Are you sure want to activate">
                                                        <i class="fas fa-eye-slash"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('change-product-customizable-status',['id'=>base64_encode($customizable->id.":0")]) }}"
                                                       class="btn btn-sm bg-success-light mr-1 change_status"
                                                       title="Deactivate"
                                                       data-msg="Are you sure want to Deactivate">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">Record not found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                    </div> */ ?>

                    <?php echo e($customizables->links('pagination.custom')); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>

    <script type="text/javascript">
    $(document).ready(function() {

        $(".tfu_customizable_design_btn").click(function(event) {
            event.preventDefault();
            _this = $(this);
            URL = $(this).closest('.add_customizable_design').attr('action');
            var formData = new FormData(_this.closest('.add_customizable_design')[0]);
            //formData.append('product_customizable', 'newValue');
            $('#loading').show();
            $.ajax({
                url:URL,
                method:"POST",
                data: formData,
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(result)
                {
                    Swal.fire(
                        'Design Type',
                        result.message,
                        'success'
                    );
                    $('#loading').hide();
                }
            })
        });

    });
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/admin/product-customizable/listing.blade.php ENDPATH**/ ?>