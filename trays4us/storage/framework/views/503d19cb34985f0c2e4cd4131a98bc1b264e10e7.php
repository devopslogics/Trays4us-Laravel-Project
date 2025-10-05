<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Add Design type</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <form action="<?php echo e(route('add-product-customizable-submitted')); ?>" method="post" enctype="multipart/form-data" class="add_theme_submitted">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Design Name</label>
                                    <input type="text" class="form-control" name="design_type" value="<?php echo e(old('design_type')); ?>">
                                </div>
                            </div>

                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="<?php echo e(route('product-customizable')); ?>" class="btn btn-link">Cancel</a>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/admin/product-customizable/add.blade.php ENDPATH**/ ?>