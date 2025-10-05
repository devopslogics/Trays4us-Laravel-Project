@extends('layouts.admin.dashboard')
@push('styles')
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.min.css')}}">
@endpush
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Slider</h3>
            </div>
            <div class="col-auto text-right">
                <a href="javascript:void(0)" class="btn btn-primary add-button ml-3" id="slider_sorting">
                    <i class="fa-solid fa-sort"></i>
                </a>

                <a href="{{ route('add-homepage-slider') }}" class="btn btn-primary add-button ml-3">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0" id="items">
                            <thead>
                            <tr>
                                <th>Slider title</th>
                                <th>Image</th>
                                <th>Date</th>
                                <th class="text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if ($homepage_sliders->isNotEmpty())
                                    @foreach($homepage_sliders as $homepage_slider)
                                        @php
                                            $row_status_class = '';
                                             if($homepage_slider->status == 0)
                                                  $row_status_class = 'table-warning';
                                             if($homepage_slider->status == 2)
                                                  $row_status_class = 'table-danger';
                                        @endphp
                                        <tr class="{{$row_status_class}}">
                                            <td>{{$homepage_slider->slider_title}}</td>
                                            <td> <img class="avatar-img rounded" alt src="{{ url('uploads/sliders/'.$homepage_slider->slider_image) }}" width="100px"></td>
                                            <td>{{$homepage_slider->created_at}}</td>
                                            <td class="text-end">
                                                <a href="{{ route('edit-homepage-slider',['id'=>$homepage_slider->id]) }}" class="btn btn-sm bg-success-light mr-1 edit_cat"  title="Edit"> <i class="far fa-edit mr-1"></i></a>

                                                <a href="{{ route('change-slider-status',['id'=>base64_encode($homepage_slider->id.":2")]) }}"
                                                   class="btn btn-sm bg-danger-light mr-1 change_status"
                                                   title="Delete"
                                                   data-msg="Are you sure want to delete">
                                                    <i class="far  fa-trash-alt mr-1"></i>
                                                </a>
                                                @if($homepage_slider->status == 0)
                                                    <a href="{{ route('change-slider-status',['id'=>base64_encode($homepage_slider->id.":1")]) }}"
                                                       class="btn btn-sm bg-success-light mr-1 change_status"
                                                       title="Activate"
                                                       data-msg="Are you sure want to activate">
                                                        <i class="fas fa-eye-slash"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('change-slider-status',['id'=>base64_encode($homepage_slider->id.":0")]) }}"
                                                       class="btn btn-sm bg-success-light mr-1 change_status"
                                                       title="Deactivate"
                                                       data-msg="Are you sure want to Deactivate">
                                                         <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

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

                    {{ $homepage_sliders->links('pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            $(document).on("click", "#slider_sorting", function () {
                $('#loading').show();
                $.ajax({
                    method: "get",
                    url: "{{ route('sort-homepage-slider') }}",
                    data: {},
                    dataType: "json",
                }).done(function (data) {
                    $('#loading').hide();
                    $('#jp_general_body').html(data.html);
                    $('#jp_general_header').html('Homepage Header Slider Sorting');
                    $('#jp_general_modal').modal('show');
                });
            });

        });
    </script>

@endpush
