<div class="sidebar" id="sidebar">

	<div class="sidebar-logo">

	   <a href="{{ route('admin-dashboard') }}">

           @if(isset($site_management->website_logo)  && \Storage::disk('uploads')->exists('/users/' . $site_management->website_logo))

               <img src="{{ url('uploads/users/'.$site_management->website_logo) }}"  class="img-fluid" alt>

           @endif

	   </a>

	</div>

	<div class="sidebar-inner slimscroll">

	   <div id="sidebar-menu" class="sidebar-menu">
		  <ul>
			 <li  class="{{ request()->is('admin/admin-dashboard') ? 'active' : '' }}">
				<a href="{{ route('admin-dashboard') }}"><i class="fas fa-columns"></i> <span>Dashboard</span></a>
			 </li>

			 <li class="{{ request()->is('admin/customer') ? 'active' : '' }}">
				<a href="{{ route('customer') }}"><i class="fas fa-users"></i>  <span>Customers</span></a>
			 </li>

              <li class="submenu">

                  <a href="#"><i class="fa-regular fa-building"></i> <span> Homepage </span> <span class="menu-arrow"></span></a>

                  <ul style="display: none;">

                      <li>
                          <a href="{{ route('homepage-slider') }}" class="{{ request()->is('admin/homepage-slider') ? 'active' : '' }}"><span>All Slides</span></a>
                      </li>

                      <li>
                          <a href="{{ route('slider-setting') }}" class="{{ request()->is('admin/slider-setting') ? 'active' : '' }}"><span>Slider Settings</span></a>
                      </li>
                  </ul>
              </li>


              <li class="{{ request()->is('admin/artists') ? 'active' : '' }}">
                  <a href="{{ route('artists') }}"><i class="fa-brands fa-artstation"></i>  <span>Artists</span></a>
              </li>

              <li class="submenu">

                  <a href="#"><i class="fa-brands fa-product-hunt"></i> <span> Products </span> <span class="menu-arrow"></span></a>

                  <ul style="display: none;">

                      <li>
                          <a href="{{ route('products-listing') }}" class="{{ request()->is('admin/products') ? 'active' : '' }}"><span>Products</span></a>
                      </li>


                      <li>
                          <a href="{{ route('product-types') }}" class="{{ request()->is('admin/product-types') ? 'active' : '' }}"><span>Product Types</span></a>
                      </li>

                      <li>
                          <a href="{{ route('product-customizable') }}" class="{{ request()->is('admin/product-customizable') ? 'active' : '' }}"><span>Design Types</span></a>
                      </li>

                      <li>
                          <a href="{{ route('product-style') }}" class="{{ request()->is('admin/product-style') ? 'active' : '' }}"><span>Product Styles</span></a>
                      </li>

                      <li>
                          <a href="{{ route('tags') }}" class="{{ request()->is('admin/tags') ? 'active' : '' }}"><span>Product Tags</span></a>
                      </li>

                      <li>
                          <a href="{{ route('product-badges') }}" class="{{ request()->is('admin/product-badges') ? 'active' : '' }}"><span>Product Badges</span></a>
                      </li>

                      <li>
                          <a href="{{ route('get-search-tag-listing') }}" class="{{ request()->is('admin/get-search-tag-listing') ? 'active' : '' }}"><span>Search Tags</span></a>
                      </li>

                  </ul>

              </li>

              <li class="{{ request()->is('admin/all-countries') ? 'active' : '' }}">
                  <a href="{{ route('all-countries') }}"><i class="fa-solid fa-globe"></i> <span>Countries</span></a>
              </li>

			 <li>
				<a href="{{ route('all-orders') }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Orders</span></a>
			 </li>

              <li>
                  <a href="{{ route('all-cart-items') }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Open Carts</span></a>
              </li>

			 <li  class="{{ request()->is('admin/site-setting') ? 'active' : '' }}">
				<a href="{{ route('site-setting') }}"><i class="fas fa-cog"></i> <span> Settings</span></a>
			 </li>

              <li  class="">
                  <a href="{{ route('home') }}" target="_blank"><i class="fa-solid fa-store"></i> <span>Marketplace</span></a>
              </li>

		  </ul>

	   </div>

	</div>

</div>

