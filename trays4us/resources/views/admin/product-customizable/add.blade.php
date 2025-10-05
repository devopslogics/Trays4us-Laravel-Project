@extends('layouts.admin.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Add Design type</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('add-product-customizable-submitted') }}" method="post" enctype="multipart/form-data" class="add_theme_submitted">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Design Name</label>
                                    <input type="text" class="form-control" name="design_type" value="{{old('design_type')}}">
                                </div>
                            </div>

                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('product-customizable') }}" class="btn btn-link">Cancel</a>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection
