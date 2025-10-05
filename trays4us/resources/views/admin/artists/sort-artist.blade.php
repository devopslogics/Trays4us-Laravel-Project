@extends('layouts.admin.dashboard')
@push('styles')
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.min.css')}}">
    <style type="text/css">
        #sortable { list-style-type: none; margin: 0; padding: 0;width: 100% }
        #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 45px; }
        #sortable li span { position: absolute; margin-left: -1.3em; }
        .artist_sortable_li {display: flex;justify-content: space-between;align-items: center;}
    </style>
@endpush
@section('content')

    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Artist shown in the filter</h3>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                            <ul id="sortable">
                                @foreach($artist_sortings as $key => $artist_sortings)
                                    <li class="ui-state-default selector artist_sortable_li" id="{{$artist_sortings->id}}">
                                        <div class="tfu-artist-detail">
                                            {{ $artist_sortings->display_name ? $artist_sortings->display_name : $artist_sortings->first_name.' '.$artist_sortings->last_name }}
                                            <img src="{{ asset('/assets/images/move_icon.svg') }}" style="width: 30px" />
                                        </div>
                                        <div class="tfu-artist-visibility">

                                            @if($artist_sortings->is_feature == 0)

                                                <a href="javascript:void(0)" class="btn btn-sm bg-success-light mr-1 change_visablity" data-artist-id="{{$artist_sortings->id}}" data-status="1" title="Make feature" data-msg="Are you sure you want to make this feature?">
                                                    <i class="fas fa-eye-slash"></i>
                                                </a>
                                            @else
                                                <a href="javascript:void(0)" class="btn btn-sm bg-success-light mr-1 change_visablity" data-artist-id="{{$artist_sortings->id}}" data-status="0"  title="Remove feature"  data-msg="Are you sure you don't want to make this feature?">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif

                                        </div>
                                    </li>
                                @endforeach
                            </ul>


                        <div class="row">

                            <div class="col-sm-12">

                                <div class="modal-footer pt-3 pr-0 pl-0">

                                    <a href="javascript:void(0)" id="submitSort" class="btn btn-success octf-btn">Save</a>

                                </div>

                            </div>

                        </div>
                </div>

            </div>

        </div>

    </div>

@endsection


@push('scripts')

    <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            var pass_array = [];



            $( "#sortable" ).sortable({

                update: function () {

                    pass_array = $(this).sortable('toArray');

                    console.log(pass_array)

                }

            });

            pass_array = $("#sortable").sortable('toArray');

            $( "#sortable" ).disableSelection();



            $("#submitSort").click(function (argument) {

                $.ajax({

                    method: "POST",

                    url:"{{route('sort-artist-submitted')}}",

                    data:{
                        "_token": "{{csrf_token()}}",
                        "pass_array": pass_array
                    }

                }).done(function(data) {

                    if(data.status && data.status == 'success') {
                        window.location.reload();
                    }

                });

            });

            $(document).on("click",".change_visablity",function() {
                var status = $(this).attr('data-status');
                var artist_id = $(this).attr('data-artist-id');
                var _this = $(this);
                $.ajax({
                    method: "POST",
                    url:"{{route('change-artist-visibility')}}",
                    data:{
                        "_token": "{{csrf_token()}}",
                        "status": status,
                        "artist_id" : artist_id
                    }

                }).done(function(data) {
                    if(status == 0) {
                        _this.find('i').removeClass('fa-eye').addClass('fa-eye-slash');
                        _this.attr('data-status',1);

                    } else {
                        _this.find('i').removeClass('fa-eye-slash').addClass('fa-eye');
                        _this.attr('data-status',0);
                    }
                });
            });


        });
    </script>
@endpush












