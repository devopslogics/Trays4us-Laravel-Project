@extends('layouts.frontend')
@push('styles')
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('/assets/frontend-assets/css/slick.css') }}"/>
@endpush
@section('content')

<section class="ftu-shop-details-wrapper" >
  <div class="container-fluid">

    <div class=" tfu-general-breadcumb-wrapper" >
        <ul class="shop-breadcrumb">
            <li><a href="#" >License Artwork</a></li>
            <li><a href="#">Stock Artists </a></li>
            <li><a href="#">Kate Nelligan </a></li>
            <li><a href="#">1612-10822 </a></li>
        </ul>
    </div>

   <div class="row" >

     <div class="col-lg-6" >
        <div class="slider tfu-slider-single">
            <div><div class="tfu-product-image-handler" ><img src="{{ asset('/assets/frontend-assets/images/trays-flower.png') }}" /></div></div>
            <div><div class="tfu-product-image-handler" ><img src="{{ asset('/assets/frontend-assets/images/10821-R157_Kate Nelligan_Midnight Garden_W 1.png') }}" /></div></div>
            <div><div class="tfu-product-image-handler" ><img src="{{ asset('/assets/frontend-assets/images/round-tray-brown.png') }}" /></div></div>
            <div><div class="tfu-product-image-handler" ><img src="{{ asset('/assets/frontend-assets/images/round-tray.png') }}" /></div></div>
            <div><div class="tfu-product-image-handler" ><img src="{{ asset('/assets/frontend-assets/images/trays-flower.png') }}" /></div></div>
            <div><div class="tfu-product-image-handler" ><img src="{{ asset('/assets/frontend-assets/images/trays-flower.png') }}" /></div></div>
            <div><div class="tfu-product-image-handler" ><img src="{{ asset('/assets/frontend-assets/images/trays-flower.png') }}" /></div></div>
        </div>
     </div>

     <div class="col-lg-6" >
        <div class="tfu-shop-content-handler" >
            <div class="tfu-shop-details-product-info" >
            <h3>Kate Nelligan</h3>
            <h2>Midnight Garden</h2>
            <h5>Tray Rectangle M</h5>
            </div>
            <div class="tfu-shop-details-product-sku" >
                <h4>SKU: 10822-1612</h4>
            </div>
            <div class="tfu-shop-details-product-size" >
                <h4>420 x 320 mm / 16,5” x 12.5”</h4>
            </div>
            <div class="tfu-shop-details-product-price" >
                <h2>$35.00 / item</h2>
            </div>

            <div class="tfu-shop-details-product-quantity" >
                <div class="ftu_qty_inc_dec">
                <i class="ftu-increment" onclick="incrementQty()"><img src="{{ asset('/assets/frontend-assets/svg/lower-arrow.svg') }}" /></i>
                <img class="quanity-line-handler" src="{{ asset('/assets/frontend-assets/svg/quantity-arrow-line.svg') }}" />
                <i class="ftu-decrement" onclick="decrementQty()"><img src="{{ asset('/assets/frontend-assets/svg/upper-arrow.svg') }}" /></i>
                </div>
                <input type="text" name="ftu-qty" maxlength="12" value="1" title="" class="ftu-product-quantity" />
            </div>

            <div class="tfu-shop-details-product-button" >
            <div class="tfu-add-to-cart-btn" ><a href="#" >Add to cart</a></div>
            <div class="tfu-add-to-wishlist-btn" ><a href="#" ><span><img src="{{ asset('/assets/frontend-assets/svg/whishlist-without-heart.svg') }}" /></span>Add to cart</a></div>
            </div>

            <div class="tfu-product-details-gallery">
                <div class="slider tfu-slider-nav">
                    <div><div class="tfu-product-slider-image-handler" ><img src="{{ asset('/assets/frontend-assets/images/trays-flower.png') }}" /></div></div>
                    <div><div class="tfu-product-slider-image-handler" ><img src="{{ asset('/assets/frontend-assets/images/10821-R157_Kate Nelligan_Midnight Garden_W 1.png') }}" /></div></div>
                    <div><div class="tfu-product-slider-image-handler" ><img src="{{ asset('/assets/frontend-assets/images/round-tray-brown.png') }}" /></div></div>
                    <div><div class="tfu-product-slider-image-handler" ><img src="{{ asset('/assets/frontend-assets/images/round-tray.png') }}" /></div></div>
                    <div><div class="tfu-product-slider-image-handler" ><img src="{{ asset('/assets/frontend-assets/images/trays-flower.png') }}" /></div></div>
                    <div><div class="tfu-product-slider-image-handler" ><img src="{{ asset('/assets/frontend-assets/images/trays-flower.png') }}" /></div></div>
                    <div><div class="tfu-product-slider-image-handler" ><img src="{{ asset('/assets/frontend-assets/images/trays-flower.png') }}" /></div></div>
                </div>
            </div>
        </div>

     </div>

   </div>


    <div class="tfu-product-design-wrapper" >
        <h6>More products with this design:</h6>
        <div class="tfu-product-design-slide-list">
          <div class="tfu-product-design-img" ><img src="{{ asset('/assets/frontend-assets/images/10821-R157_Kate Nelligan_Midnight Garden_W 1.png') }}" /></div>
          <div class="tfu-product-design-img" ><img src="{{ asset('/assets/frontend-assets/images/10821-R157_Kate Nelligan_Midnight Garden_W 1.png') }}" /></div>
          <div class="tfu-product-design-img" ><img src="{{ asset('/assets/frontend-assets/images/10821-R157_Kate Nelligan_Midnight Garden_W 1.png') }}" /></div>
          <div class="tfu-product-design-img" ><img src="{{ asset('/assets/frontend-assets/images/10821-R157_Kate Nelligan_Midnight Garden_W 1.png') }}" /></div>
          <div class="tfu-product-design-img" ><img src="{{ asset('/assets/frontend-assets/images/10821-R157_Kate Nelligan_Midnight Garden_W 1.png') }}" /></div>
          <div class="tfu-product-design-img" ><img src="{{ asset('/assets/frontend-assets/images/10821-R157_Kate Nelligan_Midnight Garden_W 1.png') }}" /></div>
          <div class="tfu-product-design-img" ><img src="{{ asset('/assets/frontend-assets/images/10821-R157_Kate Nelligan_Midnight Garden_W 1.png') }}" /></div>
          <div class="tfu-product-design-img" ><img src="{{ asset('/assets/frontend-assets/images/10821-R157_Kate Nelligan_Midnight Garden_W 1.png') }}" /></div>
        </div>
    </div>

    <div class="tfu-slider-position">
        <h6>Featured designs by this artist:</h6>
        <div class="tfu-slider-nav-license-artwork">
            <div>  <div class="tfu-slider-list-img" ><img src="{{ asset('/assets/frontend-assets/images/trays-flower.png') }}" /></div> </div>
            <div>  <div class="tfu-slider-list-img" ><img src="{{ asset('/assets/frontend-assets/images/trays-flower.png') }}" /></div> </div>
            <div>  <div class="tfu-slider-list-img" ><img src="{{ asset('/assets/frontend-assets/images/trays-flower.png') }}" /></div> </div>
            <div>  <div class="tfu-slider-list-img" ><img src="{{ asset('/assets/frontend-assets/images/trays-flower.png') }}" /></div> </div>
            <div>  <div class="tfu-slider-list-img" ><img src="{{ asset('/assets/frontend-assets/images/trays-flower.png') }}" /></div> </div>
            <div>  <div class="tfu-slider-list-img" ><img src="{{ asset('/assets/frontend-assets/images/trays-flower.png') }}" /></div> </div>
            <div>  <div class="tfu-slider-list-img" ><img src="{{ asset('/assets/frontend-assets/images/trays-flower.png') }}" /></div> </div>
            <div>  <div class="tfu-slider-list-img" ><img src="{{ asset('/assets/frontend-assets/images/trays-flower.png') }}" /></div> </div>
            <div>  <div class="tfu-slider-list-img" ><img src="{{ asset('/assets/frontend-assets/images/trays-flower.png') }}" /></div> </div>
            <div>  <div class="tfu-slider-list-img" ><img src="{{ asset('/assets/frontend-assets/images/trays-flower.png') }}" /></div> </div>
        </div>
        <button class="custom-prev-arrow-artwork"><img src="https://hammanitechdemos.com/trays4us/assets/frontend-assets/svg/left-arrow.svg" alt="left-arrow.svg"  /></button>
        <button class="custom-next-arrow-artwork"><img src="https://hammanitechdemos.com/trays4us/assets/frontend-assets/svg/right-arrow.svg"  alt="right-arrow" /></button>
    </div>

  </div>
