<?php $__env->startSection('content'); ?>

    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Product Types</h3>
            </div>
            <div class="col-auto text-right">
                <a href="<?php echo e(route('add-product-type')); ?>" class="btn btn-primary add-button ml-3">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0" id="items">
                            <thead>
                            <tr>
                                <th>Product Type Name</th>
                                <th>Parent</th>
                                <?php /*<th>Description</th> */ ?>
                                <?php /* <th>Date</th> */ ?>
                                <th>Case Pack</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php if($product_types->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $product_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <tr>
                                                <td><b><?php echo e($product_type->type_name); ?></b></td>
                                                <td>-</td>
                                                <td></td>
                                                <td class="text-center">
                                                    <a href="<?php echo e(route('edit-product-type',['id'=>$product_type->id])); ?>" class="btn btn-sm bg-success-light mr-1 edit_cat"> <i class="far fa-edit mr-1"></i> </a>

                                                    <a href="<?php echo e(route('change-product-type-status',['id'=>base64_encode($product_type->id.":2")])); ?>"
                                                       class="btn btn-sm bg-danger-light mr-1"
                                                       title="Delete"
                                                       data-msg="Are you sure want to delete">
                                                        <i class="far fa-trash-alt mr-1"></i>
                                                    </a>
                                                    <?php if($product_type->status == 0): ?>
                                                        <a href="<?php echo e(route('change-product-type-status',['id'=>base64_encode($product_type->id.":1")])); ?>"
                                                           class="btn btn-sm bg-success-light mr-1"
                                                           title="Activate"
                                                           data-msg="Are you sure want to activate">
                                                            <i class="fas fa-eye-slash"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="<?php echo e(route('change-product-type-status',['id'=>base64_encode($product_type->id.":0")])); ?>"
                                                           class="btn btn-sm bg-success-light mr-1"
                                                           title="Deactivate"
                                                           data-msg="Are you sure want to Deactivate">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                </td>
                                            </tr>

                                            <?php $__currentLoopData = $product_type->childTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($child_type->type_name); ?></td>
                                                    <td><?php echo e($child_type->parentType->type_name ?? '-'); ?></td>
                                                    <td><input class="form-control tfu_case_pack" data-type-id="<?php echo e($child_type->id); ?>" name="case_pack" value="<?php echo e($child_type->case_pack); ?>" style="width: 100px"> </td>
                                                    <td class="text-center">
                                                        <a href="<?php echo e(route('edit-product-type',['id'=>$child_type->id])); ?>" class="btn btn-sm bg-success-light mr-1 edit_cat"> <i class="far fa-edit mr-1"></i> </a>

                                                        <a href="<?php echo e(route('change-product-type-status',['id'=>base64_encode($child_type->id.":2")])); ?>"
                                                           class="btn btn-sm bg-danger-light mr-1"
                                                           title="Delete"
                                                           data-msg="Are you sure want to delete">
                                                            <i class="far fa-trash-alt mr-1"></i>
                                                        </a>
                                                        <?php if($child_type->status == 0): ?>
                                                            <a href="<?php echo e(route('change-product-type-status',['id'=>base64_encode($child_type->id.":1")])); ?>"
                                                               class="btn btn-sm bg-success-light mr-1"
                                                               title="Activate"
                                                               data-msg="Are you sure want to activate">
                                                                <i class="fas fa-eye-slash"></i>
                                                            </a>
                                                        <?php else: ?>
                                                            <a href="<?php echo e(route('change-product-type-status',['id'=>base64_encode($child_type->id.":0")])); ?>"
                                                               class="btn btn-sm bg-success-light mr-1"
                                                               title="Deactivate"
                                                               data-msg="Are you sure want to Deactivate">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        <?php endif; ?>

                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5">Record not found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>

                    <?php echo e($product_types->links('pagination.custom')); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>

    <script type="text/javascript">
    $(document).ready(function() {

        $('body').on('keyup paste', '.tfu_case_pack', function () {
            var case_pack = $(this).val();
            var type_id =  $(this).attr('data-type-id');
            if(case_pack > 0) {
                $.ajax({
                    url: "<?php echo e(route('save-case-pack')); ?>",
                    type: 'GET',
                    data: {case_pack: case_pack, type_id: type_id},
                    dataType: 'json',
                    success: function (data) {

                    }
                });
            }
        });

    });
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/admin/product_type/listing.blade.php ENDPATH**/ ?>