<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/jquery-ui.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Customizer Processing Time</h3>
            </div>
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
                                <th>Product</a></th>
                                <th>Customer Company</th>
                                <th>Upload Processing Time(minutes)</th>
                                <th>Orig Prod Proc Time(minutes)</th>
                                <th>Original Image</th>
                                <th>Original Image Size</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php if($processing_times->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $processing_times; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $processing_time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <?php
                                            $seconds = $processing_time->upload_processing_time;
                                            $upload_roundedMinutes = '-';
                                            $prod_proc_roundedMinutes = '-';
                                            $roundedMinutes = '-';
                                            if($seconds > 0) {
                                                $minutes = $seconds / 60;
                                                $roundedMinutes = number_format($minutes, 2);
                                            }

                                            $seconds = $processing_time->orig_prod_proc_time;
                                            if($seconds > 0) {
                                                $minutes = $seconds / 60;
                                                $prod_proc_roundedMinutes = number_format($minutes, 2);
                                            }
                                            $filePath = base_path('uploads/products/' . $processing_time->image_name);
                                            $image_path = url('uploads/products/'.$processing_time->image_name);
                                            if(!File::exists($filePath)) {
                                                  $image_path = url('uploads/customizer-products/'.$processing_time->image_name);
                                                  $filePath = base_path('uploads/customizer-products/' . $processing_time->image_name);
                                            }
                                            $fileSize = file_exists($filePath) ? filesize($filePath) : 0;
                                            $fileSizeInMB = $fileSize > 0 ? round($fileSize / (1024 * 1024), 2) : 'File not found';

                                        ?>

                                        <tr id="tr_<?php echo e($processing_time->id); ?>">
                                            <td>
                                                <span class="numeric_number" style="color: #FF6600;font-weight: bold;"><?php echo e($index + $processing_times->firstItem()); ?></span>
                                            </td>
                                            <td><?php echo $processing_time->product_name; ?></td>
                                            <td><?php echo e($processing_time->customer->company ?? ''); ?></td>
                                            <td><?php echo e($roundedMinutes); ?></td>
                                            <td><?php echo e($prod_proc_roundedMinutes); ?></td>
                                            <td> <a href="<?php echo e($image_path); ?>" target="_blank"> <img class="avatar-img rounded" alt src="<?php echo e($image_path); ?>" width="40%"></a></td>
                                            <td><?php echo e($fileSizeInMB); ?> MB</td>
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
                    <?php echo e($processing_times->withQueryString()->links('pagination.custom')); ?>

                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/admin/products/customizer_processing_time.blade.php ENDPATH**/ ?>