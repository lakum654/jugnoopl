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

        <x-page-head title="PO Items" url="user/w-po" type="create" />

        <div class="card-body h-body">
            <div class="row">

                <div class="col-lg-12">

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
                            <span>{{$grn->dFormat($grn->receiving_date)}}</span>
                        </div>
                        <div class="col-md-1">
                            @if($grn->status =='pending')
                            <span class="badge badge-outline-warning badge-pill">Pending</span>
                            @elseif($grn->status =='completed')
                            <span class="badge badge-outline-success badge-pill">Completed</span>
                            @endif
                        </div>
                    </div>
<hr>
                    <form id="update-po-item" action="{{url('user/w-update-po-item')}}" method="post">
                        <input type="hidden" name="grn_id" value="{{$grn->_id}}">
                        <table class="table table-striped">
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

                            <tbody id="table-body">
                                @csrf

                                @forelse($po_items as $key=>$item)
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
                                        <input type="number" class="form-control form-control-sm h-25 received-qty" value="{{!empty($item->received_qty)?$item->received_qty:''}}" {{!empty($item->received_qty)?'readonly':''}} name="items[{{$key}}][received_qty]">
                                        <div class="c-text-danger received_qty_{{$key}}" id="received_qty"></div>
                                    </td>
                                    <td class="w-25">
                                        <input type="number" class="form-control form-control-sm h-25 good-qty" value="{{!empty($item->good_qty)?$item->good_qty:''}}" {{!empty($item->good_qty)?'readonly':''}} name="items[{{$key}}][good_qty]">
                                    </td>
                                    <td class="w-25">
                                        <input type="number" class="form-control form-control-sm h-25 bad-qty" value="{{!empty($item->bad_qty)?$item->bad_qty:''}}" {{!empty($item->bad_qty)?'readonly':''}} name="items[{{$key}}][bad_qty]">
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
                        </table>
                        @if($grn->status !='completed')
                        <div class="form-group text-right">
                            <input type="submit" value="Save" class="btn btn btn-primary">
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@push('script')
<script>
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
    $('form#update-po-item').submit(function(e) {
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