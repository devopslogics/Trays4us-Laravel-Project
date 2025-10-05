@extends('layouts.frontend')

@section('content')

    <section class="tfu-dashboard-wrapper" >
          <div class=" tfu-general-breadcumb-wrapper" >
            {{-- <ul class="shop-breadcrumb">
                <li><a href="{{ route('my-account') }}" >My Account  </a></li>
                <li><a href="javscript:void(0)"> Details /</a></li>
            </ul> --}}

            <div class="tfu-general-heading" >
                <h1>MY ACCOUNT</h1>
            </div>

       </div>

        {{-- <div class="row" >
            <div class="col-xl-12" >
                <h2 class="ftu-dashboard-title" >Account details</h2>
            </div>
        </div> --}}

        <div class="row   tfu-dashboard-handler" >

            <ul class="tfu-dashboard-menu-link">

                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="{{ route('my-account') }}" class="tfu-active" style="font-weight:800;" >Details</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="{{ route('wishlist') }}">Wishlists</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="{{ route('my-order') }}">Orders</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>
                <li> <a href="{{ route('cart') }}" >Cart</a></li>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="2" height="16" viewBox="0 0 2 16" fill="none">
                    <path d="M1 0.5V16" stroke="black"/></svg></span>

            </ul>

        </div>


        <div class="row" >

            <div class="col-xl-12" >

                <div class="ftu-dashboard-content">
                    <div class="tfu-my-account-btn-handler" >
                     <a href="{{route('customer-profile')}}" class="ftu-btn-block" >Update Account Details</a>
                    </div>

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

