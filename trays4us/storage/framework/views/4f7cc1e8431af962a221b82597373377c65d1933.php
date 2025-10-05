<?php $__env->startSection('content'); ?>

    <section class="tfu-dashboard-wrapper" >
          <div class=" tfu-general-breadcumb-wrapper" >
            

            <div class="tfu-general-heading" >
                <h1>MY ACCOUNT</h1>
            </div>

       </div>

        

        <div class="row   tfu-dashboard-handler" >

            <ul class="tfu-dashboard-menu-link">

                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="<?php echo e(route('my-account')); ?>" class="tfu-active" style="font-weight:800;" >Details</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="<?php echo e(route('wishlist')); ?>">Wishlists</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="<?php echo e(route('my-order')); ?>">Orders</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="<?php echo e(route('cart')); ?>" >Cart</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>

            </ul>

        </div>


        <div class="row" >

            <div class="col-xl-12" >

                <div class="ftu-dashboard-content">
                    <div class="tfu-my-account-btn-handler" >
                     <a href="<?php echo e(route('customer-profile')); ?>" class="ftu-btn-block" >Update Account Details</a>
                    </div>

                    <h4>Log in</h4>

                    <table>

                        <tr>

                            <td>Name:</td>

                            <td><?php echo e($customer_detail->full_name ? $customer_detail->full_name : ''); ?></td>

                        </tr>

                        <tr>

                            <td>E-mail:</td>

                            <td><?php echo e($customer_detail->email ? $customer_detail->email : ''); ?></td>

                        </tr>

                        <tr>

                            <td>Password:</td>

                            <td>*************</td>

                        </tr>

                    </table>



                    <h4>Address</h4>

                    <table>

                        <tr>

                            <td>Company:</td>

                            <td><?php echo e($customer_detail->company ? $customer_detail->company : ''); ?></td>

                        </tr>

                        <tr>

                            <td>Address:</td>

                            <td><?php echo e($customer_detail->address ? $customer_detail->address : ''); ?></td>

                        </tr>

                        <tr>

                            <td>Phone:</td>

                            <td><?php echo e($customer_detail->phone ? $customer_detail->phone : ''); ?></td>

                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript">
        $(document).ready(function() {

        });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/frontend/my-account/my-account.blade.php ENDPATH**/ ?>