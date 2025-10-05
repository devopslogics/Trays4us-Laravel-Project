@extends('layouts.frontend')
@push('styles')
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('/assets/frontend-assets/css/slick.css') }}"/>
    <style>.tfu-cart-item-check .tfu-add-to-cart-btn span {color: #fff !important;margin-left: 0px !important;}</style>
@endpush
<?php // The will be used only for SEO purpose ?>
@push('structured_data_markup')
    <script type="application/ld+json">
        {!! $structuredData !!}
    </script>
@endpush

@section('content')

    @php
        // Get minimam order quantity and case pack from customizable_type_relation table
        $moq_case_pack = array();
        if(isset($product->product_customizable) AND isset($product->pt_sub_id))
            $moq_case_pack  = \App\Models\Helper::get_moq_case_pack($product->product_customizable,$product->pt_sub_id);


         // This code only will work on customizer means if customer upload from front end their custom images
         $html_class  = '';
        if($product->type == 2) {
            $html_class  = 'rectangle_image';
            if(isset($product->product_sku) AND !empty($product->product_sku))
              $html_class  = \App\Traits\Definations::getCustomProductHtmlClass($product->product_sku);
        }

    @endphp

<section class="ftu-shop-details-wrapper" >
  <div class="container-fluid">

    <div class=" tfu-general-breadcumb-wrapper" >
         <div class="tfu-catalog-heading" >
          <p>PRODUCT DETAIL</p>
        </div>
        <ul class="shop-breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('frontend.products') }}">Products</a></li>
            <li>{!! $product->product_name !!}</li>
        </ul>

    </div>

   <div class="row" >

    <div class="col-12 col-sm-6  col-md-6 col-lg-1 col-xl-1 ftu-p-3" >
        <div class="tfu-product-details-gallery {{ count($product_galleries) > 4 ? 'tfu_gallery_scroll' : '' }} " >
            <div class="tfu-slider-nav">
                @if($product_galleries->isNotEmpty())
                    @foreach($product_galleries as $product_gallery)
                        <div><div class="tfu-product-slider-image-handler" ><img src="{{ url('uploads/products/large-'.$product_gallery->image_name) }}" alt="{{$product->product_name ?? ''}}" /></div></div>
                    @endforeach
                @else
                    <div><div class="tfu-product-image-handler" ><img src="{{ url('uploads/products/large-'.$product->feature_image) }}" alt="{{$product->product_name ?? ''}}" /></div></div>
                @endif

            </div>
        </div>
      </div>

     <div class="col-12 col-sm-6 col-md-6 col-lg-4  col-xl-4 ftu-p-1" >

        <div class="tfu-card-header">
            @if($product->badge && $product->color)
                <div class="tfu-card-product-ribbon"  >
                    <div class="tfu-ribbon tfu-ribbon-top-left"><span style = "background:{{$product->color}};" >{{$product->badge}}</div>
                </div>
            @endif

         <div class=" tfu-slider-single">
            @if($product_galleries->isNotEmpty())
                @foreach($product_galleries as $product_gallery)
                    <div><div class="tfu-product-image-handler" ><img src="{{ url('uploads/products/large-'.$product_gallery->image_name) }}" alt="{{$product->product_name ?? ''}}" /></div></div>
                @endforeach

            @else
                <div><div class="tfu-product-image-handler" ><img src="{{ url('uploads/products/large-'.$product->feature_image) }}" alt="{{$product->product_name ?? ''}}" /></div></div>
            @endif

        </div>

        <div class="tfu-card-img-overlay d-flex justify-content-end">
            <div class="tfu-dropdown">
                <button rel="nofollow" class="tfu-dropdown-toggle" >
                    <img src="{{ asset('/assets/frontend-assets/svg/tfu-product-dropdown-icon.svg')}}" />
                </button>
                <ul class="tfu-dropdown-menu">
                    <li><a href="javascript:void(0)"  rel="nofollow" class="tfu_delete_custom_product tfu_single_delete" data-pid="{{ $product->pid }}">Delete</a></li>
                    <?php /*
                    <li>Copy</li>
                    <li>Edit</li>
                    <li>Make Public</li>
                    <li>Copy link</li> */ ?>
                </ul>
              </div>
            @if(Session::has('is_customer') && !empty(Session::get('is_customer')))
                @php
                    $alreadyInWishlist = isset($product->wid) && ($product->wid > 0);
                    $wishlist_icon_name = 'whishlist-without-heart.svg';
                    if($alreadyInWishlist)
                        $wishlist_icon_name = 'whishlist-heart.svg';
                @endphp
                <a href="javascript:void(0)"  rel="nofollow" class="tfu_add_wish_list {{ $alreadyInWishlist ? 'already_wish_list' : '' }}" data-pid="{{ $product->pid }}">
                    <img src="{{ asset('/assets/frontend-assets/svg/'.$wishlist_icon_name) }}" alt="whishlist-heart.svg">
                </a>
            @else
                <a href="javascript:void(0)"  rel="nofollow" class="tfu_add_wish_list_popup">
                    <img src="{{ asset('/assets/frontend-assets/svg/whishlist-without-heart.svg') }}" alt="whishlist-without-heart.svg">
                </a>
            @endif
        </div>

       </div>
     </div>


       <div class="col-12 col-sm-6  col-md-6 col-lg-7  col-xl-7 ftu-p-2" id="product_{{$product->pid}}">
        <div class="tfu-shop-content-handler tfu_product_qty_wrapper">
            <div class="tfu-shop-details-product-sku" >
                <p>SKU: {{$product->product_sku}}</p>
            </div>

            <div class="tfu-shop-details-product-info">

                <a href="{{ route('artist-detail',['slug' => $product->artist_slug ]) }}" class="tfu_artist_name" style="color: #000"><p> {!! $product->display_name !!}</p></a>
                <h1> {!! $product->product_name !!} by {!! $product->display_name !!}
                    <br>
                    {{ $getProductTypeDetail->child->type_name ?? '' }}
                    {{ $getProductTypeDetail->type_name ?? ''}}
                </h1>
            </div>

            <?php /*
            <div class="tfu-shop-details-product-size" >
                <h4>420 x 320 mm / 16,5” x 12.5”</h4>
            </div> */ ?>
            <div class="tfu-shop-details-product-price" >
                @if(Session::has('is_customer') && !empty(Session::get('is_customer')))
                 <h2>${{$product->price}} <span>{{ (isset($site_management->msrp_price) && $site_management->msrp_price > 0 ) ? 'MSRP $'.number_format(ceil($site_management->msrp_price * $product->price),2)  : '' }}</span></h2>
                @else
                 <h3>{{ (isset($site_management->msrp_price) && $site_management->msrp_price > 0 ) ? 'MSRP $'.number_format(ceil($site_management->msrp_price * $product->price),2)  : '' }}</h3>
                @endif
            </div>

            <div class="tfu-shop-details-order-pack"   >
                <p>Minimum Order {{ (isset($moq_case_pack->minimum_order_quantity) && $moq_case_pack->minimum_order_quantity > 0) ? $moq_case_pack->minimum_order_quantity  : 1 }} </p>
                <p>Case Pack of {{ (isset($moq_case_pack->case_pack) && $moq_case_pack->case_pack > 0) ? $moq_case_pack->case_pack  : 1 }}</p>
            </div>

            <div class="tfu-shop-details-shipping"   >
                <p>Free shipping for orders ${{$site_management->shipping_threshold}}+</p>
                <p> This order will ship from New Hampshire in less than 21 days</p>
            </div>

            @if(Session::has('is_customer') && !empty(Session::get('is_customer')))

            <div class="tfu-shop-details-quantity-cart" >
              <div class="tfu-wrapper-shop-select" >
               <div class="ftu-wrapper-select-quantity">
                   @php

                       $isAddedToCart = ($product->cid ?? 0) > 0;
                       $moq = (isset($moq_case_pack->minimum_order_quantity) && $moq_case_pack->minimum_order_quantity> 0) ? $moq_case_pack->minimum_order_quantity : 1;
                       $case_pack = (isset($moq_case_pack->case_pack) && $moq_case_pack->case_pack > 0) ? $moq_case_pack->case_pack : 1;
                       $selected_quantity = $moq;
                       if($isAddedToCart) {
                            $selected_quantity = $case_pack;
                       }
                       $calculted_price = $selected_quantity * $product->price;
                   @endphp

                    <div class="ftu-select-btn-qty">
                        <span data-qty="{{$selected_quantity}}">{{$selected_quantity}}  (${{$calculted_price}})</span>
                        <img src="{{ asset('/assets/frontend-assets/svg/input-dropdown-icon.svg') }}" alt="input-dropdown-icon.svg" />
                    </div>


                    <div class="ftu-select-content-qty">

                        <ul class="ftu-qty-options">
                            <?php

                                for ($i = 1; $i <= 5; $i++) {
                                    $quantity = $case_pack + $moq;
                                    $calculated_price2 = $quantity * $product->price;

                                ?>
                                <li onclick="updateName(this)" data-qty="{{$quantity}}" >{{$quantity}}  (${{$calculated_price2}})</li>
                                <?php
                                $case_pack += $moq_case_pack->case_pack; // Increment by the original value of case_pack
                            }
                            $p_quantity = $moq_case_pack->minimum_order_quantity;
                            if(isset($product->cart_quantity) AND $product->cart_quantity > 0)
                                $p_quantity = $product->case_pack;
                            ?>
                        </ul>
                        <div class="ftu-qty-input">
                            <input spellcheck="false" data-moq="{{$p_quantity}}" data-cp="{{$moq_case_pack->case_pack}}"  data-price="{{$product->price}}" class="ftu-product-quantity numeric_only" type="text" placeholder="Custom quantity">
                         </div>
                    </div>

                </div>
               </div>

                @php

                    $quantity =  $calculted_price = $already_in_cart_price =  0;
                    $add_to_cart_string =  $cart_quantity =  $already_in_cart_item_str = '';
                    if($isAddedToCart) {
                         $quantity = (isset($moq_case_pack->case_pack) && $moq_case_pack->case_pack> 0) ? $moq_case_pack->case_pack : 1;
                         $calculted_price = number_format($quantity * $product->price, 2);
                         $add_to_cart_string = 'Add <span class="change-quantity-on-selection">'.$quantity.'</span> more to Cart ($<span class="change-price-on-selection">'.$calculted_price.'</span>)';
                         $cart_quantity = $product->cart_quantity;
                         $already_in_cart_price =  number_format($cart_quantity * $product->price, 2);
                         $already_in_cart_item_str = $cart_quantity.' items in Cart ($'.$already_in_cart_price.')';
                    } else {
                         $quantity = (isset($moq_case_pack->minimum_order_quantity) && $moq_case_pack->minimum_order_quantity> 0) ? $moq_case_pack->minimum_order_quantity : 1;
                         $calculted_price = number_format($quantity * $product->price, 2);
                         $add_to_cart_string = 'Add <span class="change-quantity-on-selection">'.$quantity.'</span> to Cart ($<span class="change-price-on-selection">'.$calculted_price.'</span>)';
                    }

                @endphp

                <div class="tfu-cart-item-check" >
                <div class="tfu-add-to-cart-btn">
                    <a href="javascript:void(0)"  rel="nofollow" data-pid="{{$product->pid}}" class="single_add_to_cart">{!! $add_to_cart_string !!}</a>
                </div>
                <span class="already_item_cart">{{$already_in_cart_item_str}}</span>
               </div>

            </div>

            @else

            <div class="tfu-sign-in-product-wrapper">
                <a  href="{{ route('sign-in') }}" class="tfu-sign-in-product-info">Register / Sign In</a>
            </div>
            @endif
       </div>
   </div>
 </div>

 <div class="row" >
    <div class="col-12 col-sm-12  col-md-12 col-lg-12 col-xl-12" >
       <div class="accordion" id="tfuaccordionExample">
           <div class="accordion-item">
               @if($description = $getProductTypeDetail->child->type_description ?? $getProductTypeDetail->type_description)
             <h2 class="accordion-header" id="tfuheadingOne">
               <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                   Specifications
               </button>
             </h2>
             <div id="collapseOne" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
               <div class="accordion-body">
                 <div  class="tfu-product-specifications-wrapper" >
                   {!! $description !!}
                   @php
                       $typeImage = $getProductTypeDetail->child->type_image ?? $getProductTypeDetail->type_image;
                   @endphp
                     <div class="tfu-product-image-spec " >
                        @if(!empty($typeImage) && \Storage::disk('uploads')->exists('/products/' . $typeImage))
                            <img src="{{ url('uploads/products/'.$typeImage) }}" alt="{{$typeImage}}" >
                        @endif
                     </div>
                   </div>
               </div>
             </div>
             @endif
           </div>
       </div>
    </div>
  </div>

    <?php /*
    <div class="tfu-trays-design-option" >
        <select class="form-select form-select-sm" aria-label=".form-select-sm example">
            <option selected>More products with this design</option>
            <option value="1">Round 16” Tray</option>
            <option value="2">Small 11”x5” Tray</option>
            <option value="3">Squared 4”x4” Coaster</option>
        </select>
    </div> */ ?>

    @if($related_products->isNotEmpty())
            <div class="tfu-product-design-wrapper" >
                <h6>Other products with this design:</h6>
                <div class="tfu-product-design-slide-list">
                    @foreach($related_products as $related_product)
                        <div class="tfu-product-design-img">
                            <a href="{{ route('product-detail',['slug' => $related_product->product_slug ]) }}">
                                <img src="{{ url('uploads/products/small-'.$related_product->feature_image) }}" alt="{{$related_product->product_name}}" />
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
      @endif

  </div>
</section>

<section  class="ftu-shop-details-wrapper">
    <div class="container-fluid">
        <div class="row">
            @if ($product_by_artists->isNotEmpty())
                <h2 class="tfu-catalog-product-title" >PRODUCTS</h2>
                <h6>Products by this artist:</h6>
                <div class="row load_product_row">
                        @foreach($product_by_artists as $product)
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

                                            <div class="tfu-product-card-img" >
                                                <img class="card-img" src="{{ url('uploads/products/medium-'.$product->feature_image) }}"  alt="{{$product->product_name}}">
                                            </div>
                                        </a>

                                        <div class="tfu-card-img-overlay d-flex justify-content-end">
                                            @if(Session::has('is_customer') && !empty(Session::get('is_customer')))
                                                @php
                                                    $alreadyInWishlist = isset($product->wid) && ($product->wid > 0);
                                                    $wishlist_icon_name = 'whishlist-without-heart.svg';
                                                    if($alreadyInWishlist)
                                                        $wishlist_icon_name = 'whishlist-heart.svg';
                                                @endphp
                                                <a href="javascript:void(0)"  rel="nofollow" class="tfu_add_wish_list {{ $alreadyInWishlist ? 'already_wish_list' : '' }}" data-pid="{{ $product->pid }}">
                                                    <img src="{{ asset('/assets/frontend-assets/svg/'.$wishlist_icon_name) }}" alt="whishlist-heart.svg">
                                                </a>
                                            @else
                                                <a href="javascript:void(0)"  rel="nofollow" class="tfu_add_wish_list_popup">
                                                    <img src="{{ asset('/assets/frontend-assets/svg/whishlist-without-heart.svg') }}" alt="whishlist-without-heart.svg">
                                                </a>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="card-body">

                                        <a href="{{ route('product-detail',['slug' => $product->product_slug ]) }}">
                                            <h3 class="tfu-card-title"> {!! Str::limit($product->product_name, 20, ' ...') !!}</h3>
                                        </a>

                                        <a href="{{ route('artist-detail',['slug' => $product->artist_slug ]) }}"><h4 class="tfu-card-subtitle" >{!! $product->display_name !!}</h4></a>

                                        <div class="row" >

                                            <div class="col-xl-12">
                                                <h6 class="tfu-card-subtitle-span ">{{ $getProductTypeDetail->child->type_name ?? '' }}  {{ $getProductTypeDetail->type_name ?? ''}}<br> <span>{{$product->product_sku}}</span></h6>
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
                                                            <?php /*
                                                                   <div class="tfu-product-popup-cart" >
                                                                    <a href="javascript:void(0)" class="tfu_add_cart_div" >
                                                                        <img src="{{ asset('/assets/frontend-assets/svg/cart_menu_popup.svg') }}" alt="Vans">
                                                                    </a>
                                                                    <span>Added 12 items to Cart ($238.80)</span>
                                                                 </div> */ ?>
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
            @endif
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <script src="{{ asset('/assets/frontend-assets/js/slick.min.js') }}"></script>

    <script type="text/javascript">
        //----------------------------------------------------------------------------------------------

        $('.tfu-slider-single').slick({
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false,
          infinite: false,
          focusOnSelect: true,
          swipeToSlide: false,
          draggable:false,
          asNavFor: '.tfu-slider-nav',
        });

        $('.tfu-slider-nav').slick({
              slidesToShow: 4,
              slidesToScroll: 1,
              arrows: false,
              asNavFor: '.tfu-slider-single',
              vertical: true,
              verticalSwiping: true,
              focusOnSelect: true,
              swipeToSlide: false,
              draggable:false,
              infinite: false,

              responsive: [
                {
                  breakpoint: 992,
                  settings: {
                    vertical: false,
                    verticalSwiping: false,


                  },
                },

                {
                  breakpoint: 768,
                  settings: {
                    vertical: false,
                    verticalSwiping: false,


                  },
                },

                {
                  breakpoint: 576,
                  settings: {
                    vertical: false,
                    verticalSwiping: false,
                  },
                },
              ],
        });



     //----------------------------------------------------------------------------------------------

    $(document).ready(function () {

        //---------------------------------------------------------------------------------------

        $(document).on("click",".single_add_to_cart",function() {

            var _this = $(this);
            var productId = _this.attr('data-pid');
            // Get MOQ and case pack values from the data attributes
            var moq = parseInt($('.ftu-product-quantity').attr('data-moq')) || 1;
            var casePack = parseInt($('.ftu-product-quantity').attr('data-cp')) || 1;

           // update_nearest_quantity();

            var customQuantity = parseInt($('.ftu-product-quantity').val());

            var quantity = $('.ftu-select-btn-qty span').attr('data-qty');

            if(customQuantity > 0) {
                quantity = customQuantity;
            }

            $.ajax({
                url: "{{ route('add-to-cart') }}",
                type: "POST",
                data: { productId: productId , quantity : quantity, "_token": "{{ csrf_token() }}"},
                success: function(response) {
                    if(response.status == 'success') {
                        _this.addClass('already_cart');
                        //_this.text('Add '+response.case_pack+' to Cart ($'+response.calculted_price+')');
                       // _this.html('Add <span class="change-quantity-on-selection">'+response.only_current_quantity+'</span> more to Cart ($ <span class="change-price-on-selection">'+response.only_current_quantity_price+'</span>)');
                        _this.html('Add <span class="change-quantity-on-selection">' + response.only_current_quantity + '</span> more to Cart ($ <span class="change-price-on-selection">' + response.only_current_quantity_price + '</span>)');

                        $('#product_' + productId + ' .already_item_cart').text(response.current_added_item_quantity + ' items in Cart ($' + response.current_added_item_total_price + ')');

                        _this.css({"background-color": '#FF6600',"color" : "#fff"});
                        $('#item_count').html(response.total_quantity);

                        $('#product_' + productId + ' .already_item_cart').addClass("cart_blinking");
                        setTimeout(function() {
                            $('#product_' + productId + ' .already_item_cart').removeClass("cart_blinking");
                        }, 2000); // 3 seconds (3 blinks at 1s each)
                    }
                },
                error: function(xhr) {
                    // Handle the error (e.g., display an error message)
                    console.error(xhr);
                }
            });
        });


        $('.ftu-wrapper-select-quantity .ftu-product-quantity').on('keydown', function(event) {
            if (event.keyCode === 13) {
                //update_nearest_quantity();
                //update_area_when_custom(); // Update selection area when someone click outside from dropdown area when enter to textfield
            }
        });

        function update_nearest_quantity() {
            var moq = parseInt($('.ftu-product-quantity').attr('data-moq')) || 1;
            var casePack = parseInt($('.ftu-product-quantity').attr('data-cp')) || 1;
            var productQuantityInput = $('.ftu-product-quantity');
            var customQuantity = parseInt(productQuantityInput.val());
            // alert(moq+'----'+casePack+'----'+customQuantity)
            if (!isNaN(customQuantity)) {
                var nearestMultiple = Math.ceil((customQuantity - moq) / casePack) * casePack + moq;
                if(nearestMultiple < moq)
                    nearestMultiple = moq;
                productQuantityInput.val(nearestMultiple);
            }
        }


    });

    document.addEventListener("click", function (event) {
  const dropdown = event.target.closest(".tfu-dropdown");
  const dropdownMenu = dropdown?.querySelector(".tfu-dropdown-menu");

  // Check if the click is inside a dropdown menu
  const isClickInsideMenu = event.target.closest(".tfu-dropdown-menu");

  // Close other open dropdowns unless the click is inside the current menu
  if (!isClickInsideMenu) {
    document.querySelectorAll(".tfu-dropdown-menu").forEach((menu) => {
      if (menu !== dropdownMenu) menu.style.display = "none";
    });
  }

  if (dropdown && dropdownMenu && !isClickInsideMenu) {
    // Toggle dropdown visibility
    dropdownMenu.style.display =
      dropdownMenu.style.display === "block" ? "none" : "block";
  } else if (!dropdown) {
    // Close dropdown if clicked outside
    document.querySelectorAll(".tfu-dropdown-menu").forEach((menu) => {
      menu.style.display = "none";
    });
  }
});


    </script>

@endpush

