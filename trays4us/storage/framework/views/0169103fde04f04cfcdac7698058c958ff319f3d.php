<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/tags.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/jquery-ui.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Edit Product tag</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <?php
                       // $commaSeparatedTags = implode(', ', $synonym->toArray());
                    ?>
                    <form action="<?php echo e(route('edit-tag-submitted')); ?>" method="post" enctype="multipart/form-data" class="edit_tag_submitted">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="tag_id" value="<?php echo e($tag->id); ?>" id="tag_id">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tag Name</label>
                                    <input type="text" class="form-control" name="tag_name" value="<?php echo e($tag->tag_name); ?>">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group tag_wrapper">
                                    <label>Synonym</label>
                                    <input type="hidden" name="synonyms" id="tag_ids" class="tag-ids"  value="<?php echo e(collect($synonym)->join(', ')); ?>">

                                    <div class="tags-input">
                                        <div class="myTags" id="">
                                            <span class="data">
                                                <?php if($tag->synonyms): ?>
                                                    <?php $__currentLoopData = $tag->synonyms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $synonym): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span class="tag"><span class="text" _value="<?php echo e($synonym->synonym); ?>"><?php echo e($synonym->synonym); ?></span><span class="close">&times;</span></span>
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

                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/tags.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/js/jquery-ui.min.js')); ?>"></script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/admin/product-tags/edit.blade.php ENDPATH**/ ?>