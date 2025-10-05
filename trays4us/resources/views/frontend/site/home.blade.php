<?php
    use Illuminate\Support\Str;
?>

@extends('layouts.frontend')

@push('styles')
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('/assets/frontend-assets/css/slick.css') }}"/>
@endpush

@section('content')
    @if ($homepage_sliders->isNotEmpty())

        <section class="tfu-hero-slider-wrapper" >

            <div class="tfu-slick-carousel">
                @foreach($homepage_sliders as $key => $homepage_slider)

                    @if( !empty($homepage_slider->slider_image) && \Storage::disk('uploads')->exists('/sliders/' . $homepage_slider->slider_image))


                        <div data-url="{{ $homepage_slider->entire_banner_link ?? '' }}" class="{{ !empty($homepage_slider->entire_banner_link) ? 'entire_banner_link' : ''  }}" style="background-image: url('{{url('uploads/sliders/'.$homepage_slider->slider_image)}}');   background-size: cover; background-repeat: no-repeat; background-position: center center; " >
                             <div class="tfu-slider-content-cover">

                                <div class="tfu-slide-aligment" style="justify-content: {{ $homepage_slider->slider_direction}};">
                                <div class="tfu-slide-content">
                                    @if($homepage_slider->slider_title_visibility == 1)
                                        @if($key === 0)
                                            <p style="font-size:{{ $homepage_slider->title_size.'px'}}; background-color: {{ $homepage_slider->title_box_color ? $homepage_slider->title_box_color :  'initial'}};">
                                                <a href="{{ $homepage_slider->slider_title_link ?? 'javascript:void(0)' }}" style="color: {{ $homepage_slider->title_color }}; text-decoration: none;" rel="nofollow">{{ $homepage_slider->slider_title }}</a>
                                            </p>
                                        @else
                                            <p style="font-size:{{ $homepage_slider->title_size.'px'}}; background-color: {{ $homepage_slider->title_box_color ? $homepage_slider->title_box_color :  'initial'}};">
                                                <a href="{{ $homepage_slider->slider_title_link ?? 'javascript:void(0)' }}" style="color: {{ $homepage_slider->title_color }}; text-decoration: none;" rel="nofollow">{{ $homepage_slider->slider_title }}</a>
                                            </p>
                                        @endif
                                    @endif

                                    @if($homepage_slider->shop_now_link && $homepage_slider->shop_btn_text)
                                        <button class="tfu-shop-now" > <a href="{{$homepage_slider->shop_now_link}}" > {{ $homepage_slider->shop_btn_text }} </a></button>
                                    @endif

                                    <ul class="tfu-breadcumb-slider-home" style="padding: 8px 20px; background-color: {{ $homepage_slider->label_box_color ? $homepage_slider->label_box_color :  'transparent'}};">

                                        @if($homepage_slider->first_label && $homepage_slider->first_link)
                                            <li><a href="{{$homepage_slider->first_link}}" style="color: {{$homepage_slider->label_color}} !important;font-size:{{$homepage_slider->label_text_size}}px">{{$homepage_slider->first_label}}</a></li>
                                        @endif

                                        @if($homepage_slider->second_label && $homepage_slider->second_link)
                                            <li><a href="{{$homepage_slider->second_link}}"  style="color:{{ $homepage_slider->label_color}} !important;font-size:{{$homepage_slider->label_text_size}}px">{{$homepage_slider->second_label}}</a></li>
                                       @endif

                                       @if($homepage_slider->third_label && $homepage_slider->third_link)
                                            <li><a href="{{$homepage_slider->third_link}}"  style="color:{{ $homepage_slider->label_color}} !important;font-size:{{$homepage_slider->label_text_size}}px">{{$homepage_slider->third_label}}</a></li>
                                       @endif

                                    </ul>
                                </div>
                              </div>

                              </div>
                        </div>

                    @endif
                @endforeach
            </div>

            <button class="custom-prev-arrow"><img src="{{ asset('/assets/frontend-assets/svg/left-arrow.svg') }}" alt="left-arrow.svg" /></button>
            <button class="custom-next-arrow"><img src="{{ asset('/assets/frontend-assets/svg/right-arrow.svg') }}"  alt="right-arrow" /></button>
        </section>
    @endif
    <?php /*
    <section class="tfu-create-custom-wrapper" >
        <div class="container-fluid">

            <div class="row" >
                <div class="col-xl-12  tfu-create-custom-content" >
                    <h1>Create Your Own Custom Wooden Trays & Coasters </h1>
                    <p>Introducing our custom wooden trays – a harmonious blend of functionality and personalization for resellers seeking unique, exclusive offerings. These trays boast a dual purpose, featuring exquisite designs and practical functionality. Built from FSC certified birch wood and coated with matte melamine, these are sure to last a long time. Resellers can add their logo on the back of the tray.
                        <a href="{{ route('create-custom') }}">Learn more</a> </p>
                </div>
            </div>


            <div class="row justify-content-center align-items-baseline" >


                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 tfu-c-tray" >

                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <img src="{{ asset('/assets/frontend-assets/images/round-tray.png') }}" alt="round-tray.png"  />

                        </div>

                        <p>Round 15.7" </p>
                        <p>Tray</p>
                        <span>R157</span>

                    </div>

                </div>

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2  tfu-c-tray"  >

                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <img src="{{ asset('/assets/frontend-assets/images/1612-rectangle-tray.png') }}"  alt="1612-rectangle-tray.png" />

                        </div>

                        <p>Large 16.5"x12.5" </p>
                        <p>Tray</p>
                        <span>1612</span>

                    </div>

                </div>

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 tfu-c-tray"  >

                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <img src="{{ asset('/assets/frontend-assets/images/1108-rectangle-tray.png') }}" alt="1108-rectangle-tray.png"  />

                        </div>

                        <p>Medium 11"x8"</p>
                        <p>Tray</p>
                        <span>1108</span>

                    </div>

                </div>

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 tfu-c-tray"  >

                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <img src="{{ asset('/assets/frontend-assets/images/1105-rectangle-tray.png') }}" alt="1105-rectangle-tray.png"  />

                        </div>

                        <p>Small 11"x5"</p>
                        <p>Tray</p>
                        <span>1105</span>

                    </div>

                </div>

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 tfu-c-tray"   >

                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <img src="{{ asset('/assets/frontend-assets/images/f8b2eb8a59003208d6d740726bb47068.png') }}" alt="f8b2eb8a59003208d6d740726bb47068.png"  />

                        </div>
                       <p>Squared 4"x4"</p>
                        <p>Coaster</p>

                        <span>4x4</span>

                    </div>

                </div>

            </div>


            <div class="row justify-content-center align-items-baseline  ftu-tray-row" >

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 tfu-c-tray"  >

                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <img src="{{ asset('/assets/frontend-assets/images/tfu-tray-c1.png') }}" alt="tfu-tray-c1.png"  />

                        </div>

                        <p>Round 15.7" </p>
                        <p>Tray</p>
                        <span>R157</span>

                    </div>

                </div>

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 tfu-c-tray"  >

                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <img src="{{ asset('/assets/frontend-assets/images/tfu-tray-c2.png') }}" alt="tfu-tray-c2.png"  />

                        </div>

                        <p>Large 16.5"x12.5"  </p>
                        <p>Tray</p>
                        <span>1612</span>

                    </div>

                </div>

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 tfu-c-tray"   >

                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <img src="{{ asset('/assets/frontend-assets/images/tfu-tray-c3.png') }}" alt="tfu-tray-c3.png"  />

                        </div>

                        <p>Medium 11"x8" </p>
                        <p>Tray</p>
                        <span>1108</span>

                    </div>

                </div>

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 tfu-c-tray"  >

                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <img src="{{ asset('/assets/frontend-assets/images/tfu-tray-c4.png') }}" alt="tfu-tray-c4.png"  />

                        </div>

                        <p>Small 11"x5" </p>
                        <p>Tray</p>
                        <span>1105</span>

                    </div>

                </div>

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 tfu-c-tray"  >

                    <div class="tfu-inner-custom-product" >

                        <div class="tfu-inner-custom-image" >

                            <img src="{{ asset('/assets/frontend-assets/images/tfu-tray-c5.png') }}" alt="tfu-tray-c5.png"  />

                        </div>

                        <p>Squared 4"x4"</p>
                        <p>Coaster</p>
                        <span>4x4</span>

                    </div>
                </div>
            </div>


        </div>
    </section>

    <section class="tfu-featured-artists-wrapper" >
        <div class="container-fluid">
            <div class="row" >
                <div class="col-xl-12  tfu-featured-artists-content" >
                    <h2>FEATURED ARTISTS</h2>
                </div>
            </div>
            @php
                $count = count($artists);
            @endphp
            <div class="tfu-slick-carousel-artists">
                @for ($i = 0; $i < $count; $i++)
                    @if ($i % 2 === 0)
                    <div>
                        <div class="tfu-slide-artists-content">
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" >
                                    <div class="tfu-slider-for">
                                        <div class="row tfu-slider-artists-handler">
                                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
                                              <div class="tfu-slider-logo" >

                                                 @if( !empty($artists[$i]->artist_logo) && \Storage::disk('uploads')->exists('/users/' .$artists[$i]->artist_logo))
                                                      <a href="{{ route('artist-detail',['slug' => $artists[$i]->artist_slug ]) }}">
                                                        <img src="{{ url('uploads/users/'.$artists[$i]->artist_logo) }}" alt="{{$artists[$i]->artist_logo ?? ''}}"/>
                                                      </a>

                                                 @endif

                                               </div>

                                                @if(empty($artists[$i]->artist_logo))
                                                    <a href="{{ route('artist-detail',['slug' => $artists[$i]->artist_slug ]) }}">
                                                       <h2>{{ $artists[$i]->display_name }}</h2>
                                                    </a>
                                                @endif


                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                <a href="{{ route('artist-detail',['slug' => $artists[$i]->artist_slug ]) }}">
                                                    <p>{!!  Str::limit($artists[$i]->description, 100)!!}</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tfu-home-slider-nav-handler" >
                                        <div class="tfu-slider-nav-left">
                                            @if($artists[$i])
                                                @foreach($artists[$i]->products as $product)
                                                    <a href="{{ route('product-detail',['slug' => $product->product_slug ]) }}">
                                                        <div>
                                                            <div class="slider-list-img" ><img  src="{{ url('uploads/products/small-'.$product->feature_image) }}" alt="{{$product->feature_image ?? ''}}"  /></div>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button class="left-custom-prev-arrow-artists"><img src="{{ asset('/assets/frontend-assets/svg/left-arrow.svg') }}" alt="left-arrow.svg" /></button>
                                        <button class="left-custom-next-arrow-artists"><img src="{{ asset('/assets/frontend-assets/svg/right-arrow.svg') }}" alt="right-arrow" /></button>
                                  </div>
                                </div>
                    @endif


                                @if ($i % 2 == 1)

                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" >
                                    <div class="tfu-slider-for">
                                        <div class="row tfu-slider-artists-handler">
                                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
                                              <div class="tfu-slider-logo" >

                                               @if( !empty($artists[$i]->artist_logo) && \Storage::disk('uploads')->exists('/users/' .$artists[$i]->artist_logo))
                                                  <a href="{{ route('artist-detail',['slug' => $artists[$i]->artist_slug ]) }}">
                                                    <img src="{{ url('uploads/users/'.$artists[$i]->artist_logo) }}"  alt="{{$artists[$i]->artist_logo ?? ''}}"/>
                                                  </a>
                                               @endif

                                              </div>
                                                @if(empty($artists[$i]->artist_logo))

                                                    <a href="{{ route('artist-detail',['slug' => $artists[$i]->artist_slug ]) }}">
                                                        <h2>{{ $artists[$i]->display_name }}</h2>
                                                     </a>

                                                @endif


                                             </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                <a href="{{ route('artist-detail',['slug' => $artists[$i]->artist_slug ]) }}">
                                                    <p>{!!  Str::limit($artists[$i]->description, 100)!!}</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tfu-home-slider-nav-handler" >
                                        <div class="tfu-slider-nav-right">
                                            @if($artists[$i])
                                                @foreach($artists[$i]->products as $product)
                                                    <a href="{{ route('product-detail',['slug' => $product->product_slug ]) }}">
                                                        <div> <div class="slider-list-img" ><img  src="{{ url('uploads/products/small-'.$product->feature_image) }}" alt="{{$product->feature_image ?? ''}}" /></div></div>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button class="right-custom-prev-arrow-artists"><img src="{{ asset('/assets/frontend-assets/svg/left-arrow.svg') }}" alt="left-arrow.svg"  /></button>
                                        <button class="right-custom-next-arrow-artists"><img src="{{ asset('/assets/frontend-assets/svg/right-arrow.svg') }}" alt="right-arrow"  /></button>
                                   </div>
                                </div>

                                @endif


                            @if ($i % 2 === 1 || $i === $count - 1)

                            </div>
                        </div>
                    </div>
                    @endif
                @endfor
            </div>

            <button class="custom-prev-arrow-artists"><img src="{{ asset('/assets/frontend-assets/svg/left-arrow.svg') }}"  /></button>
            <button class="custom-next-arrow-artists"><img src="{{ asset('/assets/frontend-assets/svg/right-arrow.svg') }}" alt="right-arrow" /></button>

        </div>

    </section>

    <section  class="ftu-product-wholesale-wrapper">
        <div class="container-fluid">
            <div class="row">
                @if ($products->isNotEmpty())
                    <div id="load_product_ajax">
                        <div class="row load_product_row">
                        @foreach($products as $product)
                                @php

                                    $getProductTypeDetail = array();
                                    if(isset($product->pt_sub_id) AND $product->pt_sub_id > 0)
                                      $getProductTypeDetail  = \App\Traits\Definations::getProductTypeDetail($product->pt_sub_id);

                                     // Get minimam order quantity and case pack from customizable_type_relation table
                                     $moq_case_pack = array();
                                     if(isset($product->product_customizable) AND isset($product->pt_sub_id))
                                        $moq_case_pack  = \App\Models\Helper::get_moq_case_pack($product->product_customizable,$product->pt_sub_id);

                                @endphp
                            <div class="col-lg-3 col-sm-4  col-6 product_wrapper" data-pid="{{$product->pid}}" id="product_{{$product->pid}}">
                                <div class="tfu-card-wrapper">
                                    <div class="tfu-card-header">
                                        <a href="{{ route('product-detail',['slug' => $product->product_slug ]) }}">
                                        @if($product->badge && $product->color)
                                            <div class="tfu-card-product-ribbon"  >
                                                <div class="tfu-ribbon tfu-ribbon-top-left"><span style = "background:{{$product->color}};" >{{$product->badge}}</span></div>
                                            </div>
                                        @endif

                                            <div class="tfu-product-card-img">
                                                <img class="card-img" src="{{ url('uploads/products/medium-'.$product->feature_image) }}" alt="{{$product->feature_image ?? '' }}">
                                            </div>
                                        </a>
                                        <div class="tfu-card-img-overlay d-flex justify-content-end">
                                            @if(Session::has('is_customer') && !empty(Session::get('is_customer')))
                                                @php
                                                    $alreadyInWishlist = isset($product->wid) && ($product->wid > 0);
                                                    $wishlist_icon_name = 'whishlist-without-heart.svg';
													$already_wish_list_cls = "";
                                                    if($alreadyInWishlist) {
                                                        $wishlist_icon_name = 'whishlist-heart.svg';
														$already_wish_list_cls = "already_wish_list";
													}

                                                @endphp
                                                <a href="javascript:void(0)" class="tfu_add_wish_list {{ $already_wish_list_cls }}"  rel="nofollow" data-pid="{{ $product->pid }}">
                                                    <img src="{{ asset('/assets/frontend-assets/svg/'.$wishlist_icon_name) }}" alt="{{ $wishlist_icon_name ?? ''}}">
                                                </a>
                                            @else
                                                <a href="javascript:void(0)" class="tfu_add_wish_list_popup"  rel="nofollow">
                                                    <img src="{{ asset('/assets/frontend-assets/svg/whishlist-without-heart.svg') }}" alt="whishlist-without-heart.svg">
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <a href="{{ route('product-detail',['slug' => $product->product_slug ]) }}">
                                            <h3 class="tfu-card-title"> {!! Str::limit($product->product_name, 20, ' ...') !!}</h3>
                                        </a>

                                        <h4 class="tfu-card-subtitle" >{{$product->display_name}}</h4>

                                        <div class="row" >

                                            <div class="col-xl-12">
                                                <h6 class="tfu-card-subtitle-span">{{ $getProductTypeDetail->child->type_name ?? '' }}  {{ $getProductTypeDetail->type_name ?? ''}}<br> <span>{{$product->product_sku}}</span></h6>
                                                @if(Session::has('is_customer') && !empty(Session::get('is_customer')))
                                                    <div class="tfu-buy-cart-price">
                                                        @php

                                                            $isAddedToCart = ($product->cid ?? 0) > 0;
                                                            $quantity =  $calculted_price = $already_in_cart_price =  0;
                                                            $add_to_cart_string =  $cart_quantity =  $already_in_cart_item_str = '';
                                                              if($isAddedToCart) {
                                                                   $quantity = (isset($moq_case_pack->case_pack) && $moq_case_pack->case_pack > 0) ? $moq_case_pack->case_pack : 1;
                                                                   $calculted_price = number_format($quantity * $product->price, 2);
                                                                   $add_to_cart_string = 'Add '.$quantity.' more to Cart ($'.$calculted_price.')';
                                                                   $cart_quantity = $product->cart_quantity;
                                                                   $already_in_cart_price =  number_format($cart_quantity * $product->price, 2);
                                                                   $already_in_cart_item_str = $cart_quantity.' items in Cart ($'.$already_in_cart_price.')';
                                                              } else {
                                                                   $quantity = (isset($moq_case_pack->minimum_order_quantity) && $moq_case_pack->minimum_order_quantity > 0) ? $moq_case_pack->minimum_order_quantity : 1;
                                                                   $calculted_price = number_format($quantity * $product->price, 2);
                                                                   $add_to_cart_string = 'Add '.$quantity.' to Cart ($'.$calculted_price.')';
                                                              }

                                                        @endphp
                                                        <div class="tfu-product-price "><h5>${{$product->price}} <span>{{ (isset($site_management->msrp_price) && $site_management->msrp_price > 0 ) ? 'MSRP $'.number_format(ceil($site_management->msrp_price * $product->price),2)  : '' }}</span></h5></div>
                                                        <button data-pid="{{$product->pid}}" style="{{ $isAddedToCart ? 'color: #fff; background-color: #FF6600;' : 'color: #FF6600; background-color: #fff;' }}" class="add_to_cart">{{$add_to_cart_string}} </button>
                                                        <div class="tfu-product-cart-alert">
                                                            <p class="already_item_cart">{{$already_in_cart_item_str}}</p>
                                                        </div>
                                                    </div>
                                                @else
                                                    <h4 class="tfu-cart-product-msrp" >{{ (isset($site_management->msrp_price) && $site_management->msrp_price > 0 ) ? 'MSRP $'.number_format(ceil($site_management->msrp_price * $product->price),2)  : '' }}</h4>
                                                @endif
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                    <div class="col-xl-12" >
                        <button class="tfu-product-load-more" id="load_more_btn">See More...</button>
                    </div>
                @endif
            </div>
        </div>

    </section>
    */

    ?>


