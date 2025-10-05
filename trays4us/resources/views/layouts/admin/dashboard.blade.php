<!DOCTYPE html>

<html lang="en">

   <head>

       @include('partials.admin.headers-style')

       @stack('styles')

   </head>

   <body>
       <div id="loading" style="display: none; background-color: #0003;">
           <img id="loading-image" src="{{asset('assets/images/ajax_loader_red.gif')}}" alt="Loading..." style="width: 50px; height: 50px; margin: 350px;"/>
       </div>
      <div class="main-wrapper">

         @include('partials.admin.header')

         @include('partials.admin.left-sidebar')

         <div class="page-wrapper">

            <div class="content container-fluid">

			    @include('partials.flash-message')

				@yield('content')

            </div>

         </div>

      </div>

    @include('partials.admin.footer-js')

	@include('partials.admin.common-js')

	@stack('scripts')


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

