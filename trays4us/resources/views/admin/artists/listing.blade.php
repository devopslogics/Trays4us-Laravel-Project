@extends('layouts.admin.dashboard')

@section('content')

    <div class="page-header">

        <div class="row">

            <div class="col">

                <h3 class="page-title">All Artists</h3>

            </div>

            <div class="col-auto text-right">

                <a href="{{ route('sort-artist') }}" class="btn btn-primary add-button ml-3">
                    <i class="fa-solid fa-sort"></i>
                </a>

                <a class="btn btn-white filter-btn" href="javascript:void(0);"  rel="nofollow" id="filter_search">
                    <i class="fas fa-filter"></i>
                </a>

                <a href="{{ route('add-artist') }}" class="btn btn-primary add-button ml-3">
                    <i class="fas fa-plus"></i>
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

                            <label>Status</label>

                            <select class="form-control" name="status">

                                <option value="">Select Status</option>

                                <option value="1" {{ (isset($_GET['status']) AND $_GET['status'] == 1) ? 'selected' : ''}}>Active</option>

                                <option value="0" {{(isset($_GET['status']) AND $_GET['status'] == '0') ? 'selected' : ''}}>Inactive</option>

                                <option value="2" {{(isset($_GET['status']) AND $_GET['status'] == 2) ? 'selected' : ''}}>Deleted</option>

                            </select>

                        </div>

                    </div>



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

                                <th>Artist Name</th>

                                <th>E-mail</th>

                                <th>Artist Display Name</th>

                                <th>Artist Photo</th>

                                <th>Postal Code</th>

                                <th>Last Updated</th>

                                <th class="text-end">Action</th>

                            </tr>

                            </thead>

                            <tbody>

                                @if ($artists->isNotEmpty())

                                    @foreach($artists as $artist)

                                        <tr>

                                            <td>{{$artist->first_name.' '.$artist->last_name}}</td>

                                            <td>{{$artist->artist_email}}</td>

                                            <td>{{$artist->display_name}}</td>

                                            <td> <img class="avatar-img rounded" alt src="{{ url('uploads/users/'.$artist->artist_photo) }}" width="50px"></td>

                                            <td>{{$artist->postal_code}}</td>

                                            <td>{{$artist->updated_at}}</td>

                                            <td class="text-end">

                                                <a href="{{ route('edit-artist',['id'=>$artist->id]) }}" class="btn btn-sm bg-success-light mr-1 edit_cat" title="Edit"> <i class="far fa-edit mr-1"></i> </a>



                                                <a href="{{ route('change-artist-status',['id'=>base64_encode($artist->id.":2")]) }}"

                                                   class="btn btn-sm bg-danger-light mr-1 change_status"

                                                   title="Delete"

                                                   data-msg="Are you sure want to delete">

                                                    <i class="far  fa-trash-alt mr-1"></i>

                                                </a>

                                                @if($artist->status == 0)

                                                    <a href="{{ route('change-artist-status',['id'=>base64_encode($artist->id.":1")]) }}"

                                                       class="btn btn-sm bg-success-light mr-1 change_status"

                                                       title="Activate"

                                                       data-msg="Are you sure want to activate">

                                                        <i class="fas fa-eye-slash"></i>

                                                    </a>

                                                @else

                                                    <a href="{{ route('change-artist-status',['id'=>base64_encode($artist->id.":0")]) }}"

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

                    {{ $artists->links('pagination.custom') }}

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

