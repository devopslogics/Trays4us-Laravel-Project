@extends('layouts.admin.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Edit artist</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('edit-state-submitted') }}" method="post" enctype="multipart/form-data" class="edit_artist_submitted">
                        {{ csrf_field() }}
                        <input type="hidden" name="state_id" value="{{$state->id}}">
                        <input type="hidden" name="cid" value="{{$_GET['cid'] ?? ''}}">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State Name</label>
                                    <input type="text" class="form-control" name="state_name" id="state_name" value="{{$state->state_name}}">
                                </div>
                            </div>


                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary" id="update_state">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
