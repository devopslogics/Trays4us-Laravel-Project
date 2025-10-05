@extends('layouts.admin.dashboard')
@push('styles')
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.min.css')}}">
@endpush
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Customizer Processing Time</h3>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0 table-fit" id="items">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Product</a></th>
                                <th>Customer Company</th>
                                <th>Upload Processing Time(minutes)</th>
                                <th>Orig Prod Proc Time(minutes)</th>
                                <th>Original Image</th>
                                <th>Original Image Size</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if ($processing_times->isNotEmpty())
                                    @foreach($processing_times as $index => $processing_time)

                                        @php
                                            $seconds = $processing_time->upload_processing_time;
                                            $upload_roundedMinutes = '-';
                                            $prod_proc_roundedMinutes = '-';
                                            $roundedMinutes = '-';
                                            if($seconds > 0) {
                                                $minutes = $seconds / 60;
                                                $roundedMinutes = number_format($minutes, 2);
                                            }

                                            $seconds = $processing_time->orig_prod_proc_time;
                                            if($seconds > 0) {
                                                $minutes = $seconds / 60;
                                                $prod_proc_roundedMinutes = number_format($minutes, 2);
                                            }
                                            $filePath = base_path('uploads/products/' . $processing_time->image_name);
                                            $image_path = url('uploads/products/'.$processing_time->image_name);
                                            if(!File::exists($filePath)) {
                                                  $image_path = url('uploads/customizer-products/'.$processing_time->image_name);
                                                  $filePath = base_path('uploads/customizer-products/' . $processing_time->image_name);
                                            }
                                            $fileSize = file_exists($filePath) ? filesize($filePath) : 0;
                                            $fileSizeInMB = $fileSize > 0 ? round($fileSize / (1024 * 1024), 2) : 'File not found';

                                        @endphp

                                        <tr id="tr_{{$processing_time->id}}">
                                            <td>
                                                <span class="numeric_number" style="color: #FF6600;font-weight: bold;">{{$index + $processing_times->firstItem()}}</span>
                                            </td>
                                            <td>{!! $processing_time->product_name !!}</td>
                                            <td>{{$processing_time->customer->company ?? ''}}</td>
                                            <td>{{$roundedMinutes}}</td>
                                            <td>{{$prod_proc_roundedMinutes}}</td>
                                            <td> <a href="{{ $image_path }}" target="_blank"> <img class="avatar-img rounded" alt src="{{ $image_path }}" width="40%"></a></td>
                                            <td>{{$fileSizeInMB}} MB</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">Record not found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>
                    {{ $processing_times->withQueryString()->links('pagination.custom') }}
                </div>
            </div>
        </div>
    </div>

@endsection
