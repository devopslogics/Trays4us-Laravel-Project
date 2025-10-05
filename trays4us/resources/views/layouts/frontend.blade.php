<!DOCTYPE html>
<html lang="en">
   <head>

       @include('partials.frontend.headers-style')
       @stack('styles')

       @if(App::environment('production'))
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                       new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                   j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                   'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
               })(window,document,'script','dataLayer','GTM-MZ72J75B');</script>


           <script>
               !function(f,b,e,v,n,t,s)
               {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                   n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                   if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                   n.queue=[];t=b.createElement(e);t.async=!0;
                   t.src=v;s=b.getElementsByTagName(e)[0];
                   s.parentNode.insertBefore(t,s)}(window, document,'script',
                   'https://connect.facebook.net/en_US/fbevents.js');; "‌")
               fbq('init', '468110209458352');
               fbq('track', 'PageView');
           </script>
           <noscript><img height="1" width="1" style="display:none"
                          src="https://www.facebook.com/tr?id=468110209458352&ev=PageView&noscript=1"
               /></noscript>
        @endif

       @stack('structured_data_markup')
   </head>
   <body class="tfu-current-{{ Route::currentRouteName() }}">

   <div id="tfu_loading" style="display: none; background-color: #0003;">
       <img id="loading-image" src="{{asset('assets/images/ajax_loader_red.gif')}}" alt="Loading..." style="width: 50px; height: 50px;      position: absolute;  left:47.6%;   top: 50%;"/>
       <a href="javascript:void(0)" rel="nofollow" class="tfu-cancel-loading" style="display: none">Cancel</a>
   </div>

    <?php /*
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="ns" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) --> */ ?>

    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MZ72J75B"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

     <?php /*
     <div class="page-loader">
          <div class="spinner"></div>
          <div class="txt">Trays<br>4us</div>
     </div> */
     //echo "<pre>";print_r(Session::get('is_customer'));exit;

     ?>
        <div class="ftu-content-wrapper">
            <?php /*
            @if(Session::has('is_customer') && !empty(Session::get('is_customer')))
                @if((empty(Session::get('is_customer')->shiping_address1) && empty(Session::get('is_customer')->shiping_address2)) || empty(Session::get('is_customer')->company ))
                    <div class="col-md-12">
                        <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                            <strong>Complete your profile to see products tailored to your preferences. <a href="{{route('customer-profile')}}" class="ftu-btn-block" >Click here</a></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            @endif */ ?>

             @include('partials.frontend.header')
             @yield('content')
        </div>
         @include('partials.frontend.footer')
         @include('partials.frontend.footer-js')
	     @include('partials.frontend.common-js')
	     @stack('scripts')

         <div class="modal fade tfu-popup-size" id="tfu_general_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <div class="modal-dialog" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h4 class="modal-title" id="tfu_general_header"></h4>
                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">x</button>
                     </div>

                     <div class="modal-body row" id="tfu_general_body">

                     </div>

                 </div>
             </div>
         </div>

   </body>
</html>
