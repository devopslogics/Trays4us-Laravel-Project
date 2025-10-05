@extends('layouts.admin.dashboard')

@section('content')

    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Open Carts</h3>
            </div>
            <div class="col-auto text-right">
                <a class="btn btn-white filter-btn" href="javascript:void(0);" id="filter_search">
                    <i class="fas fa-filter"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="card filter-card" id="filter_inputs" style="display: {{$filter_flag ? 'block' : ''}}">
        <div class="card-body pb-0">
            <form action="" method="get">
                <div class="row filter-row">

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>Search by</label>
                            <input class="form-control" type="text" name="search_by" value="{{ isset($_GET['search_by']) ? $_GET['search_by']: '' }}">
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Search</button>
                            <a href="{{ route('all-orders') }}" class="btn btn-primary btn-block" style="line-height: 34px;">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>User name</th>
                                    <th>Email</th>
                                    <th>Phone#</th>
                                    <th>Shipping address 1</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($cart_items->isNotEmpty())
                                @foreach ($cart_items as $cart_item)
                                    <tr>
                                        <td>{{ $cart_item->first_name.' '.$cart_item->last_name }}</td>
                                        <td>{{ $cart_item->email }}</td>
                                        <td>{{ $cart_item->phone }}</td>
                                        <td>{{ $cart_item->shiping_address1 }}</td>
                                        <td>{{ $cart_item->total_quantity }}</td>
                                        <td>{{ $cart_item->total_price }}</td>
                                        <td class="">
                                            <a href="{{ route('cart-item-detail',['cid'=>$cart_item->id]) }}" class="btn btn-sm bg-success-light mr-1"> <i class="fa fa-info-circle" aria-hidden="true"></i></a>
                                        </td>
                                     </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">Record not found</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    {{ $cart_items->links('pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
    $(document).ready(function() {


    });
</script>

@endpush

