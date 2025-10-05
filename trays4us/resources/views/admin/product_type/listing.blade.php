@extends('layouts.admin.dashboard')

@section('content')

    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Product Types</h3>
            </div>
            <div class="col-auto text-right">
                <a href="{{ route('add-product-type') }}" class="btn btn-primary add-button ml-3">
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
                                <th>Product Type Name</th>
                                <th>Parent</th>
                                <?php /*<th>Description</th> */ ?>
                                <?php /* <th>Date</th> */ ?>
                                <th>Case Pack</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if ($product_types->isNotEmpty())
                                    @foreach($product_types as $product_type)

                                            <tr>
                                                <td><b>{{$product_type->type_name}}</b></td>
                                                <td>-</td>
                                                <td></td>
                                                <td class="text-center">
                                                    <a href="{{ route('edit-product-type',['id'=>$product_type->id]) }}" class="btn btn-sm bg-success-light mr-1 edit_cat"> <i class="far fa-edit mr-1"></i> </a>

                                                    <a href="{{ route('change-product-type-status',['id'=>base64_encode($product_type->id.":2")]) }}"
                                                       class="btn btn-sm bg-danger-light mr-1"
                                                       title="Delete"
                                                       data-msg="Are you sure want to delete">
                                                        <i class="far fa-trash-alt mr-1"></i>
                                                    </a>
                                                    @if($product_type->status == 0)
                                                        <a href="{{ route('change-product-type-status',['id'=>base64_encode($product_type->id.":1")]) }}"
                                                           class="btn btn-sm bg-success-light mr-1"
                                                           title="Activate"
                                                           data-msg="Are you sure want to activate">
                                                            <i class="fas fa-eye-slash"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('change-product-type-status',['id'=>base64_encode($product_type->id.":0")]) }}"
                                                           class="btn btn-sm bg-success-light mr-1"
                                                           title="Deactivate"
                                                           data-msg="Are you sure want to Deactivate">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endif

                                                </td>
                                            </tr>

                                            @foreach($product_type->childTypes as $child_type)
                                                <tr>
                                                    <td>{{$child_type->type_name}}</td>
                                                    <td>{{$child_type->parentType->type_name ?? '-'}}</td>
                                                    <td><input class="form-control tfu_case_pack" data-type-id="{{$child_type->id}}" name="case_pack" value="{{$child_type->case_pack}}" style="width: 100px"> </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('edit-product-type',['id'=>$child_type->id]) }}" class="btn btn-sm bg-success-light mr-1 edit_cat"> <i class="far fa-edit mr-1"></i> </a>

                                                        <a href="{{ route('change-product-type-status',['id'=>base64_encode($child_type->id.":2")]) }}"
                                                           class="btn btn-sm bg-danger-light mr-1"
                                                           title="Delete"
                                                           data-msg="Are you sure want to delete">
                                                            <i class="far fa-trash-alt mr-1"></i>
                                                        </a>
                                                        @if($child_type->status == 0)
                                                            <a href="{{ route('change-product-type-status',['id'=>base64_encode($child_type->id.":1")]) }}"
                                                               class="btn btn-sm bg-success-light mr-1"
                                                               title="Activate"
                                                               data-msg="Are you sure want to activate">
                                                                <i class="fas fa-eye-slash"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('change-product-type-status',['id'=>base64_encode($child_type->id.":0")]) }}"
                                                               class="btn btn-sm bg-success-light mr-1"
                                                               title="Deactivate"
                                                               data-msg="Are you sure want to Deactivate">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endforeach
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">Record not found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>

                    {{ $product_types->links('pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')

    <script type="text/javascript">
    $(document).ready(function() {

        $('body').on('keyup paste', '.tfu_case_pack', function () {
            var case_pack = $(this).val();
            var type_id =  $(this).attr('data-type-id');
            if(case_pack > 0) {
                $.ajax({
                    url: "{{ route('save-case-pack') }}",
                    type: 'GET',
                    data: {case_pack: case_pack, type_id: type_id},
                    dataType: 'json',
                    success: function (data) {

                    }
                });
            }
        });

    });
</script>

@endpush
