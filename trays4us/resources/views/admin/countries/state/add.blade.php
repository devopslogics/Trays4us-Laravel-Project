@extends('layouts.admin.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Add artist</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('add-state-submitted') }}" method="post" enctype="multipart/form-data" class="add_artist_submitted">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State Name</label>
                                    <input type="text" class="form-control" name="state_name" id="state_name" value="{{old('state_name')}}">
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="add_artist">Submit</button>
                            </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection
