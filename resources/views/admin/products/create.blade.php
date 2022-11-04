@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">
    <div class="card shadow mb-4">

        <div class="cover-loader d-none">
            <div class="loader"></div>
        </div>
        <x-page-head title="Add Product " url="admin/product" type="create" />

        <div class="card-body h-body">
            <div class="row">

                <div class="col-lg-12">
                    <form id="product" action="{{url('admin/product')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Title<span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control form-control-sm" placeholder="Enter Title">
                                <span id="title_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>SKU<span class="text-danger">*</span></label>
                                <input type="text" name="sku" id="sku" class="form-control form-control-sm" placeholder="Enter SKU">
                                <span id="sku_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Category<span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" id="category_id" name="category">
                                    <option value="">Select</option>
                                    @foreach($categories as $list)
                                    <option value="{{ $list->_id }}">{{ ucwords($list->name)}}</option>
                                    @endforeach
                                </select>
                                <span id="category_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Sub Category<span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" id="sub_category_id" disabled name="sub_category">
                                    <option value="">Select</option>
                                </select>
                                <span id="sub_category_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Unit<span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" id="e3" name="unit_id">
                                    <option value="">Select</option>
                                    @foreach($units as $list)
                                    <option value="{{ $list->_id }}">{{ ucwords($list->unit)}}</option>
                                    @endforeach
                                </select>
                                <span id="unit_id_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Brand<span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" id="brand_id" name="brand_id">
                                    <option value="">Select</option>
                                    @foreach($brands as $list)
                                    <option value="{{ $list->_id }}">{{ ucwords($list->brand)}}</option>

                                    @endforeach
                                </select>
                                <span id="brand_id_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control form-control-sm">
                                <span id="image_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Status<span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" id="status" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
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
                $('span.c-text-danger').html('');
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
        $('#category_id').change('click', function() {
            var cat_id = $(this).val();
            var url = "{{ url('admin/sub_category') }}/" + cat_id;
            axios.get(url)
                .then(function(response) {
                    res = response.data;
                    var option = '<option value="">Select</option>';
                    if (res) {
                        $.each(res, (index, val) => {
                            option += '<option value="' + val._id + '" >' + val.name + '</option>';
                        })
                        $('#sub_category_id').html(option).attr('disabled', false);
                    } else {
                        $('#sub_category_id').html(option).attr('disabled', true);
                    }

                });
        });
    });
</script>
@endpush
@endsection