</section>



{{-- <section  class="ftu-shop-wholesale-wrapper">
    <div class="container-fluid">

        <div class=" tfu-general-breadcumb-wrapper" >
            <ul class="shop-breadcrumb">
                <li><a href="#" >Trays</a></li>
                <li><a href="#">Artist</a></li>
            </ul>
            <div class="tfu-general-heading" >
                <h2>SHOP IN WHOLESALE</h2>
            </div>
        </div>

         <div class="row">
            <div class="col-xl-12" >

              <div class="tfu-shop-filter-wrapper" >

                <div class="tfu-shop-filter-btn" >
                  <button class="tfu-btn-filter">Filter<span><img src="{{ asset('/assets/frontend-assets/svg/filter-plus.svg') }}" /></span></button>
                </div>
                <div id="tfu-shop-filter-handler" class="tfu-shop-filter-popup" >
                  <div class="tfu-shop-filter-content">

                     <form action="#"  method="get" class="tfu-filter-search-form" id="tfu_filter_search_form">
                        <div class="row">
                          <div class="col-xl-12" >
                              <div class="row m-0  d-flex justify-content-between ">

                                <div class="col-xl-2  p-0">
                                  <div class="tfu-filter-check-box-handler" >
                                    <h3>Prduct type</h3>
                                      @if ($product_types->isNotEmpty())
                                          @foreach($product_types as $product_type)
                                              <div class="form-check parent_ptype">
                                                  <input class="form-check-input" type="checkbox" name="parent_type[]" value="{{$product_type->id}}" id="pt_id_{{$product_type->id}}" {{(isset($_GET['parent_type']) && in_array($product_type->id,$_GET['parent_type'])) ? 'checked' : ''}}>
                                                  <label class="form-check-label fw-600" for="pt_id_{{$product_type->id}}">{{$product_type->type_name}}</label>
                                              </div>
                                              @foreach($product_type->childTypes as $childType)
                                                  <div class="form-check child_ptype">
                                                      <input class="form-check-input" type="checkbox" name="child_type[]" value="{{$childType->id}}" id="pt_id_{{$childType->id}}" {{(isset($_GET['child_type']) && in_array($childType->id,$_GET['child_type'])) ? 'checked' : ''}}>
                                                      <label class="form-check-label ms-3" for="pt_id_{{$childType->id}}">{{$childType->type_name}}</label>
                                                  </div>
                                              @endforeach
                                          @endforeach
                                      @endif
                                  </div>
                                </div>
                                <div class="col-xl-3  p-0">
                                    <div class="tfu-filter-check-box-handler" >
                                        <h3>Location</h3>
                                        <div class="form-check-select" >
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" name="country_ck" id="country_ck" {{(isset($_GET['country_ck']) && $_GET['country_ck'] == 1) ? 'checked' : ''}}>
                                                <label class="form-check-label" for="country_ck">Country</label>
                                            </div>
                                            <select class="form-select"  name="country" id="country">
                                                <option value="">Select Country</option>
                                                @foreach($countries as $country)
                                                    <option value="{{$country->id}}" {{(isset($_GET['country']) && $_GET['country'] == $country->id) ? 'selected' : ''}}>{{$country->country_code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-check-select" >
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" name="state_ck" id="state_ck" {{(isset($_GET['state_ck']) && $_GET['state_ck'] == 1) ? 'checked' : ''}}>
                                                <label class="form-check-label" for="state_ck">State</label>
                                            </div>
                                            <select class="form-select" name="state_id" id="state_id">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                @if($artists->isNotEmpty())
                                    <div class="col-xl-2  p-0">
                                        <div class="tfu-filter-check-box-handler" >
                                            <h3>Featured artists</h3>
                                            @foreach($artists as $artists)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="artists[]" value="{{$artists->id}}" id="aritst_id_{{$artists->id}}" {{(isset($_GET['artists']) && in_array($artists->id,$_GET['artists'])) ? 'checked' : ''}}>
                                                    <label class="form-check-label" for="aritst_id_{{$artists->id}}">{{$artists->first_name.' '.$artists->last_name}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if($product_styles->isNotEmpty())
                                  <div class="col-xl-2  p-0">
                                        <div class="tfu-filter-check-box-handler" >
                                            <h3>Style</h3>
                                            @foreach($product_styles as $product_style)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="product_style[]" value="{{$product_style->id}}" id="pr_style_{{$product_style->id}}" {{(isset($_GET['product_style']) && in_array($product_style->id,$_GET['product_style'])) ? 'checked' : ''}}>
                                                    <label class="form-check-label" for="pr_style_{{$product_style->id}}">{{$product_style->style_name}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if($customizables->isNotEmpty())
                                    <div class="col-xl-2  p-0">
                                        <div class="tfu-filter-check-box-handler" >
                                            <h3>Customizable</h3>
                                            @foreach($customizables as $customizable)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="customizable[]" value="{{$customizable->id}}" id="pr_customizable_{{$customizable->id}}" {{(isset($_GET['customizable']) && in_array($customizable->id,$_GET['customizable'])) ? 'checked' : ''}}>
                                                    <label class="form-check-label" for="pr_customizable_{{$customizable->id}}">{{$customizable->customizable_name}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                              </div>
                           </div>
                           <div class="col-xl-12" >
                                 <div class="tfu-shop-search-form" >
                                    <div class="form-group">
                                      <span class="tfu-icon-input-filter-search">
                                        <img src="https://hammanitechdemos.com/trays4us/assets/frontend-assets/svg/search-icon.svg" alt="filter search">
                                      </span>
                                        <input type="text" class="form-control filter-search" name="search_by" id="search_by" placeholder="Search..." value=" {{(isset($_GET['search_by']) && !empty($_GET['search_by'])) ? $_GET['search_by'] : ''}}">
                                    </div>
                                    <div class="form-filter-btn" >
                                     <button type="button" class="ftu-btn-block ftu-filter-search-submit" id="tfu_search_apply" >Apply</button>
                                    <div>
                                 </div>
                               </div>
                            </div>
                         </div>
                       </div>
                    </form>

                  </div>
                </div>

               </div>

            </div>
             <div class="row">
                 @if($products->isNotEmpty())
                   <div id="load_product_ajax">
                       <div class="row load_product_row" id="">
                            @foreach($products as $product)
                                <div class="col-lg-3 col-sm-4  col-6" >
                                    <div class="tfu-card-wrapper">
                                        <div class="tfu-card-header">
                                            <div class="tfu-product-card-img">
                                                <img class="card-img" src="{{ url('uploads/products/'.$product->feature_image) }}" alt="Vans">
                                            </div>
                                            <div class="tfu-card-img-overlay d-flex justify-content-end">
                                                <img  src="{{ asset('/assets/frontend-assets/svg/whishlist-without-heart.svg') }}" alt="Vans">
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h3 class="tfu-card-title"> {!! Str::limit($product->product_name, 20, ' ...') !!}</h3>
                                            <h4 class="tfu-card-subtitle" >{{$product->first_name.' '.$product->last_name}}</h4>

                                            <div class="row" >

                                                <div class="col-xl-5">
                                                    <h6 class="tfu-card-subtitle-span ">{{$product->type_name}}<br><span>{{$product->product_sku}}</h6>
                                                </div>
                                                <div class="col-xl-7">
                                                    @if(Session::has('is_customer') && !empty(Session::get('is_customer')))
                                                        <div class="tfu-buy-cart-price">
                                                            <a href="#" >Add to Cart</a>
                                                            <div class="tfu-product-price "><h5>${{$product->price}} / item</h5></div>
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                       </div>
                   </div>


                 @endif
             </div>
            </div>

     </div>

</section> --}}



@endsection

@push('scripts')
    <script src="{{ asset('/assets/frontend-assets/js/slick.min.js') }}"></script>

    <script type="text/javascript">


     jQuery(document).ready(function(){
            //----------------------------------------------------------------------------------------

            $('.tfu-slider-nav-license-artwork').slick({
                slidesToShow: 8,
                slidesToScroll: 1,
                arrows: true,
                infinite: true,
                focusOnSelect: true,
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

    });

function incrementQty() {
  var value = document.querySelector('input[name="ftu-qty"]').value;
  value = isNaN(value) ? 1 : value;
  value++;
  document.querySelector('input[name="ftu-qty"]').value = value;
}

function decrementQty() {
  var value = document.querySelector('input[name="ftu-qty"]').value;
  value = isNaN(value) ? 1 : value;
  value > 1 ? value-- : value;
  document.querySelector('input[name="ftu-qty"]').value = value;
}


$('.tfu-slider-single').slick({
 	slidesToShow: 1,
 	slidesToScroll: 1,
 	arrows: false,
 	fade: false,
 	adaptiveHeight: true,
 	infinite: false,
	useTransform: true,
 	speed: 400,
 	cssEase: 'cubic-bezier(0.77, 0, 0.18, 1)',
 });

 $('.tfu-slider-nav')
 	.on('init', function(event, slick) {
 		$('.tfu-slider-nav .slick-slide.slick-current').addClass('is-active');
 	})
 	.slick({
 		slidesToShow: 3,
 		slidesToScroll: 3,
 		dots: false,
         arrows: false,
 		focusOnSelect: false,
 		infinite: false,

 	});

 $('.tfu-slider-single').on('afterChange', function(event, slick, currentSlide) {
 	$('.tfu-slider-nav').slick('slickGoTo', currentSlide);
 	var currrentNavSlideElem = '.tfu-slider-nav .slick-slide[data-slick-index="' + currentSlide + '"]';
 	$('.tfu-slider-nav .slick-slide.is-active').removeClass('is-active');
 	$(currrentNavSlideElem).addClass('is-active');
 });

 $('.tfu-slider-nav').on('click', '.slick-slide', function(event) {
 	event.preventDefault();
 	var goToSingleSlide = $(this).data('slick-index');

 	$('.tfu-slider-single').slick('slickGoTo', goToSingleSlide);
 });


    </script>

@endpush

