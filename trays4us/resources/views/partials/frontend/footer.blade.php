<footer id="mastfooter" class="site-footer" >

   <div class="container-fluid  tfu-footer-main-wrapper" >
      <div class="row">

          <div class="col-12 col-sm-6 col-md-4 col-lg-2 col-xl-2 m-0 p-0" >
            <div class="tfu-footer-col-1" >
              <div class="tfu-footer-logo-wrap" >
               <img src="{{ asset('/assets/frontend-assets/svg/footertrays4Us.svg')}}" alt="SVG Image" />
               <p>© 2000-{{date('Y')}}, Trays4Us</p>
              </div>

            </div>
          </div>
          <div class="col-6 col-sm-6 col-md-4 col-lg-2 col-xl-2  m-0 p-0" >
           <div class="tfu-footer-col-2" >
              <h4>Explore</h4>
              <ul>
                <li><a href="{{ route('frontend.products') }}" >Stock Designs</a></li>
                <li><a href="{{ route('create-custom') }}" >Create Custom</a></li>
                <li><a href="{{ route('privacy-policy') }}" >Privacy Policy</a></li>
              </ul>
            </div>
          </div>
          <div class="col-6 col-sm-6 col-md-4 col-lg-2 col-xl-2  m-0 p-0" >
           <div class="tfu-footer-col-3" >
              <h4>Order Online</h4>
              <ul>
                <li><a href="{{ route('sign-up') }}" >Register Your Account</a></li>
                <li><a href="https://www.faire.com/direct/trays4us" target="_blank">Order Via<span><img src="{{ asset('/assets/frontend-assets/images/faireLogo-w.svg')}}" alt="faireLogo-w.svg" /></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-6 col-sm-6 col-md-4 col-lg-2 col-xl-2  m-0 p-0" >
           <div class="tfu-footer-col-4" >
            <h4>Contact Us</h4>
            <ul>
              <li><a href="{{ route('contact-us') }}" >Local Representatives</a></li>
              <li><a href="tel:6034986283" >Sales (603) 498-6283</a></li>
            </ul>
           </div>
          </div>
          <div class="col-6 col-sm-6 col-md-4 col-lg-2 col-xl-2  m-0 p-0" >
           <div class="tfu-footer-col-5" >
            <h4>Support</h4>
            <ul>
              <li><a href="mailto:info@trays4.us" >info@trays4.us</a></li>
              <li><a href="{{ route('license-artwork') }}" >License Your Artwork</a></li>
            </ul>
           </div>
          </div>
          <div class="col-12 col-sm-6 col-md-4 col-lg-2 col-xl-2  m-0 p-0" >
           <div class="tfu-footer-col-6" >
               <a href="javascript:void(0)" id="back_to_top" rel="nofollow">
                    <div class="tfu-upper-polygon" >
                        <img src="{{ asset('/assets/frontend-assets/svg/footerpolygon.svg')}}" alt="SVG Image" />
                    </div>
               </a>
           </div>
          </div>

      </div>
   </div>

</footer>
