@if($filter_products->isNotEmpty())
    @foreach($filter_products as $product)
            <div class="col-lg-3 col-sm-4  col-6 " >
                <div class="tfu-card-wrapper">
                    <div class="tfu-card-header" >
                        <div class="tfu-product-card-img"  >
                            <img class="card-img" src="{{ url('uploads/products/medium-'.$product->feature_image) }}" alt="Vans">
                        </div>
                        <div class="tfu-card-img-overlay d-flex justify-content-end">
                            @if(Session::has('is_customer') && !empty(Session::get('is_customer')))
                                @php
                                    $alreadyInWishlist = isset($product->wid) && ($product->wid > 0);
                                    $wishlist_icon_name = 'whishlist-without-heart.svg';
                                    if($alreadyInWishlist)
                                        $wishlist_icon_name = 'whishlist-heart.svg';
                                @endphp
                                <a href="javascript:void(0)"  rel="nofollow" class="tfu_add_wish_list {{ $alreadyInWishlist ? 'already_wish_list' : '' }}" data-pid="{{ $product->pid }}">
                                    <img src="{{ asset('/assets/frontend-assets/svg/'.$wishlist_icon_name) }}" alt="Vans">
                                </a>
                            @else
                                <a href="javascript:void(0)"  rel="nofollow" class="tfu_add_wish_list_popup">
                                    <img src="{{ asset('/assets/frontend-assets/svg/whishlist-without-heart.svg') }}" alt="Vans">
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">

                        <a href="{{ route('product',['slug' => $product->pid ]) }}">
                            <h3 class="tfu-card-title"> {!! Str::limit($product->product_name, 20, ' ...') !!}</h3>
                        </a>

                        <h4 class="tfu-card-subtitle" >{{$product->display_name}}</h4>

                        <div class="row" >

                            <div class="col-xl-12">
                                <h6 class="tfu-card-subtitle-span ">{{ $getProductTypeDetail->child->type_name ?? '' }}  {{ $getProductTypeDetail->type_name ?? ''}}<br> <span>{{$product->product_sku}}</span></h6>
                                @if(Session::has('is_customer') && !empty(Session::get('is_customer')))
                                    <div class="tfu-buy-cart-price">
                                        @php
                                            $isAddedToCart = ($product->cid ?? 0) > 0;
                                        @endphp
                                        <button data-pid="{{$product->pid}}" style="{{ $isAddedToCart ? 'color: #fff; background-color: #FF6600;' : 'color: #FF6600; background-color: #fff;' }}" class="add_to_cart"> {{ $isAddedToCart ? 'Add 12 to Cart ($238.80)'  : 'Add 12 to Cart ($238.80)' }}</button>
                                        <div class="tfu-product-price "><h5>${{$product->price}} <span> MSRP $39.90</span></h5></div>
                                    </div>
                                @else
                                <h4 class="tfu-cart-product-msrp" >MSRP $39.90</h4>
                                @endif
                            </div>

                        </div>

                    </div>
                </div>
            </div>
    @endforeach
@endif

