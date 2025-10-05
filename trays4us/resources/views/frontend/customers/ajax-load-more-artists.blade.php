@if ($artists->isNotEmpty())
    @foreach($artists as $artist)
        <div class="tfu-artwork-slider-handler" >
            <div class="tfu-artwork-slider-for">
                <div class="row tfu-slider-artwork-handler">
                    <div class="col-xl-4 ">
                      <div class="licence_author_img">
                        @if( !empty($artist->artist_photo) && \Storage::disk('uploads')->exists('/users/' .$artist->artist_photo))
                            <img src="{{ url('uploads/users/'.$artist->artist_photo) }}" />
                        @else
                            <img src="{{ asset('/assets/frontend-assets/images/no-image.png') }}"  />
                        @endif
                       </div>
                        <p>Designs by this artist:</p>
                    </div>
                    <div class="col-xl-8">
                        <div class="licence_author_logo">
                            @if( !empty($artist->artist_logo) && \Storage::disk('uploads')->exists('/users/' .$artist->artist_logo))
                                <img src="{{ url('uploads/users/'.$artist->artist_logo) }}" class="author-logo-handler"/>
                            @endif
                        </div>
                        <div class="licence_author_content">
                            <a href="{{ route('artist-detail',['slug' =>$artist->artist_slug ]) }}">
                                <h2>{{ $artist->first_name }} {{ $artist->last_name }}</h2>
                            </a>
                            <p>{!!  Str::limit($artist->description, 400)!!}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if ($artist->products->isNotEmpty())
                <div class="tfu-slider-position">
                    <div class="tfu-slider-nav-license-artwork">
                        @foreach($artist->products as $product)
                            @if(!empty($product->feature_image) && \Storage::disk('uploads')->exists('/products/' .$product->feature_image))
                                <div> <div class="tfu-slider-list-img" ><img src="{{ url('uploads/products/'.$product->feature_image) }}" style="width: 100%;" /></div></div>
                            @endif
                        @endforeach
                    </div>
                    <button class="custom-prev-arrow-artwork"><img src="{{ asset('/assets/frontend-assets/svg/left-arrow.svg') }}" alt="left-arrow.svg"  /></button>
                    <button class="custom-next-arrow-artwork"><img src="{{ asset('/assets/frontend-assets/svg/right-arrow.svg') }}" alt="right-arrow"  /></button>
                </div>
            @endif
        </div>
    @endforeach
@endif
