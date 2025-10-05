<?php $__env->startSection('content'); ?>

    <div class="page-header">

        <div class="row">

            <div class="col">

                <h3 class="page-title">Dashboard</h3>

            </div>

        </div>

    </div>





 <div class="row">

	  <div class="col-xl-3 col-sm-6 col-12">

          <a href="<?php echo e(route('customer')); ?>">

             <div class="card">

                <div class="card-body">

                   <div class="dash-widget-header">

                      <span class="dash-widget-icon bg-primary">

                    <i class="fas fa-users"></i>

                      </span>

                      <div class="dash-widget-info">

                         <h3><?php echo e($customers_count); ?></h3>

                         <h6 class="text-muted">Customers</h6>

                      </div>

                   </div>

                </div>

             </div>

          </a>

	  </div>

	  <div class="col-xl-3 col-sm-6 col-12">

          <a href="<?php echo e(route('artists')); ?>">

             <div class="card">

                <div class="card-body">

                   <div class="dash-widget-header">

                      <span class="dash-widget-icon bg-primary">

                     <i class="fa-brands fa-artstation"></i>

                      </span>

                      <div class="dash-widget-info">

                         <h3><?php echo e($artists_count); ?></h3>

                         <h6 class="text-muted">Artists</h6>

                      </div>

                   </div>

                </div>

             </div>

          </a>

	  </div>

	  <div class="col-xl-3 col-sm-6 col-12">

      <a href="<?php echo e(route('products-listing')); ?>">

		 <div class="card">

			<div class="card-body">

			   <div class="dash-widget-header">

				  <span class="dash-widget-icon bg-primary">

				 <i class="fa-brands fa-product-hunt"></i>

				  </span>

				  <div class="dash-widget-info">

					 <h3><?php echo e($products_count); ?></h3>

					 <h6 class="text-muted">Products</h6>

				  </div>

			   </div>

			</div>

		 </div>

      </a>

	  </div>

	  <div class="col-xl-3 col-sm-6 col-12">
          <a href="<?php echo e(route('all-orders')); ?>">
		        <div class="card">

			<div class="card-body">

			   <div class="dash-widget-header">

				  <span class="dash-widget-icon bg-primary">

				  <i class="far fa-credit-card"></i>

				  </span>

				  <div class="dash-widget-info">

					 <h3><?php echo e($orders_count); ?></h3>

					 <h6 class="text-muted">Orders</h6>

				  </div>

			   </div>

			</div>

		 </div>
          </a>
	  </div>

   </div>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/admin/dashboard/dashboard.blade.php ENDPATH**/ ?>