@extends('layouts.admin.dashboard')
@section('content')
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Profile</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('profile-update') }}" method="post" enctype="multipart/form-data" class="">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>First Name</label>
                            <input class="form-control" type="text" name="first_name" value="{{ $user_info->first_name }}">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input class="form-control" type="text" name="last_name" value="{{ $user_info->last_name }}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" type="text" name="email" readonly value="{{ $user_info->email }}">
                        </div>

                        <div class="form-group">
                            <label>Photo</label>
                            <input class="form-control" type="file" name="photo">
                        </div>

                        @if( !empty($user_info->photo) && \Storage::disk('uploads')->exists('/users/' . $user_info->photo))
                            <div class="form-group">
                                <div class="avatar">
                                    <img class="avatar-img" alt src="{{ url('uploads/users/'.$user_info->photo) }}">
                                </div>
                            </div>
                        @endif

                        <div class="mt-4">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
