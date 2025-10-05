@extends('layouts.admin.dashboard')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">All State</h3>
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
                        <table class="table table-hover table-center mb-0" id="items">
                            <thead>
                            <tr>
                                <th>State Name</th>
                                <th>Date</th>
                                <th class="text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if ($states->isNotEmpty())
                                    @foreach($states as $state)
                                        @php
                                            $row_status_class = '';
                                             if($state->status == 0)
                                                  $row_status_class = 'table-warning';
                                             if($state->status == 2)
                                                  $row_status_class = 'table-danger';
                                        @endphp
                                        <tr class="{{$row_status_class}}">
                                            <td>{{$state->state_name}}</td>
                                            <td>{{$state->created_at}}</td>
                                            <td class="text-end">

                                                <a href="{{ route('edit-state',['id'=>$state->id,'cid'=>$state->country_id]) }}" class="btn btn-sm bg-success-light mr-1" title="Edit"> <i class="far fa-edit mr-1"></i> </a>

                                                <a href="{{ route('change-state-status',['id'=>base64_encode($state->id.":2")]) }}"
                                                   class="btn btn-sm bg-danger-light mr-1 change_status"
                                                   title="Delete"
                                                   data-msg="Are you sure want to delete">
                                                    <i class="far  fa-trash-alt mr-1"></i>
                                                </a>

                                                @if($state->status == 0)
                                                    <a href="{{ route('change-state-status',['id'=>base64_encode($state->id.":1")]) }}"
                                                       class="btn btn-sm bg-success-light mr-1 change_status"
                                                       title="Activate"
                                                       data-msg="Are you sure want to activate">
                                                        <i class="fas fa-eye-slash"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('change-state-status',['id'=>base64_encode($state->id.":0")]) }}"
                                                       class="btn btn-sm bg-success-light mr-1 change_status"
                                                       title="Deactivate"
                                                       data-msg="Are you sure want to Deactivate">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">Record not found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>

                    {{ $states->links('pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection

