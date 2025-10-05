<?php $__env->startSection('content'); ?>

    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">My orders</h3>
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
                                <option value="1" <?php echo e((isset($_GET['status']) AND $_GET['status'] == 1) ? 'selected' : ''); ?>>Submitted</option>
                                <option value="2" <?php echo e((isset($_GET['status']) AND $_GET['status'] == 2) ? 'selected' : ''); ?>>Added to production</option>
                                <option value="3" <?php echo e((isset($_GET['status']) AND $_GET['status'] == 3) ? 'selected' : ''); ?>>Produced</option>
                                <option value="4" <?php echo e((isset($_GET['status']) AND $_GET['status'] == 4) ? 'selected' : ''); ?>>Arriving to warehouse</option>
                                <option value="5" <?php echo e((isset($_GET['status']) AND $_GET['status'] == 5) ? 'selected' : ''); ?>>Shipped</option>
                                <option value="6" <?php echo e((isset($_GET['status']) AND $_GET['status'] == 6) ? 'selected' : ''); ?>>Cancelled</option>
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
                            <a href="<?php echo e(route('all-orders')); ?>" class="btn btn-primary btn-block" style="line-height: 34px;">Reset</a>
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
                        <table class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Company Name</th>
                                    <th>Total Quantity</th>
                                  <?php /*  <th>Detail</th> */ ?>
                                    <th>Amount</th>
                                    <th>Order Date</th>
                                    <th>Estimated Ship Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if($orders->isNotEmpty()): ?>
                                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="tr_<?php echo e($order->id); ?>" class="<?php echo e($order->status == 6 ? 'order_cancelled' : ''); ?>">
                                        <td><?php echo e($order->order_number); ?></td>
                                        <td><a href="<?php echo e(route('customer', ['cid' => $order->customer->id])); ?>"style="text-decoration: underline;"><?php echo e($order->customer->company ?? ''); ?></a></td>
                                        <td><?php echo e($order->orderItems->sum('quantity')); ?></td>
                                        <?php /*
                                        <td>
                                            <a href="javascript:void(0)" data-order-id="{{$order->id }}"   style="" class="btn btn-sm order_item_detail">
                                                <i class="fas fa-clipboard-list"></i>
                                            </a>
                                        </td> */ ?>
                                        <td>$<?php echo e($order->orderItems->sum(function ($item) {
                                                    return $item->sale_price * $item->quantity;
                                                }) + $order->shipping_cost); ?>

                                        </td>

                                        <td><?php echo e($order->created_at->format('Y-m-d')); ?></td>
                                        <td><?php echo e($order->estimated_ship_date ?? ''); ?></td>
                                        <td class="">

                                            <a href="<?php echo e(route('edit-order',['order_id'=>$order->id])); ?>" class="btn btn-sm bg-success-light mr-1"> <i class="far fa-edit mr-1"></i> </a>


                                        <?php if($order->status != 6 AND $order->status != 5): ?>
                                                <select class="form-control order_status_box" style="width: 165px;display: inline-block;">
                                                    <option value="" <?php echo e(($order->status == 1) ? 'selected' : ''); ?>>Submitted</option>
                                                    <option value="<?php echo e(route('change-order-process',['order_id'=>$order->id,'status'=>2])); ?>" <?php echo e(($order->status == 2) ? 'selected' : ''); ?>>Added to production</option>
                                                    <option value="<?php echo e(route('change-order-process',['order_id'=>$order->id,'status'=>3])); ?>" <?php echo e(($order->status == 3) ? 'selected' : ''); ?>>Produced</option>
                                                    <option value="<?php echo e(route('change-order-process',['order_id'=>$order->id,'status'=>4])); ?>" <?php echo e(($order->status == 4) ? 'selected' : ''); ?>>Arriving to warehouse</option>
                                                    <option value="<?php echo e(route('change-order-process',['order_id'=>$order->id,'status'=>5])); ?>" <?php echo e(($order->status == 5) ? 'selected' : ''); ?>>Shipped</option>
                                                </select>
                                            <?php endif; ?>


                                            <?php if($order->status == 6 || $order->status == 5): ?>
                                               <?php
                                                    $order_status  = \App\Traits\Definations::getOrderStatusClass($order->status);
                                               ?>
                                              <span class="<?php echo e($order_status[0]); ?>"><?php echo e($order_status[1]); ?> </span>
                                            <?php endif; ?>

                                            <?php if($order->status != 6 AND $order->status != 5): ?>
                                                <a href="javascript:void(0)"  data-order-id="<?php echo e($order->id); ?>" class="cancel_order btn octf1-btn"> <i class="fas fa-times"></i></a>
                                            <?php endif; ?>

                                        </td>
                                     </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">Record not found</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php echo e($orders->links('pagination.custom')); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript">
    $(document).ready(function() {

        $(document).on("click", ".order_item_detail", function () {
            order_id = $(this).attr('data-order-id');
            $.ajax({
                type: "get",
                url: "<?php echo e(route('order-item-detail')); ?>",
                data: {
                    "order_id": order_id,
                },
                dataType: "json",
                success: function (data) {
                    $('#jp_general_header').text('Order detail');
                    $('#jp_general_body').html(data.html);
                    $('#jp_general_modal').modal('show');
                }
            });
        });

        //------------------------------------------------------------------------------------------------

        $(document).on("click", ".cancel_order", function (event) {
            event.preventDefault();
            Swal.fire({
                reverseButtons: true,
                title: 'Are you want to cancel the  order ?',
                type: 'warning',
                width:350,
                height:150,
                showCancelButton: true,
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                confirmButtonColor: '#ff7129',
                cancelButtonColor: '#808080'

            }).then((result) => {
                if (result.value) {
                    var order_id = $(this).attr('data-order-id');
                    _this = $(this);
                    $.ajax({
                        type: "get",
                        url: "<?php echo e(route('cancel-order')); ?>",
                        data: {
                            "order_id": order_id,
                        },
                        dataType: "json",
                        success: function (data) {
                            if(data.status == 'success') {
                                location.reload();
                                $('#tr_'+order_id).addClass('order_cancelled');
                                //_this.hide();
                            }
                        }
                    });
                }
            })
        });

        //------------------------------------------------------------------------------------------------

        $(document).on("change", ".order_status_box", function () {
            order_status = this.value;
            //console.log(order_status);
            window.location = order_status;
        });

    });
</script>

<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/admin/orders/all-orders.blade.php ENDPATH**/ ?>