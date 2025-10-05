@extends('layouts.admin.dashboard')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Theme listing</h3>
            </div>
            <div class="col-auto text-right">
                <a href="{{ route('add-theme') }}" class="btn btn-primary add-button ml-3">
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
                        <table class="table table-hover table-center mb-0" id="items">
                            <thead>
                            <tr>
                                <th>Theme name</th>
                                <th>Date</th>
                                <th class="text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if ($themes->isNotEmpty())
                                    @foreach($themes as $theme)
                                        <tr>
                                            <td>{{$theme->theme_name}}</td>
                                            <td>{{$theme->created_at}}</td>

                                            <td class="text-end">
                                                <a href="{{ route('edit-theme',['id'=>$theme->id]) }}" class="btn btn-sm bg-success-light mr-1 edit_cat"> <i class="far fa-edit mr-1"></i> </a>

                                                <a href="{{ route('change-theme-status',['id'=>base64_encode($theme->id.":2")]) }}"
                                                   class="btn btn-sm bg-danger-light mr-1 change_status"
                                                   title="Delete"
                                                   data-msg="Are you sure want to delete">
                                                    <i class="far  fa-trash-alt mr-1"></i>
                                                </a>
                                                @if($theme->status == 0)
                                                    <a href="{{ route('change-theme-status',['id'=>base64_encode($theme->id.":1")]) }}"
                                                       class="btn btn-sm bg-success-light mr-1 change_status"
                                                       title="Activate"
                                                       data-msg="Are you sure want to activate">
                                                        <i class="fas fa-eye-slash"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('change-theme-status',['id'=>base64_encode($theme->id.":0")]) }}"
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

                    {{ $themes->links('pagination.custom') }}
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
