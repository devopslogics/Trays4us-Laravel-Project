@extends('layouts.admin.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Profile</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <form method="post"  id="update_password" action="{{ route('admin.change-password-save') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="oldpass">Old Password</label>
                                    <input type="password" name="current_password" class="form-control" id="oldpass"  placeholder="Enter Old Password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="newpass">New Password</label>
                                    <input type="password" name="password" class="form-control" id="newpass"  placeholder="Enter New Password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="repeatpass">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" id="repeatpass"  placeholder="Confirm New Password">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



























