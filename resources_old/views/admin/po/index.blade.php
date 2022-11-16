@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">

    <div class="card shadow mb-4">

        <x-page-head title="Product Order List" url="admin/po/create" type="list" />

        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>PO No</th>
                            <th>Supplier Name</th>
                            <th>Store Name</th>
                            <th>Created</th>
                            <!-- <th>Action</th> -->
                            <!-- <th>Category</th>
                            <th>Sub Category</th>
                            <th>Unit</th>
                            <th>Brand</th>
                            <th>Status</th>
                            <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $list->po_no }}</td>
                            <td>{{ !empty($list->Supplier->store_name)? $list->Supplier->store_name:'' }}</td>
                            <td>{{ !empty($list->Warehouse->store_name)?$list->Warehouse->store_name:'' }}</td>
                            <td>{{ $list->dformat($list->created)}}</td>
                            <!-- <td><a href="{{ url('supplier/s-po/'.$list->_id.'/edit') }}" class="btn btn-sm btn-outline-info"><span class="mdi mdi-pencil-box-outline"></span></a></td> -->
                            <!-- <td>{{ !empty($list->Category->name) ? ucwords($list->Category->name): ''}}</td>
                            <td>{{ !empty($list->SubCategory->name) ? ucwords($list->SubCategory->name): ''}}</td>
                            <td>{{ !empty($list->Unit->unit) ? ucwords($list->Unit->unit): ''}}</td>
                            <td>{{ !empty($list->Brand->brand) ? ucwords($list->Brand->brand): ''}}</td>
                            <td>{!!$list->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">In Active</span>'!!}</td>
                            <td>
                                <a href="{{ url('admin/product/'.$list->_id.'/edit') }}" class="btn btn-sm btn-outline-info"><span class="mdi mdi-pencil-box-outline"></span></a>
                                <a onclick="return confirm('Are you sure to detele this?')" href="" class="btn btn-sm btn-outline-danger"><span class="mdi mdi-delete"></span></a>
                            </td> -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
    $(document).ready(function() {

        $('#assingProduct').click(function() {
            $("#products").select2({});
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
                        $('form#assignSupplier')[0].reset();
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
    })
</script>
@endpush
@endsection
