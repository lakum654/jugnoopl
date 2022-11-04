@extends('user.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">
    <div class="card shadow mb-4">

        <div class="cover-loader d-none">
            <div class="loader"></div>
        </div>

        <x-page-head title="Purchase Order" url="user/supplier-po" type="create" />

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
                                <div class="col-md-3 mt-1">
                                    <span><b>Item Status:</b>
                                        {{ $po->item_status}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <form id="save-item" action="{{url('user/supplier-save-item')}}">
                        @csrf
                        <input type="hidden" name="po_id" value="{{$po->_id}}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>SKU</th>
                                                <th>Unit</th>
                                                <th>Pending Qty</th>
                                                <th>Requested Qty</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">

                                            @forelse($items as $key=>$item)
                                            <tr>
                                                <td>{{++$key}}
                                                    <input type="hidden" name="items[{{$key}}][id]" value="{{$item->_id}}">
                                                </td>
                                                <td>{{$item->title}}</td>
                                                <td>{{$item->sku}}</td>
                                                <td>{{$item->unit}}</td>
                                                <td>{{$item->pending_qty}}</td>
                                                <td>{{$item->req_qty}}</td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm" {{($item->pending_qty <=0)?'disabled':''}} name="items[{{$key}}][send_qty]" placeholder="Enter Qty">
                                                    <span class="c-text-danger" id="items-{{$key}}-send_qty"></span>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm" {{($item->pending_qty <=0)?'disabled':''}} name="items[{{$key}}][price]" value="{{$item->price}}" placeholder="Enter Price">
                                                    <span class="c-text-danger" id="items-{{$key}}-price"></span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Not Found Any Item!</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        @if($po->item_status !='complete')
                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <input type="submit" value="Submit" class="btn btn-success">
                                <button type="reset" class="btn btn-warning"><span class="mdi mdi-rotate-left"></span>&nbsp;Reset</button>
                            </div>
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
    $('form#save-item').submit(function(e) {
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
                    let index1 = index.replace('.', '-');
                    console.log(`${index1.replace('.', '-')}`);
                    $(`#${index1.replace('.', '-')}`).html(`${msg}`);
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
                    $('form#save-item')[0].reset();
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