<section>
    <div class="tfu-shop-wrapper-btn">
        <h1 style="font-size: 18px;"><a href="{{ route('frontend.products') }}" >View All Designs</a></h1>
    </div>
</section>

@endsection

@push('scripts')
    <script src="{{ asset('/assets/frontend-assets/js/slick.min.js') }}"></script>

    <script type="text/javascript">

        var autoplaySpeed = {{ $site_management->slider_delay }};
        var autoplay = {{ (isset($site_management->slider_auto) && ($site_management->slider_auto == 1)) ? 'true' : 'false' }};
        var ENDPOINT = "{{ route('ajax-home-more-products') }}";

        var page = 1;
        jQuery(document).ready(function(){

            //----------------------------------------------------------------------------------------------------------

            $('.tfu-slick-carousel').slick({
                arrows: true,
                dots: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true ,
                focusOnSelect: false,
                prevArrow: $('.custom-prev-arrow'),
                nextArrow: $('.custom-next-arrow'),
                autoplay: autoplay, // Enable autoplay
                autoplaySpeed: autoplaySpeed,

            });

            $('.tfu-slick-carousel').on('click', '.slick-slide', function(){
                    var url = $(this).data('url');
                    function isValidUrl(url) {
                    var urlPattern = /^https?:\/\/[^\s$.?#].[^\s]*$/i;
                    return urlPattern.test(url);
                 }

                if (isValidUrl(url)) {
                    window.location.href = url;
                }

            });


            $('.your-slider-class').slick({
                arrows: true,
                dots: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true ,
                focusOnSelect: false,
                prevArrow: $('.custom-prev-arrow'),
                nextArrow: $('.custom-next-arrow'),
                autoplay: autoplay, // Enable autoplay
                autoplaySpeed: autoplaySpeed,

            });

            $('.tfu-slick-carousel-artists').slick({
                arrows: true,
                centerPadding: "0px",
                dots: true,
                slidesToShow: 1,
                focusOnSelect: false,

                infinite: true ,
                prevArrow: $('.custom-prev-arrow-artists'),
                nextArrow: $('.custom-next-arrow-artists')
            });

            $('.tfu-slider-nav-left').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                arrows: true,

                focusOnSelect: false,

                responsive: [
                    {
                      breakpoint: 992,
                      settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                      },
                    },
                    {
                      breakpoint: 768,
                      settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                      },
                    },

                    {
                      breakpoint: 576,
                      settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                      },
                    },
                  ],

                prevArrow: $('.left-custom-prev-arrow-artists'),
                nextArrow: $('.left-custom-next-arrow-artists')
            });

            $('.tfu-slider-nav-right').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                arrows: true,
                focusOnSelect: false,

                responsive: [
                    {
                      breakpoint: 992,
                      settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                      },
                    },

                    {
                      breakpoint: 768,
                      settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                      },
                    },

                    {
                      breakpoint: 576,
                      settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                      },
                    },
                  ],

                prevArrow: $('.right-custom-prev-arrow-artists'),
                nextArrow: $('.right-custom-next-arrow-artists')
            });


            //----------------------------------------------------------------------------------------------------------

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
                    if(page <= response.last_page) {
                        $('#load_product_ajax .load_product_row').append(response.html);
                        if(page == response.last_page) {
                            $('#load_more_btn').hide();
                        }
                    }
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
            }

            //----------------------------------------------------------------------------------------------------------

        });

    </script>

@endpush
