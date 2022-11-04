@extends('user.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">

    <div class="card shadow mb-4">

        @php $addons = ['assign'=>['selector'=>'addGrn','name'=>'Add GRN']];@endphp
        <x-page-head title="Purchase Order List" :addons=$addons />

        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>PO No</th>
                            <th>Supplier Name</th>
                            <th>Warehouse Name</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $list->po_no }}</td>
                            <td>{{ !empty($list->Supplier->store_name)?$list->Supplier->store_name:'' }}</td>
                            <td>{{ !empty($list->Warehouse->store_name)?$list->Warehouse->store_name:'' }}</td>
                            <td>{{ $list->dFormat($list->created)}}</td>
                            <td><a href="javascript:void(0);" class="btn btn-sm btn-outline-info view-item" _id="{{$list->_id}}"><span class="mdi mdi-eye"></span></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@push('modal')
<!-- Modal -->
<div class="modal fade" id="viewItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 50% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Item List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="viewItem">

            </div>

        </div>
    </div>
</div>
@endpush

@push('modal')
<!-- Modal -->
<div class="modal fade" id="addGrnModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 40% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add GRN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="cover-loader d-none">
                <div class="loader"></div>
            </div>

            <div class="modal-body h-body">

                <form id="save-grn" action="{{url('user/grn')}}" method="post" enctype="multipart/form-data">
                    @csrf


                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>PO Number</label>
                            <select class="form-control form-control-sm select2" name="po_ids[]" multiple="multiple" id="po_ids">
                                <option value="">Select</option>
                                @foreach($lists as $list)
                                <option value="{{$list->_id}}">{{$list->po_no}}</option>
                                @endforeach
                            </select>
                            <!-- <input type="text" class="form-control form-control-sm" name="po_no" placeholder="Enter PO Number"> -->
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Receiving Date</label>
                            <input type="date" name="receiving_date" class="form-control form-control-sm">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Driver Name</label>
                            <input type="text" class="form-control form-control-sm" name="driver_name" placeholder="Enter Driver Name">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Driver Mobile No.</label>
                            <input type="number" name="driver_mobile" class="form-control form-control-sm" placeholder="Enter Mobile No">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Vehicle No</label>
                            <input type="text" class="form-control form-control-sm" name="vehicle_no" placeholder="Enter Vehicle No">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Type of Supply</label>
                            <input type="text" name="type_of_supply" class="form-control form-control-sm" placeholder="Supply Type">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Challen No./Bill No</label>
                            <input type="file" class="form-control form-control-sm" name="channel_no">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Bill Amount</label>
                            <input type="number" name="bill_amount" class="form-control form-control-sm" placeholder="Enter Bill Amount">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Received By</label>
                            <input type="text" class="form-control form-control-sm" name="received_by" placeholder="Received By">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Remarks</label>
                        <textarea name="remarks" class="form-control form-control-sm" rows="2" placeholder="Enter Remark"></textarea>
                    </div>

                    <div class="form-group text-center">
                        <input type="submit" value="Submit" class="btn btn-primary">
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
@endpush

@push('script')
<script>
    $('#addGrn').click(function(e) {
        e.preventDefault();
        $("#po_ids").select2({});
        $('.select2-container').css("width", "100%");
        $('#addGrnModal').modal('show');
    });


    //save grn herer
    $('form#save-grn').submit(function(e) {
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
                    // $('form#save-item')[0].reset();
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
    });

    $('.view-item').click(function() {

        let id = $(this).attr('_id');
        let url = "{{url('user/view-item')}}/" + id;
        axios.get(url).then(function(response) {
            let res = response.data.data;

            $('#viewItem').html(res);
            $('#viewItemModal').modal('show');
        }).catch(function(error) {
            console.log(error);
        })

    })
</script>
@endpush

@endsection