@extends('layouts.frontend')
@section('content')

    <section class="tfu-dashboard-wrapper" >

          <div class=" tfu-general-breadcumb-wrapper" >
            {{-- <ul class="shop-breadcrumb">
                <li><a href="{{ route('home') }}" >Home</a></li>
                <li><a href="#">Your Account</a></li>
            </ul> --}}
            <div class="tfu-general-heading" >
                <h1>YOUR ACCOUNT</h1>
            </div>
          </div>

        <div class="row" >
            <div class="col-xl-12" >
                <h2 class="ftu-dashboard-title" >Account details</h2>
            </div>
        </div>

        <div class="row  mb-2 mt-4" >
            <ul class="tfu-dashboard-menu-link">
                <li> <span><img src="{{ asset('/assets/frontend-assets/svg/vertical-line.svg')}}"  alt="vertical-line.svg"  /></span><a href="#home" style="font-weight:800;">Details</a></li>
                <li> <span><img src="{{ asset('/assets/frontend-assets/svg/vertical-line.svg')}}"  alt="vertical-line.svg"/></span><a href="#news">Send Addreses</a></li>
                <li> <span><img src="{{ asset('/assets/frontend-assets/svg/vertical-line.svg')}}"  alt="vertical-line.svg"/></span><a href="#contact">Your Wishlists</a></li>
                <li> <span><img src="{{ asset('/assets/frontend-assets/svg/vertical-line.svg')}}"  alt="vertical-line.svg"/></span><a href="#about">Your Orders</a></li>
                <li> <span><img src="{{ asset('/assets/frontend-assets/svg/vertical-line.svg')}}"  alt="vertical-line.svg"/></span><a href="#about"> Payments</a><span></li>
            </ul>
        </div>

        <div class="row" >
            <div class="col-xl-12" >
                <div class="ftu-dashboard-content">
                    <a href="{{route('customer-profile')}}" class="ftu-btn-block" >Update Profile</a>
                    <h4>Log in</h4>
                    <table>
                        <tr>
                            <td>Name:</td>
                            <td>{{$customer_detail->full_name ? $customer_detail->full_name : ''}}</td>
                        </tr>
                        <tr>
                            <td>E-mail:</td>
                            <td>{{$customer_detail->email ? $customer_detail->email : ''}}</td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td>*************</td>
                        </tr>
                    </table>

                    <h4>Address</h4>
                    <table>
                        <tr>
                            <td>Company:</td>
                            <td>{{$customer_detail->company ? $customer_detail->company : ''}}</td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td>{{$customer_detail->address ? $customer_detail->address : ''}}</td>
                        </tr>
                        <tr>
                            <td>Phone:</td>
                            <td>{{$customer_detail->phone ? $customer_detail->phone : ''}}</td>
                        </tr>
                    </table>

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
