@extends('layouts.admin.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Edit Product Style</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('edit-product-style-submitted') }}" method="post" enctype="multipart/form-data" class="edit_theme_submitted">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$themes->id}}">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Style Name</label>
                                    <input type="text" class="form-control" name="style_name" value="{{$themes->style_name}}">
                                </div>
                            </div>

                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('product-style') }}" class="btn btn-link">Cancel</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
