@extends('layouts.admin.dashboard')
@push('styles')

    <style>
        .switch_on_off {  position: relative; display: inline-block;  width: 150px; height: 34px;}

        .switch_on_off input {display:none;}

        .switch_slider { position: absolute;cursor: pointer;top: 0;left: 0;right: 0;bottom: 0;  background-color: #ca2222;  -webkit-transition: .4s; transition: .4s;}

        .switch_slider:before {position: absolute;content: "";height: 26px;width: 26px;left: 4px;bottom: 4px;background-color: white;-webkit-transition: .4s;transition: .4s;}

        input:checked + .switch_slider {background-color: #2ab934;}

        input:focus + .switch_slider {box-shadow: 0 0 1px #2196F3;}

        input:checked + .switch_slider:before {-webkit-transform: translateX(112px);-ms-transform: translateX(112px);transform: translateX(112px);}

        .switch_on { display: none;}

        .switch_on, .switch_off {color: white;position: absolute;transform: translate(-50%,-50%);top: 50%;left: 50%;font-size: 10px;font-family: Verdana, sans-serif;}

        input:checked+ .switch_slider .switch_on {display: block;}

        input:checked + .switch_slider .switch_off {display: none;}
        .switch_slider.switch_round {border-radius: 34px;}
        .switch_slider.switch_round:before {border-radius: 50%;}

    </style>

@endpush
@section('content')

    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Search Tags</h3>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs menu-tabs">
        <li class="nav-item {{empty($_GET['is_contact']) ? 'active' : ''}}">
            <a class="nav-link" href="{{ route('get-search-tag-listing') }}">All Tags <span class="badge badge-primary">{{$all_tags}}</span></a>
        </li>
        <li class="nav-item {{(isset($_GET['is_contact']) && $_GET['is_contact'] == 1)  ? 'active' : ''}}">
            <a class="nav-link" href="{{ route('get-search-tag-listing',['is_contact' => 1]) }}" id="to_be_contacted">To be Contacted<span class="badge badge-primary">{{$to_be_contacted}}</span></a>
        </li>
        <li class="nav-item {{(isset($_GET['is_contact']) && $_GET['is_contact'] == 2)  ? 'active' : ''}}">
            <a class="nav-link" href="{{ route('get-search-tag-listing',['is_contact' => 2]) }}" id="contacted">Contacted<span class="badge badge-primary">{{$contacted}}</span></a>
        </li>
        <li class="nav-item {{(isset($_GET['is_contact']) && $_GET['is_contact'] == 0)  ? 'active' : ''}}">
            <a class="nav-link" href="{{ route('get-search-tag-listing',['is_contact' => 0]) }}">Just not found<span class="badge badge-primary">{{$just_not_found}}</span></a>
        </li>
    </ul>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0" id="items">
                            <thead>
                            <tr>
                                <th>Tag name</th>
                                <th>Email</th>
                                <th>Contact me</th>
                                <th>User Detail</th>
                                <th>Date</th>
                                <th class="text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if ($searchTags->isNotEmpty())
                                    @foreach($searchTags as $searchTag)

                                        @php
                                            $is_contact = '';
                                            if($searchTag->is_contact == 2)
                                                $is_contact = 'checked';
                                        @endphp

                                        <tr>
                                            <td>{{$searchTag->search_tags}}</td>
                                            <td>
                                                @if($searchTag->customer_id > 0)
                                                    <a href="{{ route('customer', ['cid' => $searchTag->customer_id]) }}"style="text-decoration: underline;">{{$searchTag->email}}</a>
                                                @else
                                                    {{$searchTag->email}}
                                                @endif
                                            </td>

                                            <td>
                                                @if($searchTag->is_contact == 1 OR $searchTag->is_contact == 2)
                                                    <label class="switch_on_off">
                                                        <input type="checkbox" class="switch_on_off_btn" data-stid="{{ $searchTag->id }}" {{$is_contact}}>
                                                        <div class="switch_slider switch_round">
                                                            <!--ADDED HTML -->
                                                            <span class="switch_on">Contacted</span>
                                                            <span class="switch_off">To be Contacted</span>
                                                            <!--END-->
                                                        </div>
                                                    </label>
                                                @endif
                                                <?php /*{{$searchTag->is_contact ? "Yes" : ''}} */ ?>
                                            </td>
                                            <td>
                                                {!! $searchTag->ip_address ? $searchTag->ip_address.' , ' : '' !!}  {!! $searchTag->browser ? $searchTag->browser.' , ' : '' !!}  {!! $searchTag->os !!}</td>
                                            <td>{{$searchTag->created_at}}</td>

                                            <td class="text-end">

                                                <a href="{{ route('change-search-tag-status',['id'=>base64_encode($searchTag->id.":2")]) }}"
                                                   class="btn btn-sm bg-danger-light mr-1 change_status"
                                                   title="Delete"
                                                   data-msg="Are you sure want to delete">
                                                    <i class="far  fa-trash-alt mr-1"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">Record not found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>

                    {{ $searchTags->links('pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')

    <script type="text/javascript">
    $(document).ready(function() {

        $(".switch_on_off_btn").change(function(){
            var is_contacted;
            if ($(this).is(':checked')) {
                is_contacted = 2;
            } else {
                is_contacted = 1;
            }
            var search_tag_id = $(this).attr('data-stid');
            $.ajax({
                url: "{{ route('change-search-tag-status') }}",
                data: {
                    stid: search_tag_id,
                    is_contacted : is_contacted
                },
                dataType: 'json',
                type: "get",
                beforeSend: function () {

                }
            })
            .done(function (response) {
                $("#contacted .badge").text(response.contacted);
                $("#to_be_contacted .badge").text(response.to_be_contacted);
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
        });

    });
</script>

@endpush
