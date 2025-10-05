@extends('layouts.frontend')

@section('content')


<section class="tfu-discover-wrapper" >

    <div class="container-fluid">

        <div class="row" >

            <div class=" tfu-general-breadcumb-wrapper" >
                <ul class="shop-breadcrumb">
                    <li><a href="#" >Discover</a></li>
                    <li><a href="#" ></a></li>
                </ul>
                <div class="tfu-general-heading" >
                    <h2></h2>
                </div>
            </div>




            <div class="col-xl-12  tfu-discover-content" >


                <h2>DISCOVER</h2>

                <p>Experience the fusion of art and functionality with our wooden trays adorned with captivating artwork, displayed prominently at the point of retail for an immersive consumer experience. Picture an enticing retail setup where these trays, each a canvas of creativity, are elegantly showcased, inviting consumers to explore a world where functionality meets aesthetic appeal.
                    Please find on this page examples of retail displays with our trays, turning everyday essentials into artful expressions.</p>

            </div>

        </div>


    </div>

</section>

<section class="tfu-discover-gallary"  >
    <div class="container-fluid">
        <div class="tfu-discover-images-wrapper" >

            <div class="row" >

                <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3" >
                  <div class="tfu-discover-image" >
                    <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean9.jpg') }}" alt="2023_LLBean9.jpg" />
                  </div>
                </div>

                <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3" >
                  <div class="tfu-discover-image" >
                    <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean10.jpg') }}" alt="2023_LLBean10.jpg" />
                  </div>
                </div>

                <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3" >
                  <div class="tfu-discover-image" >
                    <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean11.jpg') }}" alt="2023_LLBean11.jpg" />
                  </div>
                </div>

                <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3" >
                  <div class="tfu-discover-image" >
                    <img src="{{ asset('/assets/frontend-assets/images/2023_SaraFitz_Instagram.jpg') }}" alt="2023_SaraFitz_Instagram.jpg" />
                  </div>
                </div>

            </div>

            <div class="row " >
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6" >
                  <div class="tfu-discover-image" >
                    <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean.jpg') }}" alt="2023_LLBean.jpg"/>
                 </div>
                </div>

                <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3" >
                 <div class="tfu-discover-image" >
                    <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean12.jpg') }}" alt="2023_LLBean12.jpg"/>
                  </div>
                </div>

                <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3" >
                  <div class="tfu-discover-image" >
                    <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean2.jpg') }}" alt="2023_LLBean2.jpg"/>
                  </div>
                </div>
            </div>

            <div class="row " >
                <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3" >
                    <div class="tfu-discover-image" >
                        <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean3.jpg') }}" alt="2023_LLBean3.jpg"/>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 df-2" >
                    <div class="tfu-discover-image" >
                        <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean5.jpg') }}" alt="2023_LLBean5.jpg"/>
                      </div>
                </div>

                <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3 df-1" >
                    <div class="tfu-discover-image" >
                        <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean4.jpg') }}" alt="2023_LLBean4.jpg"/>
                      </div>
                </div>
            </div>

            <div class="row " >

                <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3" >
                    <div class="tfu-discover-image" >
                        <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean8.jpg') }}" alt="2023_LLBean8.jpg"/>
                      </div>
                </div>

                <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3" >
                   <div class="tfu-discover-image" >
                        <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean6.jpg') }}" alt="2023_LLBean6.jpg"/>
                    </div>
                </div>

                <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3" >
                  <div class="tfu-discover-image" >
                    <img src="{{ asset('/assets/frontend-assets/images/2023_LLBean7.jpg') }}" alt="2023_LLBean7.jpg"/>
                  </div>
                </div>

                <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3" >

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
