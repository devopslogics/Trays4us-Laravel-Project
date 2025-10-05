@extends('layouts.frontend')

@section('content')


    <section class="tfu-discover-wrapper" >

        <div class="col-xl-12  tfu-content-404-logo" >
            <img src="{{ asset('/assets/frontend-assets/images/404-trays4us-error.png') }}" alt="404-trays4us-error.png" />
        </div>
        <div class="container">
            <div  class="row" >
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" >
                  <div class="tfu-content-404-error">
                    <h1>Sorry! Page Not Found!</h1>
                    <p>Oops! The page you are looking for does not exist. Please return to the site’s homepage.</p>
                    <a class="octf-btn octf-btn-third octf-btn-icon" href="{{ route('home') }}">Take Me Home<i class="flaticon-right-arrow-1"></i></a>
                </div>
                </div>

            </div>
        </div>


    </section>

@endsection
