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
                        <h3 class="page-title">Edit Product tag</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <?php
                       // $commaSeparatedTags = implode(', ', $synonym->toArray());
                    ?>
                    <form action="{{ route('edit-tag-submitted') }}" method="post" enctype="multipart/form-data" class="edit_tag_submitted">
                        {{ csrf_field() }}
                        <input type="hidden" name="tag_id" value="{{$tag->id}}" id="tag_id">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tag Name</label>
                                    <input type="text" class="form-control" name="tag_name" value="{{$tag->tag_name}}">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group tag_wrapper">
                                    <label>Synonym</label>
                                    <input type="hidden" name="synonyms" id="tag_ids" class="tag-ids"  value="{{ collect($synonym)->join(', ') }}">

                                    <div class="tags-input">
                                        <div class="myTags" id="">
                                            <span class="data">
                                                @if($tag->synonyms)
                                                    @foreach($tag->synonyms as $synonym)
                                                        <span class="tag"><span class="text" _value="{{$synonym->synonym}}">{{$synonym->synonym}}</span><span class="close">&times;</span></span>
                                                    @endforeach
                                                @endif
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
                            <button type="submit" class="btn btn-primary">Update</button>
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
