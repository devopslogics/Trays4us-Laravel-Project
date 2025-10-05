@extends('layouts.admin.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Add Product Style</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('add-product-style-submitted') }}" method="post" enctype="multipart/form-data" class="add_theme_submitted">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Style Name</label>
                                    <input type="text" class="form-control" name="style_name" value="{{old('style_name')}}">
                                </div>
                            </div>

                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('product-style') }}" class="btn btn-link">Cancel</a>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection
