@extends('user.layouts.layouts')
@section('content')
<style>
.order-card {
    color: #fff;
}

.bg-c-blue {
    background: linear-gradient(45deg,#4099ff,#73b4ff);
}

.bg-c-green {
    background: linear-gradient(45deg,#2ed8b6,#59e0c5);
}

.bg-c-yellow {
    background: linear-gradient(45deg,#FFB64D,#ffcb80);
}

.bg-c-pink {
    background: linear-gradient(45deg,#FF5370,#ff869a);
}


.card {
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    border: none;
    margin-bottom: 30px;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

.card .card-block {
    padding: 25px;
}

.order-card i {
    font-size: 26px;
}

.f-left {
    float: left;
}

.f-right {
    float: right;
}
</style>

<div class="content-wrapper pb-0">
    <!-- <div class="card shadow mb-4"> -->

    <!-- </div> -->
    <div class="page-header flex-wrap">
        <div class="header-right d-flex flex-wrap mt-2 mt-sm-0">
            <div class="d-flex align-items-center">
                <h5>{{ ucfirst(auth()->user()->role) }} Dashboard</h5>
            </div>
        </div>
    </div>

    <!-- first row starts here -->
    <div class="row">
        @if(Auth::user()->role == 'warehouse')
        <div class="col-xl-12 stretch-card grid-margin">
            <div class="card">
                <div class="card-header">
                    <h6>Order</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order Number</th>
                                    <th>Order Date</th>
                                    <th>Payment Type</th>
                                    <th>Order Total</th>
                                    <th>Order Status</th>
                                    <th>Total Product</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $key=>$order)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$order->order_no}}</td>
                                    <td>{{$order->dFormat((int)$order->created)}}</td>
                                    <td>{{$order->payment_type}}</td>
                                    <td>{{$order->order_total}}</td>
                                    <td>{{$order->order_status}}</td>
                                    <td>{{count(array_unique($order->products, SORT_REGULAR))}}</td>
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-sm btn-info order_challan" data-id="{{$order->_id}}"><i class="mdi mdi-file"></i></a>
                                        @if($order->order_status == 'pending')
                                        <a href="javascript:void(0);" class="btn btn-md btn-success change_status_one" data-id="{{$order->_id}}">Accept</a>
                                        <a href="javascript:void(0);" class="btn btn-md btn-danger change_status_two" data-id="{{$order->_id}}">Reject</a>
                                        @endif
                                        @if($order->order_status == 'accepted' || $order->order_status == 'processing' || $order->order_status == 'complete')
                                        <a href="javascript:void(0);" class="btn btn-sm btn-primary order_info" data-id="{{$order->_id}}"><i class="mdi mdi-truck"></i></a>
                                        @endif
                                        <a href="javascript:void(0);" class="btn btn-sm btn-primary order-view" _id="{{$order->_id}}"><i class="mdi mdi-information"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                    <tr>
                                        <td colspan="8">
                                            {{-- {{$orders->links()}} --}}
                                        </td>
                                    </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-xl-3 stretch-card grid-margin">

        </div>
    </div>


</div>

<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 70%;" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHeading">Order Details</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="body-html">


            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="order_accept" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 70%;" role="document">

        <form method="POST" action="{{url('user/orders')}}" class="modal-content">
            @csrf
            <input type="hidden" name="id" id="order-id">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHeading">Change Order Progress</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="body-html2">

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

@push('modal')
<!-- Modal -->
<div class="modal fade" id="addChallanModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 40% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Generate Challan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="cover-loader d-none">
                <div class="loader"></div>
            </div>

            <div class="modal-body h-body">

                <form id="save-challan" action="{{url('user/warehouse/challan')}}" method="post" enctype="multipart/form-data">
                    @csrf


                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Order Number</label>
                            <select class="form-control form-control-sm select2" name="o_ids[]" multiple="multiple" id="o_ids" required>
                                <option value="">Select</option>
                                @foreach($uncompletedOrders as $key => $v)
                                <option value="{{$v->_id}}">{{$v->order_no}}</option>
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
                            <input type="text" class="form-control form-control-sm" name="driver_name" placeholder="Enter Driver Name" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Driver Mobile No.</label>
                            <input type="number" name="driver_mobile" class="form-control form-control-sm" placeholder="Enter Mobile No" required>
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
                            <input type="number" name="bill_amount" class="form-control form-control-sm" placeholder="Enter Bill Amount" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Received By</label>
                            <input type="text" class="form-control form-control-sm" name="received_by" placeholder="Received By" required>
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

@if(session()->has('success'))
    Swal.fire('success','Challan Generated Successfully.','success');
@endif


@if(session()->has('error'))
    Swal.fire('error','Challan Generated Successfully.','error');
@endif

$(document).on('click', '.order_challan', function(e) {
        e.preventDefault();
        $("#o_ids").select2({});
        $('.select2-container').css("width", "100%");
        $('#addChallanModel').modal('show');
    });

    $(document).on('click', '.order-view', function() {
        let id = $(this).attr('_id');

        axios.get('order-detail/' + id).then((response) => {

            let res = response.data.order;
            let html = `<div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive card">
                        <table class="table">
                            <thead>
                                <tr><th>Order Number</th><td>${res.order_no ??''}</td>
                                <th>Order Date</th><td>${res.order_date??''}</td>
                                <th>Order Total</th><td>${res.order_total??''}</td></tr>
                               <tr><th>Payment Type</th><td>${res.payment_type??''}</td>
                                <th>Order Status</th><td>${res.order_status??''}</td></tr>
                            </thead>
                        </table>
                        </div>
                    </div>
                </div>`;

            let shipping = res.shipping_details;
            html += `<hr/>
               <div class="row">
                    <div class="col-md-6">
                       <h6 class="text-primary">Shipping Details</h6>
                        <div class="table-responsive card">
                        <table class="table">
                            <tbody>
                                <tr><th>First Name</th><td>${shipping.first_name??''}</td></tr>
                                <tr><th>Last Name</th><td>${shipping.last_name??''}</td></tr>
                                <tr><th>Email</th><td>${shipping.email_id??''}</td></tr>
                                <tr><th>Phone No</th><td>${shipping.phone_no??''}</td></tr>
                                <tr><th>Pincode</th><td>${shipping.pincode??''}</td></tr>
                                <tr><th>City</th><td>${shipping.city??''}</td></tr>
                                <tr><th>State</th><td>${shipping.state??''}</td></tr>
                                <tr><th>Country</th><td>${shipping.country??''}</td></tr>
                                <tr><th>Address 1</th><td>${shipping.address_1??''}</td></tr>
                                <tr><th>Address 2</th><td>${shipping.address_2??''}</td></tr>
                            </tbody>
                        </table>
                        </div>
                    </div>`;

            let billing = res.billing_details;
            html += `<div class="col-md-6">
                       <h6 class="text-primary">Billing Details</h6>
                        <div class="table-responsive card">
                        <table class="table">
                           <tbody>
                                <tr><th>First Name</th><td>${billing.first_name??''}</td></tr>
                                <tr><th>Last Name</th><td>${billing.last_name??''}</td></tr>
                                <tr><th>Email</th><td>${billing.email_id??''}</td></tr>
                                <tr><th>Phone No</th><td>${billing.phone_no??''}</td></tr>
                                <tr><th>Pincode</th><td>${billing.pincode??''}</td></tr>
                                <tr><th>City</th><td>${billing.city??''}</td></tr>
                                <tr><th>State</th><td>${billing.state??''}</td></tr>
                                <tr><th>Country</th><td>${billing.country??''}</td></tr>
                                <tr><th>Address 1</th><td>${billing.address_1??''}</td></tr>
                                <tr><th>Address 2</th><td>${billing.address_2??''}</td></tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                   </div>`;

            let products = res.products;
            html += `<hr><div class="row">
                       <div class="col-md-12">
                       <h6 class="text-primary">Product Details</h6>
                           <div class="table-responsive card">
                               <table class="table">
                                   <tbody>
                                       <tr>
                                           <th>#</th>
                                           <th>Image</th>
                                           <th>Title</th>
                                           <th>SKU</th>
                                           <th>Price</th>
                                           <th>Unit</th>
                                           <th>Brand</th>
                                           <th>Category</th>
                                           <th>Sub Category</th>
                                       </tr>`;
            $.each(products, (index, val) => {
                html += `<tr><td>${++index}</td>
                         <td><img src="${val.image_url}" class="img"></td>
                         <td>${val.title??''}</td>
                         <td>${val.sku??''}</td>
                         <td>${val.price??''}</td>
                         <td>${val.unit??''}</td>
                         <td>${val.brand ?? ''}</td>
                         <td>${val.category??''}</td>
                         <td>${val.sub_category??''}</td></tr>`;
            })
            html += `</tbody>
                               </table>
                           </div>
                       </div>
                   </div>`;

            $('#body-html').html(html);

            $('#orderModal').modal('show');
        }).catch((error) => {
            console.log(error);
        });
    });
    $('.order_info').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        axios.get('order-detail/' + id).then((response) => {

            let res = response.data.order;
            let html = `<div class="row">
                           <div class="col-md-12">
                               <div class="table-responsive card">
                                   <table class="table">
                                       <thead>
                                           <tr>
                                               <th>Order Number</th>
                                               <td>${res.order_no ??''}</td>
                                               <th>Order Date</th>
                                               <td>${res.order_date??''}</td>
                                               <th>Order Total</th>
                                               <td>${res.order_total??''}</td>
                                           </tr>
                                           <tr>
                                               <th>Payment Type</th>
                                               <td>${res.payment_type??''}</td>
                                               <th>Order Status</th>
                                               <td>
                                                   <select class='form-control form-control-sm text-dark' name='status'>
                                                       <option ${res.order_status == 'pending' ? 'selected' : ''} value='pending'>Pending</option>
                                                       <option ${res.order_status == 'accepted' ? 'selected' : ''} value='accepted'>Accepted</option>
                                                       <option ${res.order_status == 'processing' ? 'selected' : ''} value='processing'>Processing</option>
                                                       <option ${res.order_status == 'complete' ? 'selected' : ''} value='complete'>Complete</option>
                                                   </select>
                                               </td>
                                           </tr>
                                       </thead>
                                   </table>
                               </div>
                           </div>
                       </div>`;

            let products = res.products;
            let deliveries = res.delivery;
            let uniqueProducts = [...new Map(products.map((item) => [item['_id'], item])).values(), ]
            let elementCount = products.reduce((x, y) => {
                if (x[y['_id']]) {
                    x[y['_id']] += 1;
                } else {
                    x[y['_id']] = 1;
                }
                return x;
            });

            let deliveryItems = new Map();

            $.each(deliveries, (index, item) => {
                if (deliveryItems.has(item.product_id)) {
                    deliveryItems.set(item.product_id, deliveryItems.get(item.product_id) + item.quantity);
                } else {
                    deliveryItems.set(item.product_id, item.quantity);
                }
            });
            html += `<hr><div class="row">
                       <div class="col-md-12">
                           <h6 class="text-primary">Product Details</h6>
                           <div class="table-responsive card">
                               <table class="table">
                                   <tbody>
                                       <tr>
                                           <th>#</th>
                                           <th>Image</th>
                                           <th>Title</th>
                                           <th>SKU</th>
                                           <th>Price</th>
                                           <th>Unit</th>
                                           <th>Total Quantity</th>
                                           <th>Remaining</th>
                                           <th>Received</th>
                                           <th>Action</th>
                                       </tr>`;
            $.each(uniqueProducts, (index, val) => {
                html += `<tr><td>${++index}</td>
                           <td><img src="${val.image_url}" class="img"></td>
                           <td>${val.title??''}</td>
                           <td>${val.sku??''}</td>
                           <td>${val.price??''}</td>
                           <td>${val.unit??''}</td>
                           <td>${(elementCount[val._id] ?? 0) + (index == 1 ? 1 : 0) }</td>
                           <td>${(((elementCount[val._id] ?? 0) + (index == 1 ? 1 : 0)) - (deliveryItems.get(val._id) ?? 0)) ?? 0}</td>
                           <td>${deliveryItems.get(val._id) ?? 0}</td>`;

                if (((elementCount[val._id] ?? 0) + (index == 1 ? 1 : 0)) - (deliveryItems.get(val._id) ?? 0) > 0) {
                    html += `<td>
                               <input type='hidden' name='product_id[]' value='${val._id}'>
                               <input type='number' name='quantity[]' value='${((elementCount[val._id] ?? 0) + (index == 1 ? 1 : 0)) - (deliveryItems.get(val._id) ?? 0)}' class='form-control form-control-sm' min='0' max='${(elementCount[val._id] ?? 0) + (index == 1 ? 1 : 0) }' placeholder='Add quantity' >
                           </td>`;
                } else {
                    html += `<td></td>`;
                }
            })
            html += `</tbody>
                       </table>
                           </div>
                       </div>
                   </div>`;

            $('#order-id').val(id);

            $('#body-html2').html(html);

            $('#order_accept').modal('show');
        }).catch((error) => {
            console.log(error);
        });
    });
</script>
@endpush
@endsection
