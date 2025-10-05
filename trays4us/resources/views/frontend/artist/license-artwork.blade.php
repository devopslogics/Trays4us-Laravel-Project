@extends('layouts.frontend')
@push('styles')
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('/assets/frontend-assets/css/slick.css') }}"/>
@endpush

<?php // The will be used only for SEO purpose ?>
@push('structured_data_markup')
<script type="application/ld+json">{
  "@context": "https://schema.org",
   "@type": "Organization",
    "url":"{{url()->current()}}",
    "name":"{{$page_title}}",
    "description":"{{$page_description}}",
    "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{url()->current()}}",
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
          "name": "LICENSE ARTWORK",
          "item": "{{ route('license-artwork') }}"
        }
      ]
    }
  }
}
 </script>


@endpush

@section('content')

    <section  class="tfu-license-artwork-wrapper">
        <div class="container-fluid">

            <div class=" tfu-general-breadcumb-wrapper" >
                {{-- <ul class="shop-breadcrumb">
                    <li><a href="#" >License Artwork </a></li>
                    <li><a href="#"></a></li>
                </ul> --}}
                <div class="tfu-general-heading" >
                    <h1>LICENSE ARTWORK</h1>
                </div>

                <ul class="shop-breadcrumb">
                    <li><a href="{{ route('home') }}" > Home </a></li>
                    <li>License Artwork</li>
                </ul>

            </div>


            <div class="row" >
                <div class="col-xl-12  tfu-license-artwork-content" >
                    <p>Elevate your retail offerings with our exclusive collection of trays featuring handpicked stock artistry. These trays not only serve as functional and stylish accessories for homes and hospitality, but they also showcase the unique visions of our featured artists. With a blend of premium quality woodwork and captivating imagery, our curated collection of trays is perfect for resellers looking to offer distinctive, art-inspired products and collections. If you are an artists or own the reproduction rights to an amazing artwork, lets connect.  </p>
                    <a class="ftu-common-btn"  href="{{ route('contact-us') }}">CONTACT US</a>
                </div>
            </div>

        </div>
    </section>


    <section class="tfu-featured-artists-wrapper" >
        <div class="container-fluid">
           <div class="row tfu-license-artwork-header" >
                <div class="col-xl-12  " >
                    <h2>STOCK ARTISTS</h2>
                </div>
            </div>

            <div class="row">
                @if ($artists->isNotEmpty())
                    <div id="ajax_load_artists">
                        <div class="col-xl-12">
                        @foreach($artists as $artist)
                            <div class="tfu-artwork-slider-handler" >
                                <div class="tfu-artwork-slider-for">
                                    <div class="row tfu-slider-artwork-handler">
                                       <div class="col-12 col-sm-6  col-md-5  col-lg-4  col-xl-4 col-xxl-3">
                                          <div class="licence_author_img">
                                                @if( !empty($artist->artist_photo) && \Storage::disk('uploads')->exists('/users/' .$artist->artist_photo))
                                                    <img src="{{ url('uploads/users/'.$artist->artist_photo) }}" alt="{{$artist->artist_photo ?? ''}}" />
                                                @else
                                                    <img src="{{ asset('/assets/frontend-assets/images/no-image.png') }}"  />
                                                @endif
                                            </div>
                                            <p>Designs by this artist:</p>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-5 col-lg-8 col-xl-8 col-xxl-9">

                                            @if( !empty($artist->artist_logo) && \Storage::disk('uploads')->exists('/users/' .$artist->artist_logo))
                                                <div class="licence_author_logo">
                                                    <a href="{{ route('artist-detail',['slug' =>$artist->artist_slug ]) }}">
                                                        <img src="{{ url('uploads/users/'.$artist->artist_logo) }}" alt="{{$artist->artist_logo ?? ''}}" class="author-logo-handler"/>
                                                    </a>
                                                </div>
                                                @else
                                                <div class="no_licence_author_logo">
                                                </div>
                                            @endif


                                         <div class="licence_author_content">
                                             @if(empty($artist->artist_logo) || !\Storage::disk('uploads')->exists('/users/' .$artist->artist_logo))
                                               <a href="{{ route('artist-detail',['slug' =>$artist->artist_slug ]) }}">
                                                   <h2>{{ $artist->first_name }} {{ $artist->last_name }}</h2>
                                               </a>
                                             @endif
                                            <p>{!!  $artist->description !!}</p>
                                         </div>


                                        </div>
                                    </div>
                                </div>
                                @if ($artist->products->isNotEmpty())
                                    <div class="tfu-slider-position">
                                        <div class="tfu-slider-nav-license-artwork">
                                            @foreach($artist->limited_products as $product)
                                                @if(!empty($product->feature_image) && \Storage::disk('uploads')->exists('/products/' .$product->feature_image))
                                                    <a href="{{ route('product-detail',['slug' => $product->product_slug ]) }}">
                                                        <div>
                                                            <div class="tfu-slider-list-img" >
                                                                <img src="{{ url('uploads/products/small-'.$product->feature_image) }}" alt="{{$product->feature_image ?? ''}}" style="" />
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                        <button class="custom-prev-arrow-artwork"><img src="{{ asset('/assets/frontend-assets/svg/left-arrow.svg') }}" alt="left-arrow.svg" /></button>
                                        <button class="custom-next-arrow-artwork"><img src="{{ asset('/assets/frontend-assets/svg/right-arrow.svg') }}" alt="right-arrow" /></button>
                                    </div>
                                @endif
                          </div>
                        @endforeach
                        </div>
                    </div>
                    <?php /*
                    <div class="tfu-artwork-slider-btn" >
                        <button class="tfu-artwork-slider-submit" id="load_more_btn">See More...</button>
                    </div> */ ?>
                @else
                    <p>Record not found</p>
                @endif
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('/assets/frontend-assets/js/slick.min.js') }}"></script>

    <script type="text/javascript">
        var ENDPOINT = "{{ route('license-artwork') }}";
        var page = 1;

        $('.tfu-slider-nav-license-artwork').slick({
            slidesToShow: 8,
            slidesToScroll: 1,
            arrows: true,
            infinite: true,
            focusOnSelect: false,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    },
                },

                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
            ],
            prevArrow: $('.custom-prev-arrow-artwork'),
            nextArrow: $('.custom-next-arrow-artwork')
        });
        jQuery(document).ready(function(){
            //----------------------------------------------------------------------------------------


            //----------------------------------------------------------------------------------------

            $("#load_more_btn").click(function(){
                page++;
                infinteLoadMore(page);
            });


            function infinteLoadMore(page) {
                $.ajax({
                    url: ENDPOINT + "?page=" + page,
                    type: "get",
                    beforeSend: function () {
                        $('.auto-load').show();
                    }
                })
                    .done(function (response) {
                        $('.auto-load').hide();
                        if(response.record_found == 'yes') {
                            $('#ajax_load_artists').append(response.html);
                            $('.tfu-slider-nav-license-artwork').not('.slick-initialized').slick({
                                slidesToShow: 8,
                                slidesToScroll: 1,
                                arrows: true,
                                infinite: true,
                                focusOnSelect: false,
                                responsive: [
                                    {
                                    breakpoint: 1024,
                                    settings: {
                                        slidesToShow: 5,
                                        slidesToScroll: 1,
                                    },
                                    },
                                    {
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 1,
                                    },
                                    },

                                    {
                                    breakpoint: 576,
                                    settings: {
                                        slidesToShow: 2,
                                        slidesToScroll: 1,
                                    },
                                    },
                                ],
                                prevArrow: $('.custom-prev-arrow-artwork'),
                                nextArrow: $('.custom-next-arrow-artwork')
                            });
                        } else {
                            Swal.fire({
                                reverseButtons: true,
                                title: 'No more artists found',
                                type: 'warning',
                                showCancelButton: true,
                                showConfirmButton : false,
                                cancelButtonText: 'Close',
                                cancelButtonColor: '#808080'
                            }).then((result) => {
                            })
                        }
                    })
                    .fail(function (jqXHR, ajaxOptions, thrownError) {
                        console.log('Server error occured');
                    });
            }

            //-----------------------------------------------------------------------------------------
        });

    </script>

@endpush
