<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.admin.headers-style')
</head>
<body>
<div id="wrapper">
    @include('partials.admin.top-navbar')
    @include('partials.admin.left-sidebar')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">
                <div class="card-header">
                    <div class="d-flex">
                        <div class="mr-auto">
                            <a class="btn btn-success octf-btn" data-toggle="modal" data-target="#add_role"><span class="icon-space"><i class="fa fa-plus-circle" aria-hidden="true"></i></span>Add Role</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-sm-8 ">
                                                <h4 class="card-title">
                                                    <a href="{{ route('roles') }}" title="{{ __('trans.back') }}">
                                                        <i class="fa fa-arrow-left" style="color: white" aria-hidden="true"></i>
                                                    </a> Role permissions({{ $role_name->role_name }})</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row p-3 mt-2">

                                        @for($k=0;$k<$half;$k++)
                                            @if(!empty($chunks[0][$k]->id))
                                                <div class="custom_rcd col-md-4 check-field">
                                                    <div class="new-rcb row">
                                                        <div class="option col-md-12 col-12">
                                                            <input class="permissions" id="{{ $chunks[0][$k]->id }}" role_id="{{ $role_id }}" permission_id="{{ $chunks[0][$k]->id }}" type="checkbox" @if(in_array($chunks[0][$k]->id,$allowed_permissions)) {{ "checked" }}@endif/>
                                                            <label for="{{ $chunks[0][$k]->id }}" style="padding: 0 10px;">
                                                                <span></span>
                                                                <div class="product_service-buy"> <p class="mb-0">{{ "  ".$chunks[0][$k]->permission }}</p></div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if(!empty($chunks[1][$k]->id))
                                                    <div class="custom_rcd col-md-4 check-field">
                                                        <div class="new-rcb row">
                                                            <div class="option col-md-12 col-12">
                                                                <input class="permissions" id="{{ $chunks[1][$k]->id }}" role_id="{{ $role_id }}" permission_id="{{ $chunks[1][$k]->id }}" type="checkbox" @if(in_array($chunks[1][$k]->id,$allowed_permissions)) {{ "checked" }}@endif/>
                                                                <label for="{{ $chunks[1][$k]->id }}" style="padding: 0 10px;">
                                                                    <span></span>
                                                                    <div class="product_service-buy"> <p class="mb-0">{{ "  ".$chunks[1][$k]->permission }}</p></div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                            @endif
                                                @if(!empty($chunks[2][$k]->id))
                                                    <div class="custom_rcd col-md-4 check-field">
                                                        <div class="new-rcb row">
                                                            <div class="option col-md-12 col-12">
                                                                <input class="permissions" id="{{ $chunks[2][$k]->id }}" role_id="{{ $role_id }}" permission_id="{{ $chunks[2][$k]->id }}" type="checkbox" @if(in_array($chunks[2][$k]->id,$allowed_permissions)) {{ "checked" }}@endif/>
                                                                <label for="{{ $chunks[2][$k]->id }}" style="padding: 0 10px;">
                                                                    <span></span>
                                                                    <div class="product_service-buy"> <p class="mb-0">{{ "  ".$chunks[2][$k]->permission }}</p></div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div>

        </div> <!-- content -->

        @include('partials.admin.footer')

    </div>
</div>
@include('partials.admin.footer-js')
<script>
    $(document).ready(function () {
        $(".permissions").change(function () {
        var role_id;
        var permission_id;
        role_id = $(this).attr('role_id');
        permission_id = $(this).attr('permission_id');
        $.ajax({
            method: "POST",
            url: "{{ route("add_role_permissions") }}",
            data: {
                '_token': '{{ csrf_token() }}',
                role_id: role_id,
                permission_id: permission_id,
                is_checked: this.checked
            }
        }).done(function (data) {

        });
    });
    });
</script>
</body>
</html>
