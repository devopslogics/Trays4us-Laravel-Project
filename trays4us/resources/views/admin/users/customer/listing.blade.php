@extends('layouts.admin.dashboard')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">All Customers</h3>
            </div>
            <div class="col-auto text-right">

                <a href="javascript:void(0)" class="btn btn-primary add-button ml-3" id="import_customer_xls">
                    <i class="fa-solid fa-upload"></i>
                </a>

                <a href="{{ route('download-customer-csv') }}" target="_blank" class="btn btn-primary add-button ml-3" id="generate_customer_cv">
                    <i class="fa-solid fa-file-csv"></i>
                </a>

                <a class="btn btn-white filter-btn" href="javascript:void(0);" id="filter_search">
                    <i class="fas fa-filter"></i>
                </a>

                <a href="{{ route('add-customer') }}" class="btn btn-primary add-button ml-3">
                    <i class="fas fa-plus"></i>
                </a>

            </div>
        </div>
    </div>

    <div class="card filter-card" id="filter_inputs" style="display: {{$filter_flag ? 'block' : ''}}">
        <div class="card-body pb-0">
            <form action="" method="get">
                <div class="row filter-row">
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="">Select Status</option>
                                <option value="1" {{ (isset($_GET['status']) AND $_GET['status'] == 1) ? 'selected' : ''}}>Activate</option>
                                <option value="0" {{(isset($_GET['status']) AND $_GET['status'] == '0') ? 'selected' : ''}}>Deactivate</option>
                                <option value="2" {{(isset($_GET['status']) AND $_GET['status'] == 2) ? 'selected' : ''}}>Deleted</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-3 col-md-3">
                        <div class="form-group">
                            <label>Search by(Name,email,city)</label>
                            <input class="form-control" type="text" name="search_by" value="{{ isset($_GET['search_by']) ? $_GET['search_by']: '' }}">
                        </div>
                    </div>

                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <label>Country</label>
                            <select class="form-control" name="country" id="country">
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}" {{ (isset($_GET['country']) && $_GET['country'] == $country->id) ? 'selected' : ''}}>{{$country->country_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <label>State</label>
                            <select class="form-control" name="state" id="state">
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Search</button>
                            <a href="{{ route('customer') }}" class="btn btn-primary btn-block" style="line-height: 34px;">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @php

        $dir_last_updated = 'asc';
        $last_updated_icon = '<i class="fa-solid fa-sort"></i>';

        if(isset($_GET['sort_by']) AND $_GET['sort_by'] == 'order_by_last_updated') {
             $dir_last_updated = $_GET['order'] == 'desc' ? 'asc': 'desc';
             $last_updated_icon = $_GET['order'] == 'desc' ? '<i class="fa-solid fa-sort-down"></i>': '<i class="fa-solid fa-sort-up"></i>';
         }

    @endphp

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0" id="items">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>E-mail</th>
                                <th>Company name</th>
                                <th>Postal Code</th>
                                <th><a href="{{ route('customer', ['sort_by' => 'order_by_last_updated', 'order' => $dir_last_updated]) }}">Last Visit ET {!! $last_updated_icon !!}</a></th>
                                <th>Account created ET</th>
                                <th class="text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                                @if ($customers->isNotEmpty())
                                    @foreach($customers as $customer)
                                        @php
                                            $row_status_class = '';
                                             if($customer->status == 0)
                                                  $row_status_class = 'table-warning';
                                             if($customer->status == 2)
                                                  $row_status_class = 'table-danger';
                                        @endphp

                                        <tr class="{{$row_status_class}}">
                                            <td>{{$customer->id}}</td>
                                            <td>{{$customer->first_name.' '.$customer->last_name}}</td>
                                            <td>{{$customer->email}}</td>
                                            <td>{{$customer->company}}</td>
                                            <td>{{$customer->postal_code}}</td>
                                            <td>{{$customer->last_login}}</td>
                                            <td>{{$customer->created_at}}</td>
                                            <td class="text-end" style="text-align: left !important;">
                                                <a href="{{ route('edit-customer',['id'=>$customer->id]) }}" class="btn btn-sm bg-success-light mr-1 edit_cat" title="Edit"> <i class="far fa-edit mr-1"></i> </a>

                                                 <?php /*
                                                <a href="{{ route('change-customer-status',['id'=>base64_encode($customer->id.":2")]) }}"
                                                   class="btn btn-sm bg-danger-light mr-1 change_status"
                                                   title="Delete"
                                                   data-msg="Are you sure want to delete">
                                                    <i class="far  fa-trash-alt mr-1"></i>
                                                </a> */ ?>

                                                @if($customer->status == 0)
                                                    <a href="{{ route('change-customer-status',['id'=>base64_encode($customer->id.":1")]) }}"
                                                       class="btn btn-sm bg-success-light mr-1 change_status"
                                                       title="Activate"
                                                       data-msg="Are you sure want to activate">
                                                        <i class="fas fa-eye-slash"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('change-customer-status',['id'=>base64_encode($customer->id.":0")]) }}"
                                                       class="btn btn-sm bg-success-light mr-1 change_status"
                                                       title="Deactivate"
                                                       data-msg="Are you sure want to Deactivate">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif

                                                @if($customer->cquantity)
                                                    <a href="{{ route('cart-item-detail',['cid'=>$customer->id]) }}"
                                                       class="btn btn-sm bg-success-light mr-1">
                                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
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

                    {{ $customers->links('pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')

    <div class="modal fade" id="tfu_customer_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" enctype="multipart/form-data" id="import_customer_form">
                    <div class="modal-body">
                        <div class="progress d-none">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="0" style="width: 100%"></div>
                        </div>
                        <div class="alert alert-danger invisible error_wrapper" dis="">
                            <div id="error-messages"></div>
                        </div>

                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Import Customer File:</label>
                            <input type="file" class="form-control" id="import_customer" name="import_customer">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script type="text/javascript">

        $(document).ready(function() {

            //-----------------------------------------------------------------------------------------------


            $('#import_customer_xls').click(function (e) {
                e.preventDefault();
                $('#tfu_customer_modal').modal('show');
            });

            //-----------------------------------------------------------------------------------------------


            $("#import_customer_form").submit(function(e) {
                e.preventDefault();

                // Create FormData object
                var formData = new FormData(this);

                // Hide any previous error messages
                $('.error_wrapper').addClass('invisible').removeClass('visible');
                $('.progress').removeClass('d-none').addClass('d-flex');
                // Send AJAX request
                $.ajax({
                    url: "{{ route('import-customers') }}",
                    data: formData,
                    type: 'POST',
                    contentType: false, // Set content type to false to let the browser detect it automatically
                    processData: false, // Prevent jQuery from automatically processing the data
                    cache: false, // Disable caching
                    success: function (response) {
                        if (response.status == "success") {
                            location.reload(); // Reload the page after successful import
                        }
                    },
                    dataType: 'json',
                    error: function (xhr, status, error) {
                        $('.error_wrapper').removeClass('invisible').addClass('visible');
                        var errors = xhr.responseJSON.error;
                        var errorHtml = '<ul>';
                        $.each(errors, function (index, value) {
                            errorHtml += '<li>' + value + '</li>';
                        });
                        errorHtml += '</ul>';
                        $('#error-messages').html(errorHtml);
                        $('.progress').removeClass('d-flex').addClass('d-none');
                    }
                });
            });

            //-----------------------------------------------------------------------------------------------

            var country_id = $('#country').val();
            if (country_id > 0) {
                get_state_by_country_id(country_id);
            }

            //-----------------------------------------------------------------------------------------------

            $('#country').change(function () {
                var country_id = $(this).val();
                if (country_id) {
                    get_state_by_country_id(country_id);
                } else {
                    $('#state').empty().hide();
                }
            });

            //-----------------------------------------------------------------------------------------------

            function get_state_by_country_id(country_id) {
                $.ajax({
                    url: "{{ route('get-state-by-country-id') }}",
                    type: 'GET',
                    data: { country_id: country_id},
                    dataType: 'json',
                    success: function (data) {
                        $('#state').empty().show();
                        $('#state').append('<option value="">Select State</option>');
                        $.each(data, function (key, value) {
                            $('#state').append('<option value="' + value.id + '" >' + value.state_name + '</option>');
                        });
                        var selectedCity = '{{ (isset($_GET['state']) && $_GET['state'] > 0) ? $_GET['state'] : '' }}';
                        if ($('#state option[value="' + selectedCity + '"]').length > 0) {
                            $('#state').val(selectedCity);
                        } else {
                            $('#state').val('');
                        }
                    }
                });
            }

            //-----------------------------------------------------------------------------------------------
        });
    </script>

@endpush
