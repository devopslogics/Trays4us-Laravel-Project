<header id="tfu-header-wrapper" class="tfu-site-header" >

    <div class="container-fluid" >
        <div class="row">

            <div class="col-3 col-sm-3 col-md-3 col-lg-2 col-xl-2 m-ftu-1">
                <a class="navbar-brand" href="{{ route('frontend.products') }}">
                    @if(isset($site_management->website_logo)  && \Storage::disk('uploads')->exists('/users/' . $site_management->website_logo))
                        <img src="{{ url('uploads/users/'.$site_management->website_logo) }}" alt="Logo" />
                    @endif
                </a>
            </div>

            <div class="col-5 col-sm-5 col-md-5 col-lg-3 col-xl-3 m-ftu-2 ">
                <form action="{{ route('frontend.products') }}" class="tfu-search-form" id="header_search_form">
                    <?php /*
                    <input type="text" name="tfuu_product_name" id="tfuu_product_name" style="display:none;">
                    <input type="hidden" name="g-recaptcha-response" id="recaptchaResponse"> */ ?>
                    <div class="form-group">
                      <span class="tfu-icon-input-search" id="header_search_btn">
                        <img src="{{ asset('/assets/frontend-assets/svg/search-icon.svg')}}" alt="SVG Image" />
                      </span>
                        <input type="text" class="form-control tfu_search_by" name="search_by" id="search_by" placeholder="Search and Filter..." value="{{(isset($_GET['search_by']) && !empty($_GET['search_by'])) ? $_GET['search_by'] : ''}}"/>
                        <button class="g-recaptcha d-none"
                                data-sitekey="6Lc79WsqAAAAAGav1yolzjrTlxh4tfdTzEkoY2sT"
                                data-callback='onSubmit'
                                data-action='submit'>Submit</button>
                    </div>
                </form>
            </div>

            <div class="col-1 col-sm-1 col-md-1 col-lg-6 col-xl-5 m-ftu-3 ">

                <nav class="navbar navbar-expand-lg navbar-light ">
                    <button class="navbar-toggler ftu-nav-togglebar" type="button" data-bs-toggle="collapse" data-bs-target="#ftu-navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="ftu-nav-togglebar">
                          @if(Session::has('is_customer') && !empty(Session::get('is_customer')))
                            <img src="{{ asset('/assets/frontend-assets/svg/login-menu-icon.svg')}}" alt="SVG Image" />
                          @else
                            <img src="{{ asset('/assets/frontend-assets/svg/logout-menu-icon.svg')}}" alt="SVG Image" />
                          @endif
                      </span>
                    </button>
                    <div class="collapse navbar-collapse" id="ftu-navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">HOME</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('frontend.products') }}">PRODUCTS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('create-custom') }}">CREATE CUSTOM</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('license-artwork') }}">Artists</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('contact-us') }}">CONTACT US</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            @if(Session::has('is_customer') && !empty(Session::get('is_customer')))
                <div class="col-3 col-sm-3 col-md-3 col-lg-1 col-xl-2 m-ftu-4 ">
                    <div class="tfu-icon-wrapper d-flex" >
                        <div class="tfu-login-handler" >
                            <button>My Account</button>
                        </div>
                        <div class="tfu-cart-handler" id="tfu_cart_wrapper">
                            <a href="{{ route('cart') }}" class="">
                                <img src="{{ asset('/assets/frontend-assets/svg/cart-icon.svg')}}" alt="SVG Image" />
                                <span id="item_count">{{ $total_item_quantity ?? 0}}</span>
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-3 col-sm-3 col-md-3 col-lg-1 col-xl-2 m-ftu-4 ">
                    <div class="tfu-icon-wrapper d-flex" >
                        <div class="tfu-login-handler" >
                            <button>Register/Sign In</button>
                        </div>
                        <div class="tfu-cart-handler" >
                            <img src="{{ asset('/assets/frontend-assets/svg/cart-icon-logout.svg')}}" alt="SVG Image" />
                            <span>0</span>
                        </div>
                    </div>
                </div>

            @endif

            <div id="tfu-user-account-handler" class="tfu-user-account-popup">
                @if(!Session::has('is_customer') && empty(Session::get('is_customer')))
                    <div class="tfu-popup-useraccount">
                      <div class="ftu-signin-popup-btn">
                            <a class="nav-link" href="{{ route('sign-in') }}">Sign In</a>
                            <p>or</p>
                            <a class="nav-link" href="{{ route('sign-up') }}" >Create Account</a>
                      </div>
                      <p>To access wholesale catalog</p>
                    </div>
                @endif

                @if(Session::has('is_customer') && !empty(Session::get('is_customer')))
                    <div class="tfu-user-account-content">
                      <div>
                        <ul>
                            <li><a href="{{ route('my-account') }}" >My Account</a></li>
                            <li><a href="{{ route('my-order') }}" >My Orders</a></li>
                            <li><a href="{{ route('wishlist') }}" >My Wishlist</a></li>
                        </ul>
                      </div>
                      <div>
                        <ul>
                            <li><a href="{{ route('change-password') }}" >Change Password</a></li>
                            <li><a href="{{ route('contact-us') }}" >Contact Support</a></li>
                            <li><a href="{{ route('logout') }}" >Logout</a></li>
                        </ul>
                      </div>
                    </div>
               @endif

            </div>

        </div>
    </div>

</header>
