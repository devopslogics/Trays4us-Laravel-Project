@extends('layouts.admin.dashboard')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">All roles</h3>
            </div>
            <div class="col-auto text-right">
                <a href="{{ route('add-product') }}" class="btn btn-primary add-button ml-3">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0" id="tech-companies-1">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list_roles as $role)
                                <tr class="mt-2 mb-2">
                                    <td>{{ $role->role_name }}</td>
                                    <td><span class="badge @if($role->status == '1'){{'badge-success'}}@elseif($role->status=='0'){{'badge-danger'}}@endif">{{ getStatus($role->status) }}</span></td>
                                    <td width="10%">
                                        <a class="" style="cursor: pointer" onclick="getRoleDetails('{{ $role->id }}')" title="Edit role">
                                            <i class="fas fa-edit fa-2" aria-hidden="true"></i>
                                        </a>

                                        @if($role->status == '1')
                                            <a href="{{ route('change_role_status',['role_id'=>$role->id, 'status'=>'0']) }}" title="DeActivate" class="change_status" message="Are you sure deactivate?">
                                                <i class="fa fa-ban fa-2" aria-hidden="true"></i>
                                            </a>
                                        @elseif($role->status == '0')
                                            <a href="{{ route('change_role_status',['role_id'=>$role->id, 'status'=>'1']) }}" title="Activate" class="change_status" message="Are you sure to change status?">
                                                <i class="fa fa-ban fa-2" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                        @if($role->status == '2')
                                            <a href="{{ route('change_role_status',['role_id'=>$role->id, 'status'=>'1']) }}" title="Restore" class="change_status" message="Are you sure  to restore?">
                                                <i class="fas fa-trash-restore fa-2" aria-hidden="true"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('change_role_status',['role_id'=>$role->id, 'status'=>'2']) }}" title="Delete" class="change_status" message="Are you sure  to delete?">
                                                <i class="fa fa-trash fa-2" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('add_permission',['role_id'=>$role->id]) }}" title="Add permissions">
                                            <i class="fa fa-plus fa-2" aria-hidden="true"></i>
                                        </a>
                                    </td>
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


@push('scripts')

    <script type="text/javascript">
        $(document).ready(function() {


        });
    </script>

@endpush
