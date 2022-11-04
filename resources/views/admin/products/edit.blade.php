@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">
    <div class="card shadow mb-4">

        <div class="cover-loader d-none">
            <div class="loader"></div>
        </div>

        <x-page-head title="Edit Product " url="admin/product" type="create" />

        <div class="card-body h-body">
            <div class="row">

                <div class="col-lg-12">
                    <form id="product" action="{{url('admin/product/'.$res->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Title<span class="text-danger">*</span></label>
                                <input type="text" name="title" value="{{$res->title}}" id="title" class="form-control form-control-sm" placeholder="Enter Title" required>
                                <span id="title_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>SKU<span class="text-danger">*</span></label>
                                <input type="text" name="sku" value="{{$res->sku}}" id="sku" class="form-control form-control-sm" placeholder="Enter SKU" required>
                                <span id="sku_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Category<span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" id="category_id" name="category">
                                    <option value="">Select</option>
                                    @foreach($categories as $show)
                                    <option value="{{ $show->_id }}" {{ ( $show->_id == $res->category_id ) ? ' selected' : '' }}>{{ ucwords($show->name)}}</option>
                                    @endforeach
                                </select>
                                <span id="category_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Sub Category<span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" name="sub_category" id="sub_category_id">
                                </select>
                                <span id="sub_category_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Unit<span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" id="unit_id" name="unit_id">
                                    <option value="">Select</option>
                                    @foreach($units as $show)
                                    <option value="{{ $show->_id }}" {{ ( $show->_id == $res->unit_id ) ? ' selected' : '' }}>{{ ucwords($show->unit)}}</option>
                                    @endforeach
                                </select>
                                <span id="unit_id_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Brand<span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" id="brand_id" name="brand_id">
                                    <option value="">Select</option>
                                    @foreach($brands as $show)
                                    <option value="{{ $show->_id }}" {{ ( $show->_id == $res->brand_id ) ? ' selected' : '' }}>{{ ucwords($show->brand)}}</option>
                                    @endforeach
                                </select>
                                <span id="brand_id_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Image</label>
                                <input type="file" name="image" accept="image/*" id="imgInp" class="form-control form-control-sm">
                                <span id="image_msg" class="c-text-danger"></span>
                            </div>

                            @if(!empty($res->image))
                            <div class="form-group col-md-4 mt-3">
                                <img src="{{imgPath('product',$res->image)}}" id="imgPreview" class="img"/>
                            </div>
                            @endif

                            <div class="form-group col-md-4">
                                <label>Status<span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" id="status" name="status">
                                    <option value="1" {{ ($res->status ==1)?'selected':''}}>Active</option>
                                    <option value="0" {{ (isset($res->status) && $res->status ==0)?'selected':''}}>Inactive</option>
                                </select>
                                <span id="status_msg" class="c-text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <input type="submit" value="Submit" class="btn btn-success">
                                <button type="reset" class="btn btn-warning"><span class="mdi mdi-rotate-left"></span>&nbsp;Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('script')
<script>
    $('form#product').submit(function(e) {
        e.preventDefault();
        formData = new FormData(this);
        let url = $(this).attr('action');
        $('.cover-loader').removeClass('d-none');
        $('.h-body').addClass('d-none');
        axios.post(url, formData)
            .then(function(response) {
                res = response.data;

                $('.cover-loader').addClass('d-none');
                $('.h-body').removeClass('d-none');

                /*Start Validation Error Message*/
                $('span.custom-text-danger').html('');
                $.each(res.validation, (index, msg) => {
                    $(`#${index}_msg`).html(`${msg}`);
                })
                /*Start Validation Error Message*/

                /*Start Status message*/
                if (res.status == 'success' || res.status == 'error') {
                    Swal.fire(
                        `${res.status}!`,
                        res.msg,
                        `${res.status}`,
                    )
                }
                /*End Status message*/

                //for reset all field
                if (res.status == 'success') {
                    $('form#product')[0].reset();
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }

            })
            .catch(function(error) {
                console.log(error);
                Swal.fire(
                    `Error!`,
                    error,
                    `error`,
                );
            });
    })


    $(document).ready(function() {
        var cat_id = '{{$res->category_id}}';
        var sub_cat_id = '{{$res->sub_category_id}}';

        subCategory(cat_id, sub_cat_id);

        function subCategory(cat_id, sub_cat_id) {

            var url = "{{ url('admin/sub_category') }}/" + cat_id;
            axios.get(url)
                .then(function(response) {
                    res = response.data;
                    var option = `<option value="">Select</option>`;
                    if (res) {
                        $.each(res, (index, val) => {
                            let selected = (sub_cat_id == val._id) ? 'selected' : '';
                            option += '<option value="' + val._id + '" ' + selected + '>' + val.name + '</option>';
                        })
                        $('#sub_category_id').html(option).attr('disabled', false);
                    } else {
                        $('#sub_category_id').html(option).attr('disabled', true);
                    }
                });
        }

        $('#category_id').on('change', function() {
            var cat_id = $(this).val();
            subCategory(cat_id, '');
        });
    });
</script>
@endpush

@endsection