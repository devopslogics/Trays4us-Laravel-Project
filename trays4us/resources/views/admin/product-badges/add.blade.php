@extends('layouts.admin.dashboard')
@push('styles')
    <link rel="stylesheet" href="{{asset('assets/css/evol-colorpicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.min.css')}}">
    <style>
        .evo-cp-wrap{width: 488.656px;display: flex;gap: 10px;}
        .evo-colorind, .evo-colorind-ie, .evo-colorind-ff {border: solid 1px #c3c3c3;width: 25px;height: 25px;float: right;}
        .ui-widget.ui-widget-content {top: 97px;}
        .evo-cp-wrap {width: 488.656px;display: flex;gap: 10px;  align-items: center;}
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Add Product Badge</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('add-badge-submitted') }}" method="post" enctype="multipart/form-data" class="add-badge-submitted">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Badge Name</label>
                                    <input type="text" class="form-control" name="badge" value="{{old('badge')}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Badge Color</label>
                                    <input id="cp1" type="text" class="form-control" name="color" value="{{old('color')}}"/>
                                </div>
                            </div>

                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('product-badges') }}" class="btn btn-link">Cancel</a>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{asset('assets/js/evol-colorpicker.min.js')}}"></script>

    <script>
        $(document).ready(function () {

            $("#cp1").colorpicker({
                color: "#ff9800",
                initialHistory: ["#ff0000", "#000000", "red", "purple"],
            });

        });
    </script>
@endpush
