<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">All Countries</h3>
            </div>
            <div class="col-auto text-right">
                <a class="btn btn-white filter-btn" href="javascript:void(0);" id="filter_search">
                    <i class="fas fa-filter"></i>
                </a>

            </div>
        </div>
    </div>

    <div class="card filter-card" id="filter_inputs" style="display: <?php echo e($filter_flag ? 'block' : ''); ?>">
        <div class="card-body pb-0">
            <form action="" method="get">
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="">Select Status</option>
                                <option value="1" <?php echo e((isset($_GET['status']) AND $_GET['status'] == 1) ? 'selected' : ''); ?>>Active</option>
                                <option value="0" <?php echo e((isset($_GET['status']) AND $_GET['status'] == '0') ? 'selected' : ''); ?>>Inactive</option>
                                <option value="2" <?php echo e((isset($_GET['status']) AND $_GET['status'] == 2) ? 'selected' : ''); ?>>Deleted</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>Search by</label>
                            <input class="form-control" type="text" name="search_by" value="<?php echo e(isset($_GET['search_by']) ? $_GET['search_by']: ''); ?>">
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Search</button>
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
                        <table class="table table-hover table-center mb-0" id="items">
                            <thead>
                            <tr>
                                <th>Country Name</th>
                                <th>Date</th>
                                <th class="text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php if($countries->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $row_status_class = '';
                                             if($country->status == 0)
                                                  $row_status_class = 'table-warning';
                                             if($country->status == 2)
                                                  $row_status_class = 'table-danger';
                                        ?>
                                        <tr class="<?php echo e($row_status_class); ?>">
                                            <td><?php echo e($country->country_code); ?></td>
                                            <td><?php echo e($country->country_name); ?></td>
                                            <td><?php echo e($country->full_name); ?></td>
                                            <td><?php echo e($country->created_at); ?></td>
                                            <td class="text-end">

												 <a href="<?php echo e(route('all-states',['cid'=>$country->id])); ?>"
                                                   class="btn btn-sm mr-1 bg-success-light"
                                                   title="State List" >
                                                    States
                                                </a>

                                                <a href="<?php echo e(route('change-country-status',['id'=>base64_encode($country->id.":2")])); ?>"
                                                   class="btn btn-sm bg-danger-light mr-1 change_status"
                                                   title="Delete"
                                                   data-msg="Are you sure want to delete">
                                                    <i class="far  fa-trash-alt mr-1"></i>
                                                </a>
                                                <?php if($country->status == 0): ?>
                                                    <a href="<?php echo e(route('change-country-status',['id'=>base64_encode($country->id.":1")])); ?>"
                                                       class="btn btn-sm bg-success-light mr-1 change_status"
                                                       title="Activate"
                                                       data-msg="Are you sure want to activate">
                                                        <i class="fas fa-eye-slash"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?php echo e(route('change-country-status',['id'=>base64_encode($country->id.":0")])); ?>"
                                                       class="btn btn-sm bg-success-light mr-1 change_status"
                                                       title="Deactivate"
                                                       data-msg="Are you sure want to Deactivate">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                <?php endif; ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4">Record not found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>

                    <?php echo e($countries->links('pagination.custom')); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>

    <script type="text/javascript">
    $(document).ready(function() {


    });
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/admin/countries/listing.blade.php ENDPATH**/ ?>