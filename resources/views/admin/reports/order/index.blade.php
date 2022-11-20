@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">

    <div class="card shadow mb-4">

        <x-modal-head title="Order Report" id="addUnit" />

        <div class="card-body p-2">

            <div class="card-header">
                <div class="row">
                    <div class="col-md-3">
                        <select name="warehouse_id" id="warehouse_id" class="form-control form-control-sm">
                            <option value="">Select Warehouse</option>
                            <option value="All">All</option>
                            @foreach ($warehouse as $key => $val)
                                    <option value="{{ $val->_id}}" @if(request()->query('warehouse_id') == $val->_id) selected @endif>{{ $val->store_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="status" id="status" class="form-control form-control-sm">
                            <option value="">Select Status</option>
                            <option value="All">All</option>
                            <option value="pending"  @if(request()->query('status') == 'pending') selected @endif>Pending</option>
                            <option value="accepted" @if(request()->query('status') == 'accepted') selected @endif >Accepted</option>
                            <option value="processing" @if(request()->query('status') == 'processing') selected @endif >Processing</option>
                            <option value="complete" @if(request()->query('status') == 'complete') selected @endif>Completed</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order No</th>
                            <th>Warehouse</th>
                            <th>Order Date</th>
                            <th>Payment Type</th>
                            <th>Order Amount</th>
                            <th>Status</th>
                            <th>No Of Product</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($orderData as $key => $order)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$order->order_no}}</td>
                                <td>{{$order->wearhouse->store_name ?? '-'}}</td>
                                <td>{{$order->dFormat((int)$order->created)}}</td>
                                <td>{{$order->payment_type}}</td>
                                <td>{{number_format($order->order_total,2)}}</td>
                                <td><span class="badge badge-info">{{ucfirst($order->order_status)}}</span></td>
                                <td>{{count(array_unique($order->products, SORT_REGULAR))}}</td>
                                {{-- <td><a href="javascriv:void(0)">View</a></td> --}}
                            </tr>
                            @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="8">
                                {{ $orderData->links()}}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>

@push('modal')
<!-- Modal -->
<div class="modal fade" id="unitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHeading">Add Unit</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="cover-loader d-none">
                <div class="loader"></div>
            </div>


            <div class="modal-body h-body">
                <form id="unit" action="" method="post">
                    @csrf
                    <div id="put"></div>

                    <div class="form-group">
                        <label>Unit Name</label>
                        <input type="text" name="unit" id="unit_name" class="form-control form-control-sm" placeholder="Enter Unit Name">
                        <span id="unit_msg" class="c-text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control form-control-sm" id="status" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success" id="submitunit">Submit</button>
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
        $('#warehouse_id').on('load change', function() {
            window.location.href = window.location.origin + `/admin/order_report/?warehouse_id=`+$(this).val();
        })

        $('#status').on('load change', function() {
            var warehouse_id = $('#warehouse_id').val();
            var status = $('#status').val();
            if(status == 'All') {
                window.location.href = window.location.origin + `/admin/order_report/?warehouse_id=`+$(this).val();
            } else {
                window.location.href = `/admin/order_report?warehouse_id=${warehouse_id}&status=${status}`;
            }

        })
    })
</script>
@endpush
@endsection


