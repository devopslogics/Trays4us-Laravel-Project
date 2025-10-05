<!DOCTYPE html>

<html lang="en">

   <head>

       <?php echo $__env->make('partials.admin.headers-style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

       <?php echo $__env->yieldPushContent('styles'); ?>

   </head>

   <body>
       <div id="loading" style="display: none; background-color: #0003;">
           <img id="loading-image" src="<?php echo e(asset('assets/images/ajax_loader_red.gif')); ?>" alt="Loading..." style="width: 50px; height: 50px; margin: 350px;"/>
       </div>
      <div class="main-wrapper">

         <?php echo $__env->make('partials.admin.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

         <?php echo $__env->make('partials.admin.left-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

         <div class="page-wrapper">

            <div class="content container-fluid">

			    <?php echo $__env->make('partials.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

				<?php echo $__env->yieldContent('content'); ?>

            </div>

         </div>

      </div>

    <?php echo $__env->make('partials.admin.footer-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<?php echo $__env->make('partials.admin.common-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<?php echo $__env->yieldPushContent('scripts'); ?>


      <div class="modal fade cate-view  custom-popup-size" id="jp_general_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content profile-page">
                  <div class="modal-header">
                      <h4 class="modal-title" id="jp_general_header"></h4>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                  <div class="modal-body custom_fields_l row" id="jp_general_body">
                  </div>
              </div>
          </div>
      </div>

   </body>

</html>

<?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/layouts/admin/dashboard.blade.php ENDPATH**/ ?>