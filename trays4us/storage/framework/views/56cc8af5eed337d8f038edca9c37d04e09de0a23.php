<div class="sidebar" id="sidebar">

	<div class="sidebar-logo">

	   <a href="<?php echo e(route('admin-dashboard')); ?>">

           <?php if(isset($site_management->website_logo)  && \Storage::disk('uploads')->exists('/users/' . $site_management->website_logo)): ?>

               <img src="<?php echo e(url('uploads/users/'.$site_management->website_logo)); ?>"  class="img-fluid" alt>

           <?php endif; ?>

	   </a>

	</div>

	<div class="sidebar-inner slimscroll">

	   <div id="sidebar-menu" class="sidebar-menu">
		  <ul>
			 <li  class="<?php echo e(request()->is('admin/admin-dashboard') ? 'active' : ''); ?>">
				<a href="<?php echo e(route('admin-dashboard')); ?>"><i class="fas fa-columns"></i> <span>Dashboard</span></a>
			 </li>

			 <li class="<?php echo e(request()->is('admin/customer') ? 'active' : ''); ?>">
				<a href="<?php echo e(route('customer')); ?>"><i class="fas fa-users"></i>  <span>Customers</span></a>
			 </li>

              <li class="submenu">

                  <a href="#"><i class="fa-regular fa-building"></i> <span> Homepage </span> <span class="menu-arrow"></span></a>

                  <ul style="display: none;">

                      <li>
                          <a href="<?php echo e(route('homepage-slider')); ?>" class="<?php echo e(request()->is('admin/homepage-slider') ? 'active' : ''); ?>"><span>All Slides</span></a>
                      </li>

                      <li>
                          <a href="<?php echo e(route('slider-setting')); ?>" class="<?php echo e(request()->is('admin/slider-setting') ? 'active' : ''); ?>"><span>Slider Settings</span></a>
                      </li>
                  </ul>
              </li>


              <li class="<?php echo e(request()->is('admin/artists') ? 'active' : ''); ?>">
                  <a href="<?php echo e(route('artists')); ?>"><i class="fa-brands fa-artstation"></i>  <span>Artists</span></a>
              </li>

              <li class="submenu">

                  <a href="#"><i class="fa-brands fa-product-hunt"></i> <span> Products </span> <span class="menu-arrow"></span></a>

                  <ul style="display: none;">

                      <li>
                          <a href="<?php echo e(route('products-listing')); ?>" class="<?php echo e(request()->is('admin/products') ? 'active' : ''); ?>"><span>Products</span></a>
                      </li>


                      <li>
                          <a href="<?php echo e(route('product-types')); ?>" class="<?php echo e(request()->is('admin/product-types') ? 'active' : ''); ?>"><span>Product Types</span></a>
                      </li>

                      <li>
                          <a href="<?php echo e(route('product-customizable')); ?>" class="<?php echo e(request()->is('admin/product-customizable') ? 'active' : ''); ?>"><span>Design Types</span></a>
                      </li>

                      <li>
                          <a href="<?php echo e(route('product-style')); ?>" class="<?php echo e(request()->is('admin/product-style') ? 'active' : ''); ?>"><span>Product Styles</span></a>
                      </li>

                      <li>
                          <a href="<?php echo e(route('tags')); ?>" class="<?php echo e(request()->is('admin/tags') ? 'active' : ''); ?>"><span>Product Tags</span></a>
                      </li>

                      <li>
                          <a href="<?php echo e(route('product-badges')); ?>" class="<?php echo e(request()->is('admin/product-badges') ? 'active' : ''); ?>"><span>Product Badges</span></a>
                      </li>

                      <li>
                          <a href="<?php echo e(route('get-search-tag-listing')); ?>" class="<?php echo e(request()->is('admin/get-search-tag-listing') ? 'active' : ''); ?>"><span>Search Tags</span></a>
                      </li>

                  </ul>

              </li>

              <li class="<?php echo e(request()->is('admin/all-countries') ? 'active' : ''); ?>">
                  <a href="<?php echo e(route('all-countries')); ?>"><i class="fa-solid fa-globe"></i> <span>Countries</span></a>
              </li>

			 <li>
				<a href="<?php echo e(route('all-orders')); ?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Orders</span></a>
			 </li>

              <li>
                  <a href="<?php echo e(route('all-cart-items')); ?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Open Carts</span></a>
              </li>

			 <li  class="<?php echo e(request()->is('admin/site-setting') ? 'active' : ''); ?>">
				<a href="<?php echo e(route('site-setting')); ?>"><i class="fas fa-cog"></i> <span> Settings</span></a>
			 </li>

              <li  class="">
                  <a href="<?php echo e(route('home')); ?>" target="_blank"><i class="fa-solid fa-store"></i> <span>Marketplace</span></a>
              </li>

		  </ul>

	   </div>

	</div>

</div>

<?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/partials/admin/left-sidebar.blade.php ENDPATH**/ ?>