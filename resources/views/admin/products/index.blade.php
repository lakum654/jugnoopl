@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">

    <div class="card shadow mb-4">

        @php $addons = ['assign'=>['selector'=>'assingProduct','name'=>'Assing']];@endphp
        <x-page-head title="Product List" url="admin/product/create" type="list" :addons=$addons />

        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Unit</th>
                            <th>Brand</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td><img src="{{imgPath('product',$list->image)}}" class="img" /></td>
                            <td>{{ $list->title }}</td>
                            <td>{{ !empty($list->Category->name) ? ucwords($list->Category->name): ''}}</td>
                            <td>{{ !empty($list->SubCategory->name) ? ucwords($list->SubCategory->name): ''}}</td>
                            <td>{{ !empty($list->Unit->unit) ? ucwords($list->Unit->unit): ''}}</td>
                            <td>{{ !empty($list->Brand->brand) ? ucwords($list->Brand->brand): ''}}</td>
                            <td>{!!$list->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">In Active</span>'!!}</td>
                            <td>
                                <a href="{{ url('admin/product/'.$list->_id.'/edit') }}" class="btn btn-sm btn-outline-info"><span class="mdi mdi-pencil-box-outline"></span></a>
                                <a onclick="return confirm('Are you sure to detele this?')" href="" class="btn btn-sm btn-outline-danger"><span class="mdi mdi-delete"></span></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $lists->appends($_GET)->links()}}
            </div>
        </div>
    </div>
</div>

@push('modal')
<!-- Modal -->
<div class="modal fade" id="assingProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHeading">Assign Product</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="cover-loader d-none">
                <div class="loader"></div>
            </div>

            <div class="modal-body h-body">
                <form id="assignProduct" action="{{url('admin/assign-product')}}" method="post">
                    @csrf

                    <div class="form-group">
                        <label>Supplier<span class="text-danger">*</span></label>
                        <select class="form-control form-control-sm" id="supplier_id" name="supplier_id">
                            <option value="">Select</option>
                            @foreach($suppliers as $list)
                            <option value="{{ $list->_id }}">{{ ucwords($list->store_name)}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="supplier_msg"></span>
                    </div>

                    <div class="form-group" id="p-demo">

                    </div>

                    <div class="form-group">
                        <label>Select Products<span class="text-danger">*</span></label>
                        <select class="form-control form-control-sm" multiple="multiple" id="product_id" disabled name="products[]">
                            <option value="">Select</option>

                        </select>
                        <span class="text-danger" id="product_msg"></span>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success" id="Assign">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endpush
@push('script')
<script>
    $(document).ready(function() {

        $('#assingProduct').click(function() {
            $("#product_id").select2({});
            $('.select2-container').css("width", "100%");
            $('#assingProductModal').modal('show');
        });

        $('form#assignProduct').submit(function(e) {

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
                        $('form#assignProduct')[0].reset();
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }

                })
                .catch(function(error) {
                    console.log(error);
                    error = error ?? '';
                    Swal.fire(
                        `Error!`,
                        error,
                        `error`,
                    );
                });
        });


        $('#supplier_id').change(function() {
            var supplier_id = $(this).val();

            axios('get-supplier-product/' + supplier_id).then(function(res) {
                var res = res.data;
                var title = '';

                $.each(res.supplierProducts, function(index, value) {
                    title += `<span class="badge badge-outline-primary">${value.product}</span>`;
                });
                $('#p-demo').html(title);

                var option = '<option value="">Select</option>';
                $.each(res.products, function(index, value) {
                    option += `<option id="${value._id}">${value.title}</option>`;
                });
                $('#product_id').removeAttr('disabled').html(option);
            }).catch(function(error) {
                console.log(error);
            })
        })
    })
</script>
@endpush
@endsection