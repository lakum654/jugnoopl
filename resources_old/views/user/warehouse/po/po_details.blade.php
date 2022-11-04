@extends('user.layouts.layouts')
@section('content')
<style>
    .heading {
        font-weight: 600;
    }

    th td {
        font-size: 12px;
    }

    .border-top {
        border-top: 1px solid #e4e9f0;
        padding-top: 10px;
    }
</style>

<div class="content-wrapper pb-0">
    <div class="card shadow mb-4">

        <div class="cover-loader d-none">
            <div class="loader"></div>
        </div>

        @if($po->po_status !='completed')
        @php $addons = ['assign'=>['selector'=>'addGrn','name'=>'Add GRN']];@endphp
        @else
        @php $addons = []; @endphp
        @endif
        <x-page-head title="Purchase Order" url="warehouse/w-po" type="create" :addons=$addons />

        <div class="card-body h-body">
            <div class="row">

                <div class="col-lg-12">
                    <div class="row mb-3">
                        <div class="col-md-12 card">
                            <div class="row p-2">
                                <div class="col-md-3">
                                    <span>
                                        <b> PO#:</b>
                                        {{$po->po_no}}
                                    </span>

                                </div>
                                <div class="col-md-3">
                                    <span> <b>Warehouse:</b>
                                        {{!empty($po->Warehouse->store_name)?ucwords($po->Warehouse->store_name):''}}</span>
                                </div>
                                <div class="col-md-3">
                                    <span><b>Supplier:</b>
                                        {{!empty($po->Supplier->store_name)?ucwords($po->Supplier->store_name):''}}
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    <span><b>Estimated Delivery:</b>
                                        {{ $po->dFormat($po->created)}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="accordion">
                        @forelse($grns as $k=>$grn)

                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <a href="javascript:void(0)" class="text-dark" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <span class="font-weight-bold">#</span>{{$grn->grn_no}}
                                            </div>
                                            <div class="col-md-3">
                                                <span class="font-weight-bold">Bill Amount:</span>
                                                <span>{{$grn->bill_amount}}</span>
                                            </div>
                                            <div class="col-md-4">
                                                <span class="font-weight-bold">Receiving Date:</span>
                                                <span>{{$grn->receiving_date}}</span>
                                            </div>
                                            <div class="col-md-1">
                                                @if($grn->status =='pending')
                                                <span class="badge badge-outline-warning badge-pill">Pending</span>
                                                @elseif($grn->status =='completed')
                                                <span class="badge badge-outline-success badge-pill">Completed</span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </h5>
                            </div>

                            <div id="collapseOne" class="collapse {{$loop->last?'show':''}}" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    <table class="table table-secondary table-borderless grn-table">
                                        <tr>
                                            <th>Driver Name</th>
                                            <td>{{$grn->driver_name}}</td>
                                            <th>Driver Mobile</th>
                                            <td>{{$grn->driver_mobile}}</td>
                                            <th>Vehicle No</th>
                                            <td>{{$grn->vehicle_no}}</td>
                                            <th>Type Of Supply</th>
                                            <td>{{$grn->type_of_supply}}</td>
                                        </tr>
                                        <tr>
                                            <th>Received By</th>
                                            <td>{{$grn->received_by}}</td>
                                            @if(!empty($challen_no))
                                            <th>Channel No</th>
                                            <td>{{$grn->challen_no}}</td>
                                            @endif
                                            <th>Remarks</th>
                                            <td>{{$grn->remarks}}</td>
                                        </tr>
                                    </table>

                                    <form id="save-grn-item" action="{{url('user/save-grn-item')}}" method="post">
                                        <table class="table  table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Product</th>
                                                    <th>SKU</th>
                                                    <th>Price</th>
                                                    <th>Requested Qty</th>
                                                    <th>Sent Qty</th>
                                                    <th class="w-25">Received Qty</th>
                                                    <th class="w-25">Good</th>
                                                    <th class="w-25">Bad</th>
                                                    <th>Pending Qty</th>
                                                    <!-- <th class="w-25">Received Qty</th> -->
                                                </tr>
                                            </thead>
                                            @if(!empty($grn->grn_items) && !empty($grn->GrnItems))
                                            <tbody id="table-body">

                                                @csrf
                                                <input type="hidden" name="grn_id" value="{{$grn->_id}}">
                                                <input type="hidden" name="po_id" value="{{$po->_id}}">
                                                @php $i = 0;@endphp

                                                @forelse($grn->GrnItems as $key=>$item)
                                                <tr>
                                                    <td>{{++$i}}
                                                        <input type="hidden" name="items[{{$key}}][po_item_id]" value="{{$item->po_item_id}}">
                                                        <input type="hidden" name="items[{{$key}}][_id]" value="{{$item->_id}}">
                                                        <input type="hidden" name="items[{{$key}}][product_id]" value="{{$item->product_id}}">
                                                    </td>
                                                    <td>
                                                        <span data-toggle="tooltip" data-html="true" title="{{ (!empty($grn->poItems[$key]['title']) && strlen($grn->poItems[$key]['title'])>20)?$grn->poItems[$key]['title']:''}}">{{ !empty($grn->poItems[$key]['title'])?mb_strimwidth($grn->poItems[$key]['title'],0,20,'...'):''}}</span>
                                                    </td>
                                                    <td>{{!empty($grn->poItems[$key]['sku'])?$grn->poItems[$key]['sku']:''}}</td>
                                                    <td>{{!empty($grn->poItems[$key]['price'])?$grn->poItems[$key]['price']:''}}</td>

                                                    <td>{{!empty($grn->poItems[$key]['req_qty'])?$grn->poItems[$key]['req_qty']:''}}<small class=" ml-1">{{!empty($grn->poItems[$key]['unit'])?$grn->poItems[$key]['unit']:''}}</small></td>
                                                    <td>{{!empty($grn->poItems[$key]['send_qty'])?$grn->poItems[$key]['send_qty']:''}}
                                                        <input type="hidden" class="sent-qty" value="{{!empty($grn->poItems[$key]['send_qty'])?$grn->poItems[$key]['send_qty']:''}}">
                                                    </td>
                                                    <td class="w-25">
                                                        <input type="number" class="form-control form-control-sm h-25 received-qty" name="items[{{$key}}][received_qty]" value="{{$item->received_qty}}" {{($item->pending_qty <=0)?'disabled':''}}>
                                                        <div class="c-text-danger received_qty_{{$key}}" id="received_qty"></div>
                                                    </td>
                                                    <td class="w-25">
                                                        <input type="number" class="form-control form-control-sm h-25 good-qty" name="items[{{$key}}][good_qty]" value="{{$item->good_qty}}" {{($item->pending_qty <=0)?'disabled':''}}>
                                                    </td>
                                                    <td class=" w-25">
                                                        <input type="number" class="form-control form-control-sm h-25 bad-qty" name="items[{{$key}}][bad_qty]" value="{{$item->bad_qty}}" {{($item->pending_qty <=0)?'disabled':''}}>
                                                    </td>
                                                    <td>
                                                        <span class=" pending-qty">{{$item->pending_qty}}</span>
                                                        <input type="hidden" class="fix-pending" value="{{$item->pending_qty}}">
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">Not Found Any Item!</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                            @else
                                            <tbody id="table-body">
                                                @csrf
                                                <input type="hidden" name="grn_id" value="{{$grn->_id}}">
                                                <input type="hidden" name="po_id" value="{{$po->_id}}">

                                                @forelse($items as $key=>$item)
                                                <tr>
                                                    <td>{{++$key}}
                                                        <input type="hidden" name="items[{{$key}}][po_item_id]" value="{{$item->_id}}">
                                                        <input type="hidden" name="items[{{$key}}][product_id]" value="{{$item->product_id}}">
                                                    </td>
                                                    <td>
                                                        <span data-toggle="tooltip" data-html="true" title="{{strlen($item->title)>20?$item->title:''}}">{{mb_strimwidth($item->title,0,20,'...')}}</span>
                                                    </td>
                                                    <td>{{$item->sku}}</td>
                                                    <td>{{!empty($item->price)?$item->price:''}}</td>
                                                    <td>{{$item->req_qty}}<small class=" ml-1">{{$item->unit}}</small></td>

                                                    <td>{{$item->send_qty}}
                                                        <input type="hidden" class="sent-qty" value="{{$item->send_qty}}">
                                                    </td>
                                                    <td class="w-25">
                                                        <input type="number" class="form-control form-control-sm h-25 received-qty" name="items[{{$key}}][received_qty]">
                                                        <div class="c-text-danger received_qty_{{$key}}" id="received_qty"></div>
                                                    </td>
                                                    <td class="w-25">
                                                        <input type="number" class="form-control form-control-sm h-25 good-qty" name="items[{{$key}}][good_qty]">
                                                    </td>
                                                    <td class="w-25">
                                                        <input type="number" class="form-control form-control-sm h-25 bad-qty" name="items[{{$key}}][bad_qty]">
                                                    </td>
                                                    <td>
                                                        <span class="pending-qty">{{$item->req_qty}}</span>
                                                        <input type="hidden" class="fix-pending" value="{{$item->req_qty}}">
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">Not Found Any Item!</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                            @endif
                                        </table>

                                        @if($grn->status !='completed')
                                        <div class="form-group mt-2 border-top">
                                            <div class="col-sm-12 text-right">
                                                <input type="submit" value="Save" class="btn btn-primary">
                                            </div>
                                        </div>
                                        @endif

                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center">Not found any GRN!</div>
                        @endforelse

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@push('modal')
<!-- Modal -->
<div class="modal fade" id="addGrnModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add GRN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="save-grn" action="{{url('user/save-grn')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" value="{{$po->warehouse_id}}" name="warehouse_id">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Supplier Name</label>
                            <input type="hidden" name="supplier_id" value="{{$po->supplier_id}}">
                            <input type="text" name="supplier_name" class="form-control form-control-sm" readonly placeholder="Seller Name" value="{{!empty($po->Supplier->store_name)?ucwords($po->Supplier->store_name):''}}">
                        </div>

                        <div class="form-group col-md-6">
                            <label>PO Number</label>
                            <input type="hidden" name="po_id" value="{{$po->_id}}">
                            <input type="text" class="form-control form-control-sm" readonly name="po_no" placeholder="Enter PO Number" value="{{$po->po_no}}">
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
                            <input type="test" name="type_of_supply" class="form-control form-control-sm" placeholder="Enter Mobile No">
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
                        <input type="submit" value="Submit" class="btn btn-sm btn-success">
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

    $(document).on('keyup change', '.received-qty', function(e) {
        e.preventDefault();

        let currentRow = $(this).closest("tr");
        let received = currentRow.find("td").find('.received-qty').val();
        let fix_pending_qty = currentRow.find('td').find('.fix-pending').val();
        let sent_qty = currentRow.find('td').find('.sent-qty').val();
        let remaning_qty = parseInt(fix_pending_qty) - parseInt(received);

        if (parseInt(sent_qty) < parseInt(received)) {
            $(currentRow.find('td').find('#received_qty')).html('*Qty should not be greater then Sent Quantity');
            // return false;
        } else {
            // $(currentRow.find('td').find('.save-grn-item')).removeClass('disable-click');
            $(currentRow.find('td').find('#received_qty')).html('');
        }
        currentRow.find('td').find('.pending-qty').val(remaning_qty)
        currentRow.find('td').find('.pending-qty').html(remaning_qty)
    })


    $(document).on('keyup change', '.good-qty,.bad-qty', function(e) {
        e.preventDefault();

        let currentRow = $(this).closest("tr");

        let received = currentRow.find("td").find('.received-qty').val();
        let good_qty = currentRow.find("td").find('.good-qty').val();
        let bad_qty = currentRow.find("td").find('.bad-qty').val();

        let totalQty = (parseInt(good_qty) + parseInt(bad_qty));

        if (parseInt(totalQty) !== parseInt(received)) {
            // should be equal to Received Quantity
            $(currentRow.find('td').find('#received_qty')).html('*Good Qty and Bad Qty should be equal to sent Qty.');
            return false;
        } else {
            $(currentRow.find('td').find('#received_qty')).html('');
        }
    })

    //save grn herer
    $('form#save-grn-item').submit(function(e) {
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
                    $(`.${index}`).html(`${msg}`);
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
</script>
@endpush
@endsection