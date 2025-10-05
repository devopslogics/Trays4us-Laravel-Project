@extends('layouts.admin.dashboard')
@push('styles')
    <link rel="stylesheet" href="{{asset('assets/css/tags.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.min.css')}}">
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Add Product tag</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('add-tag-submitted') }}" method="post" enctype="multipart/form-data" class="add_tags_submitted">
                        {{ csrf_field() }}

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tag Name</label>
                                    <input type="text" class="form-control" name="tag_name" value="{{old('tag_name')}}">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group tag_wrapper">
                                    <label>Synonym</label>
                                    <input type="hidden" name="synonyms" id="tag_ids" class="tag-ids"  value="{{ old('tag_ids') }}">

                                    <div class="tags-input">
                                        <div class="myTags" id="">
                                            <span class="data">
                                                <?php /*
                                                <span class="tag"><span class="text" _value="Nairobi 047">jQuery</span><span class="close">&times;</span></span>
                                                <span class="tag"><span class="text" _value="24">Script</span><span class="close">&times;</span></span>
                                                */ ?>
                                            </span>

                                            <span class="autocomplete">
                                                <input type="text">
                                                <div class="autocomplete-items">
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>



                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('assets/js/tags.js')}}"></script>

    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

@endpush
