@extends('layouts.admin.dashboard')
<style>
    .tfu_parent_type {
        margin: 0px 0px 0px 15px;
    }
    .tfu_customizable_name {
        padding: 0px 5px;
        margin: 16px 0px;
    }
    .row.tfu-type_inner {
        margin: 10px 0px 0px 16px;
    }
</style>
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Design Types</h3>
            </div>
            <div class="col-auto text-right">
                <a href="{{ route('add-product-customizable') }}" class="btn btn-primary add-button ml-3">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-xl-3">
                            <b>Design Type</b>
                        </div>
                        <div class="col-xl-3">
                            <b>MOQ(Minimum Order Quantity)</b>
                        </div>
                        <div class="col-xl-3">
                            <b>Price</b>
                        </div>
                        <div class="col-xl-3">
                            <b>Action</b>
                        </div>
                    </div>
                        @if ($customizables->isNotEmpty())
                            @foreach($customizables as $customizable)
                                <div class="row">
                                <form action="{{ route('save-customizable-type-relation') }}" method="post" enctype="multipart/form-data" class="add_customizable_design d-flex">
                                    {{ csrf_field() }}
                                    <div class="col-xl-8">
                                        <div class="tfu_customizable_name">
                                            <input class="form-control" name="product_customizable" class="tfu_minimum_order_quantity" value="{{$customizable->customizable_name}}">
                                        </div>
                                        <div class="row tfu_product_types">
                                            @foreach($product_types as $product_type)
                                                <div class="col-xl-12 tfu_parent_type"><b>{{$product_type->type_name}}</b></div>
                                                <div class="row tfu-type_inner">
                                                    @foreach($product_type->childTypes as $child_type)
                                                        <div class="col-xl-4 tfu_child_type">
                                                            <p>{{$child_type->type_name}}</p>
                                                        </div>
                                                        <div class="col-xl-4 d-flex justify-content-center g-2">
                                                            @php

                                                                $minimumOrderQuantity = $customizable->customizableTypeRelations()
                                                                    ->where('product_type_id', $child_type->id)
                                                                    ->where('product_customizable_id', $customizable->id)
                                                                    ->value('minimum_order_quantity');
                                                            @endphp
                                                            <input class="form-control" name="minimum_order_quantity[{{$customizable->id}}][{{$child_type->id}}]" class="tfu_minimum_order_quantity" value="{{$minimumOrderQuantity}}" style="width: 100px">
                                                        </div>
                                                        <div class="col-xl-4 d-flex justify-content-center g-2">
                                                            @php

                                                                $set_price = $customizable->customizableTypeRelations()
                                                                    ->where('product_type_id', $child_type->id)
                                                                    ->where('product_customizable_id', $customizable->id)
                                                                    ->value('set_price');
                                                            @endphp
                                                            <span style="margin: 0px 3px 0px 0px;line-height: 40px;">$</span><input class="form-control" name="set_price[{{$customizable->id}}][{{$child_type->id}}]" class="tfu_set_price" value="{{$set_price}}" style="width: 100px">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
                                        <div class="text-center">
                                            <button type="button" class="btn btn-primary tfu_customizable_design_btn">Submit</button>
                                            <a href="" class="btn btn-link">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                                </div>
                            @endforeach
                        @endif


                    <?php /*<div class="table-responsive">
                        <table class="table table-hover table-center mb-0" id="items">
                            <thead>
                            <tr>
                                <th>Design Type</th>
                                <th>Date</th>
                                <th class="text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if ($customizables->isNotEmpty())
                                    @foreach($customizables as $customizable)
                                        <tr>
                                            <td>{{$customizable->customizable_name}}</td>
                                            <td>{{$customizable->created_at}}</td>

                                            <td class="text-end">
                                                <a href="{{ route('edit-product-customizable',['id'=>$customizable->id]) }}" class="btn btn-sm bg-success-light mr-1 edit_cat"> <i class="far fa-edit mr-1"></i> </a>

                                                <a href="{{ route('change-product-customizable-status',['id'=>base64_encode($customizable->id.":2")]) }}"
                                                   class="btn btn-sm bg-danger-light mr-1 change_status"
                                                   title="Delete"
                                                   data-msg="Are you sure want to delete">
                                                    <i class="far  fa-trash-alt mr-1"></i>
                                                </a>
                                                @if($customizable->status == 0)
                                                    <a href="{{ route('change-product-customizable-status',['id'=>base64_encode($customizable->id.":1")]) }}"
                                                       class="btn btn-sm bg-success-light mr-1 change_status"
                                                       title="Activate"
                                                       data-msg="Are you sure want to activate">
                                                        <i class="fas fa-eye-slash"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('change-product-customizable-status',['id'=>base64_encode($customizable->id.":0")]) }}"
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

                    </div> */ ?>

                    {{ $customizables->links('pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')

    <script type="text/javascript">
    $(document).ready(function() {

        $(".tfu_customizable_design_btn").click(function(event) {
            event.preventDefault();
            _this = $(this);
            URL = $(this).closest('.add_customizable_design').attr('action');
            var formData = new FormData(_this.closest('.add_customizable_design')[0]);
            //formData.append('product_customizable', 'newValue');
            $('#loading').show();
            $.ajax({
                url:URL,
                method:"POST",
                data: formData,
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(result)
                {
                    Swal.fire(
                        'Design Type',
                        result.message,
                        'success'
                    );
                    $('#loading').hide();
                }
            })
        });

    });
</script>

@endpush
