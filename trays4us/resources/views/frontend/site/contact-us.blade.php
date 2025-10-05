@extends('layouts.frontend')

@section('content')

<?php // The will be used only for SEO purpose ?>
@push('structured_data_markup')
    <script type="application/ld+json">{
          "@context": "https://schema.org",
          "@type": "Organization",
          "name": "Trays4Us",
          "description": "Customizable wholesale kitchen & tabletop products, home accents, and more. Specializing in custom wooden trays with unique artwork, including nautical and vintage charts.",
          "url": "{{ route('contact-us') }}",
          "logo": "{{ url('uploads/users/'.$site_management->website_logo) }}",
          "foundingDate": "2012",
          "location": {
            "@type": "Place",
            "address": {
              "@type": "PostalAddress",
              "addressLocality": "Redwood City",
              "addressRegion": "CA",
              "addressCountry": "USA"
            }
          },
          "contactPoint": [
            {
              "@type": "ContactPoint",
              "contactType": "sales",
              "email": "wholesale@trays4.us"
            }
          ],
          "brand": {
            "@type": "Brand",
            "name": "Trays4Us"
          },
          "slogan": "Customizable wholesale white-labeled wooden trays and coasters.",
          "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "{{ route('contact-us') }}",
            "breadcrumb": {
              "@type": "BreadcrumbList",
              "itemListElement": [
                 {
                      "@type": "ListItem",
                      "position": 1,
                      "name": "Home",
                      "item": "{{ route('home') }}"
                 },
                {
                  "@type": "ListItem",
                  "position": 2,
                  "name": "Contact Us",
                  "item": "{{ route('contact-us') }}"
                }
              ]
            }
          }
        }
    </script>
@endpush

<section class="tfu-discover-wrapper" >


    {{-- <div class=" tfu-general-breadcumb-wrapper" >
        <ul class="shop-breadcrumb">
            <li><a href="#" >Contact Us </a></li>
            <li><a href="#"></a></li>
        </ul>
    </div> --}}

    <div class="row" >
        <div class="col-xl-12  tfu-contact-content" >
            <h1>CONTACT US</h1>
        </div>
    </div>

    <div class="tfu-general-breadcumb-wrapper" >
        <ul class="shop-breadcrumb">
            <li><a href="{{ route('home') }}" > Home </a></li>
            <li>Contact Us</li>
        </ul>
    </div>


    <div class="container">
     <div  class="row" >

      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" >
        <div class="tfu-contact-company-image" >
          <img src="{{ asset('/assets/frontend-assets/svg/Logo Trays4Us.svg') }}" alt="Logo Trays4Us.svg"  />
        </div>
     </div>


       <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6" >
          <div class="tfu-sales-inquiries" >
            <h4>Sales:</h4>
            <a href="mailto:wholesale@trays4.us"><u>wholesale@trays4.us</u></a>
            <a href="tel:6034986283">(603) 498-6283</a>
          </div>
       </div>

       <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6"  >
         <div class="tfu-sales-inquiries  tfu-support-inquiries" >
            <h4>Support:</h4>
            <a href="mailto:info@trays4.us"><u>info@trays4.us</u></a>

            {{-- <div class="ftu-contact-email" >
             <a class="ftu-common-btn" href="mailto:info@trays4.us" >info@trays4.us</a>
            </div> --}}
         </div>
       </div>


       <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"  >
          <p class="tfu-contact-discover" >Please find below examples of retail displays with trays, turning everyday essentials into artful expressions.</p>
       </div>

     </div>
    </div>


</section>


<section class="tfu-discover-gallary"  >

  <div class="container">
    <div class="row" >
        <div class="col-xl-12  tfu-discover-content" >


            <h2>DISCOVER</h2>

            <p>Experience the fusion of art and functionality with our wooden trays adorned with captivating artwork, displayed prominently at the point of retail for an immersive consumer experience. Picture an enticing retail setup where these trays, each a canvas of creativity, are elegantly showcased, inviting consumers to explore a world where functionality meets aesthetic appeal.
                Please find on this page examples of retail displays with our trays, turning everyday essentials into artful expressions.</p>

        </div>
    </div>
</div>


  <div class="container-fluid">
      <div class="tfu-discover-images-wrapper" >

          <div class="row" >

              <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 df-1 tfu-cf" >
                <div class="tfu-discover-image" >
                  <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean9.jpg') }}" alt="2023_LLBean9.jpg"  />
                </div>
              </div>

              <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 df-2 tfu-cf" >
                <div class="tfu-discover-image" >
                  <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean10.jpg') }}" alt="2023_LLBean10.jpg" />
                </div>
              </div>

              <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 df-3 tfu-cf" >
                <div class="tfu-discover-image" >
                  <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean11.jpg') }}" alt="2023_LLBean11.jpg" />
                </div>
              </div>

              <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 df-4 tfu-cf" >
                <div class="tfu-discover-image" >
                  <img src="{{ asset('/assets/frontend-assets/images/2023_SaraFitz_Instagram.jpg') }}" alt="2023_SaraFitz_Instagram.jpg" />
                </div>
              </div>

              <div class="col-12 col-sm-8 col-md-6 col-lg-6 col-xl-6 df-5 tfu-cf" >
                <div class="tfu-discover-image" >
                  <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean.jpg') }}" alt="2023_LLBean.jpg" />
               </div>
              </div>

              <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 df-6 tfu-cf " >
               <div class="tfu-discover-image" >
                  <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean12.jpg') }}" alt="2023_LLBean12.jpg" />
                </div>
              </div>

              <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 df-7 tfu-cf" >
                <div class="tfu-discover-image" >
                  <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean2.jpg') }}" alt="2023_LLBean2.jpg" />
                </div>
              </div>


              <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 df-8 tfu-cf" >
                  <div class="tfu-discover-image" >
                      <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean3.jpg') }}" alt="2023_LLBean3.jpg" />
                  </div>
              </div>

              <div class="col-12 col-sm-8 col-md-6 col-lg-6 col-xl-6 df-9 tfu-cf" >
                  <div class="tfu-discover-image" >
                      <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean5.jpg') }}" alt="2023_LLBean5.jpg" />
                    </div>
              </div>

              <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 df-10 tfu-cf" >
                  <div class="tfu-discover-image" >
                      <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean4.jpg') }}" alt="2023_LLBean4.jpg" />
                    </div>
              </div>


              <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 df-11 tfu-cf" >
                  <div class="tfu-discover-image" >
                      <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean8.jpg') }}"  alt="2023_LLBean8.jpg"/>
                    </div>
              </div>

              <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 df-12 tfu-cf" >
                 <div class="tfu-discover-image" >
                      <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean6.jpg') }}" alt="2023_LLBean6.jpg"/>
                  </div>
              </div>

              <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 df-13 tfu-cf" >
                <div class="tfu-discover-image" >
                  <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean7.jpg') }}" alt="2023_LLBean7.jpg"/>
                </div>
              </div>

              <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3 df-14" >

              </div>

        </div>

      </div>

  </div>
</section>


@endsection


@push('scripts')



    <script type="text/javascript">

        $(document).ready(function() {

        });

    </script>



@endpush
