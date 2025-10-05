@extends('Layouts.Users')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-8 ">
                                <h4 class="card-title"><span class="icon-space"><i class="fa fa-lock" aria-hidden="true"></i></span>{{ __('trans.list_of_permission') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>{{ __('trans.route') }}</th>
                                <th>{{ __('trans.name') }}</th>
                                <th>{{ __('trans.status') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($permissions as $permission)
                                <tr class="mt-2 mb-2">
                                    <td>{{ $permission->route }}</td>
                                    <td>{{ $permission->permission }}</td>
                                    <td><span class="badge @if($permission->status == '1'){{'badge-success'}}@elseif($permission->status=='0'){{'badge-danger'}}@endif">{{ getStatus($permission->status) }}</span></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
