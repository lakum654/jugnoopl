@extends('admin.layouts.layouts')
@section('content')
    <div class="content-wrapper pb-0">

        <div class="card mb-4">
            <div class="card-header">
                <h3>Order Details:</h3>
            </div>

            <div class="card-body p-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Purchase Order No:</label>
                            <input type="text" class="form-control" value="{{ $PO->po_no }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="">Created At:</label>
                            <input type="text" class="form-control" value="{{ date('d M Y',$PO->created) }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="">Item Status:</label>
                            <input type="text" class="form-control" value="{{ $PO->item_status }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h3>Supplier Info</h3>
            </div>

            <div class="card-body p-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Supplier Name:</label>
                            <input type="text" class="form-control" value="{{ $PO->supplier->store_name }}" readonly>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h3>Warehouse Info</h3>
            </div>

            <div class="card-body p-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Warehouse Name:</label>
                            <input type="text" class="form-control" value="{{ $PO->Warehouse->store_name }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h3>Order Items</h3>
            </div>

            <div class="card-body p-2">
                <div class="card-body">
                    @if(count($PO->Items))
                        @foreach ($PO->Items as $items)
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Item Name:</label>
                                    <input type="text" class="form-control" value="{{ $items->title }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Price By Supplier:</label>
                                    <input type="text" class="form-control" value="{{ $items->price_by_supplier }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Send Quantity:</label>
                                    <input type="text" class="form-control" value="{{ $items->send_qty }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Request Quantity:</label>
                                    <input type="text" class="form-control" value="{{ $items->req_qty }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Pending Quantity:</label>
                                    <input type="text" class="form-control" value="{{ $items->pending_qty }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Price:</label>
                                    <input type="text" class="form-control" value="{{ $items->price }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Unit:</label>
                                    <input type="text" class="form-control" value="{{ $items->unit }}" readonly>
                                </div>
                            </div>

                            <hr>
                        @endforeach
                    @endif
                </div>

                <div class="card-footer">
                    <a href="{{ url('admin/po/in-progress') }}" class="btn btn-danger float-right">Back</a>
                </div>
            </div>
        </div>

    </div>

    @push('script')
        <script>
            $(document).ready(function() {


            })
        </script>
    @endpush
@endsection
