 <div class="header">
	<div class="header-left">
	   <a href="<?php echo e(route('admin-dashboard')); ?>" class="logo logo-small">
	   <img src="<?php echo e(asset('/assets/images/logo-icon.png')); ?>" alt="Logo" width="30" height="30">
	   </a>
	</div>
	<a href="javascript:void(0);"  rel="nofollow" id="toggle_btn">
		<i class="fas fa-align-left"></i>
	</a>
	<a class="mobile_btn" id="mobile_btn"  rel="nofollow" href="javascript:void(0);">
		<i class="fas fa-align-left"></i>
	</a>
	<ul class="nav user-menu">
        <?php /*
	   <li class="nav-item dropdown noti-dropdown">
		  <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
		  <i class="far fa-bell"></i> <span class="badge badge-pill"></span>
		  </a>
		  <div class="dropdown-menu dropdown-menu-right notifications" style="transform: translate3d(-316px, -57px, 0px); top: 0px;">
			 <div class="topnav-dropdown-header">
				<span class="notification-title">Notifications</span>
				<a href="javascript:void(0)" class="clear-noti"> Clear All </a>
			 </div>
			 <div class="noti-content">
				<ul class="notification-list">
				   <li class="notification-message">
					  <a href="admin-notification.html">
						 <div class="media">
							<span class="avatar avatar-sm">
							<img class="avatar-img rounded-circle" alt src="{{ asset('/assets/img/provider/provider-01.jpg')}}">
							</span>
							<div class="media-body">
							   <p class="noti-details">
								  <span class="noti-title">Thomas Herzberg have been subscribed</span>
							   </p>
							   <p class="noti-time">
								  <span class="notification-time">15 Sep 2020 10:20 PM</span>
							   </p>
							</div>
						 </div>
					  </a>
				   </li>
				</ul>
			 </div>
			 <div class="topnav-dropdown-footer">
				<a href="admin-notification.html">View all Notifications</a>
			 </div>
		  </div>
	   </li>
        */ ?>
	   <li class="nav-item dropdown">
		  <a href="javascript:void(0)"  rel="nofollow" class="dropdown-toggle user-link  nav-link" data-bs-toggle="dropdown">

		    <span class="user-img">
                <?php if( !empty($is_admin->photo) && \Storage::disk('uploads')->exists('/users/'.$is_admin->photo)): ?>
                    <img src="<?php echo e(url('uploads/users/'.$is_admin->photo)); ?>" class="fav-icon" alt>
                <?php else: ?>
                        <img class="rounded-circle" src="<?php echo e(asset('/assets/img/user-avatar.png')); ?>" width="40" alt="Admin">
                <?php endif; ?>

		  </span>
		  </a>
		  <div class="dropdown-menu dropdown-menu-right">
			 <a class="dropdown-item" href="<?php echo route('profile'); ?>">Profile</a>
              <a class="dropdown-item" href="<?php echo route('admin.change-password'); ?>">Change Password</a>
			 <a class="dropdown-item" href="<?php echo route('admin_logout'); ?>">Logout</a>
		  </div>
	   </li>
	</ul>
</div>
<?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/partials/admin/header.blade.php ENDPATH**/ ?>