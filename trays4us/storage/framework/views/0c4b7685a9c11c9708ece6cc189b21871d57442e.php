<?php if($message=Session::get('success')): ?>
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-bs-dismiss="alert">×</button>
        <strong><?php echo e($message); ?></strong>
    </div>
<?php endif; ?>


<?php if($message=Session::get('error')): ?>
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-bs-dismiss="alert">×</button>
        <strong><?php echo e($message); ?></strong>
    </div>
<?php endif; ?>


<?php if($message=Session::get('warning')): ?>
    <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-bs-dismiss="alert">×</button>
        <strong><?php echo e($message); ?></strong>
    </div>
<?php endif; ?>


<?php if($message=Session::get('info')): ?>
    <div class="alert alert-info alert-block">
        <button type="button" class="close" data-bs-dismiss="alert">×</button>
        <strong><?php echo e($message); ?></strong>
    </div>
<?php endif; ?>


<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-bs-dismiss="alert">×</button>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li style="padding: 5px;"><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>

<?php if(session('password_reminder')): ?>
    <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-bs-dismiss="alert">×</button>
        <strong>  <?php echo session('password_reminder'); ?></strong>
    </div>
<?php endif; ?>
<?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/partials/flash-message.blade.php ENDPATH**/ ?>