@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">

    <div class="card shadow mb-4">

        <x-page-head title="Supplier Product List" />

        <div class="card-body p-2">

            <div class="row">
                <div class="form-group col-md-3">
                    <select class="form-control form-control-sm" id="selectSupplier">
                        <option value="">Select Supplier</option>
                        @foreach($suppliers as $list)
                        <option value="{{ $list->_id }}" {{ (app('request')->input('supplier_id')==$list->_id)?"selected":"" }}>{{ ucwords($list->store_name)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped table-hovered">
                    <!-- <thead> -->
                    <tr>
                        <th>#</th>
                        <th>Supplier Name</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Date Range</th>
                        <th>Assign Date</th>
                        <th>Action</th>
                    </tr>
                    <!-- </thead> -->
                    <tbody>
                        @if(!empty($lists))
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{!empty($list->Supplier->store_name) ? ucwords($list->Supplier->store_name): ''}}</td>
                            <td>{{!empty($list->Product->title) ? ucwords($list->Product->title): ''}}</td>
                            <td>{{ $list->price }}</td>
                            <td>{{ !empty($list->start_date) ? $list->start_date:'' }} To {{ !empty($list->end_date) ? $list->end_date: ''}}</td>
                            <td>{{ $list->dformat($list->created)}}</td>
                            <td>
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-info contractProduct" _id="{{$list->_id}}"><span class="mdi mdi-book-plus"></span></a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7" class="text-center">Not Found Any Record</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@push('modal')
<!-- Modal -->
<div class="modal fade" id="ContractProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHeading">Make Contract</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="cover-loader d-none">
                <div class="loader"></div>
            </div>

            <div class="modal-body h-body">
                <form id="contractProduct" action="" method="post">
                    @csrf
                    <div id="put"></div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Price</label>
                            <input type="text" name="price" id="price" class="form-control form-control-sm" placeholder="Enter Price" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Date Range</label>
                            <input type="text" id="daterange" class="form-control form-control-sm daterange" name="daterange">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success" id="submitproduct">Submit</button>
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

        //for supplier select filter
        $('#selectSupplier').on('load change', function() {
            window.location.href = window.location.origin + '/admin/supplier-product' + '? supplier_id=' + $(this).val();
        })

        $('form#contractProduct').submit(function(e) {
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
                        $('form#contractProduct')[0].reset();
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


        //for edit
        $('.contractProduct').click(function() {

            let id = $(this).attr('_id');

            let url = `{{url('admin/supplier-product')}}/${id}/edit`;

            axios.get(url).then(resp => {
                response = resp.data.data;

                $('#price').val(response.price);
                $('#start_date').val(response.start_date);
                $('#end_date').val(response.end_date);

                $('form#contractProduct').attr('action', '{{url("admin/supplier-product")}}/' + id);
                $('#put').html('<input type="hidden" name="_method" value="PUT">');
                $('#ContractProductModal').modal('show');

            }).catch(function(error) {
                console.log(error);
                error = error ?? '';
                Swal.fire(
                    `Error!`,
                    error,
                    `error`,
                );
            });
        })

    })
</script>
@endpush
@endsection