@extends('layouts.admin.dashboard')
@push('styles')
    <style>
        .cat_image_preview { position: relative;display: inline-block;}
        .cat_image_preview:hover .edit {display: block;}
        .edit {padding-top: 7px; padding-right: 7px; position: absolute;right: 0;top: 0;display: none;}
        .edit a {color: #000;}
    </style>
@endpush
@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Edit Product Type</h3>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('edit-product-type-submitted') }}" method="post" enctype="multipart/form-data" class="add_artist_submitted">
                        {{ csrf_field() }}
                        <div class="row">
                        <input type="hidden" name="id" id="product_type_id" value="{{$product_type->id}}">


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Product Type Name</label>
                                    <input type="text" class="form-control" name="type_name" value="{{$product_type->type_name}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Case Pack</label>
                                    <input type="text" class="form-control" name="case_pack"  value="{{$product_type->case_pack}}">
                                </div>
                            </div>


                            @if ($parent_types->isNotEmpty())
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Parent Product Type</label>
                                        <select class="form-control" name="parent_id">
                                            <option value="">Select Category</option>
                                            @foreach($parent_types as $parent_row)
                                                <option value="{{$parent_row->id}}" {{$parent_row->id == $product_type->parent_id ? 'selected' : ''}}>{{$parent_row->type_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif


                            <?php /*
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Minimum order quantity</label>
                                    <input type="text" class="form-control" name="minimum_order_quantity" value="{{$product_type->minimum_order_quantity}}">
                                </div>
                            </div> */ ?>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Specification</label>
                                    <textarea class="form-control" name="type_description" id="type_description" rows="8" cols="100">{{$product_type->type_description}}</textarea>
                                </div>
                            </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Specification Image</label>
                                <input type="file" class="form-control" name="type_image">
                            </div>

                            @if( !empty($product_type->type_image) && \Storage::disk('uploads')->exists('/products/' . $product_type->type_image))
                                <div class="form-group">
                                    <div class="cat_image_preview avatar" style="margin-right: 5px;">
                                        <img class="avatar-img rounded" id="avatar2" src="{{ url('uploads/products/'.$product_type->type_image) }}" alt="avatar" style="">
                                        <div class="edit"><a href="javascript:void(0)" class="btn octf1-btn btn-set del-type-logo"><i class="fas fa-trash"></i></a></div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('product-types') }}" class="btn btn-link">Cancel</a>
                        </div>
                        </div>
                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection

@push('scripts')
    <!-- Place the first <script> tag in your HTML's <head> -->
    <script src="https://cdn.tiny.cloud/1/enjz6z7k3i58pa4t22lxiorwjp2y0nic8a80zstrwwcs69q6/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        $(document).ready(function () {
            tinymce.init({
                selector: '#type_description',
                menubar: false,
                toolbar1: "undo redo styleselect fontselect fontsizeselect | bold italic forecolor backcolor",
                toolbar2: "code image link table | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent",
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor colorpicker textpattern"
                ],
                forced_root_block : false,
                setup: function (editor) {

                }
            });

            //----------------------------------------------------------------------------------------------------------

            $('.del-type-logo').on('click', function(event){
                event.preventDefault();
                $('#loading').show();
                _this = $(this);
                $.ajax({
                    url:"{{ route('delete-product-type-photo') }}",
                    data: { product_type_id: $('#product_type_id').val() },
                    type: "GET",
                    success: function(data){
                        $('#loading').hide();
                        _this.closest('.cat_image_preview').find('img').remove();
                    }
                });
            });

            //----------------------------------------------------------------------------------------------------------

        });
    </script>
@endpush
