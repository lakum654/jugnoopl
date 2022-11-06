@extends('user.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">
    <div class="card shadow mb-4">
        <x-page-head title="Order List" />

        <div class="card-body p-2">
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
                            <td>{{$order->dFormat((int)$order->order_date)}}</td>
                            <td>{{$order->payment_type}}</td>
                            <td>{{$order->order_total}}</td>
                            <td>{{$order->order_status}}</td>
                            <td>{{count($order->products)}}</td>
                            <td><a href="javascript:void(0);" class="btn btn-sm btn-primary order-view" _id="{{$order->_id}}"><i class="mdi mdi-information"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="8">
                                {{ $orders->links()}}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@push('script')

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

<script>
    $(document).on('click', '.order-view', function() {
        let id = $(this).attr('_id');
let url = '{{url("user/sho-order")}}/' + id
        axios.get(url).then((response) => {

            let res = response.data.order;
            let html = `<div class="row">
                     <div class="col-md-12">
                         <div class="table-responsive card">
                         <table class="table">
                             <thead>
                                 <tr><th>Order Number</th><td>${res.order_no}</td>
                                 <th>Order Date</th><td>${res.order_date}</td>
                                 <th>Order Total</th><td>${res.order_total}</td></tr>
                                <tr><th>Payment Type</th><td>${res.payment_type}</td>
                                 <th>Order Status</th><td>${res.order_status}</td></tr>
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
                                 <tr><th>First Name</th><td>${shipping.first_name}</td></tr>
                                 <tr><th>Last Name</th><td>${shipping.last_name}</td></tr>
                                 <tr><th>Email</th><td>${shipping.email_id}</td></tr>
                                 <tr><th>Phone No</th><td>${shipping.phone_no}</td></tr>
                                 <tr><th>Pincode</th><td>${shipping.pincode}</td></tr>
                                 <tr><th>City</th><td>${shipping.city}</td></tr>
                                 <tr><th>State</th><td>${shipping.state}</td></tr>
                                 <tr><th>Country</th><td>${shipping.country}</td></tr>
                                 <tr><th>Address 1</th><td>${shipping.address_1}</td></tr>
                                 <tr><th>Address 2</th><td>${shipping.address_2}</td></tr>
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
                                 <tr><th>First Name</th><td>${billing.first_name}</td></tr>
                                 <tr><th>Last Name</th><td>${billing.last_name}</td></tr>
                                 <tr><th>Email</th><td>${billing.email_id}</td></tr>
                                 <tr><th>Phone No</th><td>${billing.phone_no}</td></tr>
                                 <tr><th>Pincode</th><td>${billing.pincode}</td></tr>
                                 <tr><th>City</th><td>${billing.city}</td></tr>
                                 <tr><th>State</th><td>${billing.state}</td></tr>
                                 <tr><th>Country</th><td>${billing.country}</td></tr>
                                 <tr><th>Address 1</th><td>${billing.address_1}</td></tr>
                                 <tr><th>Address 2</th><td>${billing.address_2}</td></tr>
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
                                            <th>Category</th>
                                            <th>Sub Category</th>
                                            <th>Brand</th>
                                            <th>Qty</th>
                                            <th>Unit</th>
                                        </tr>`;
            $.each(products, (index, val) => {
                console.log(val)
                html += `<tr><td>${++index}</td>
                          <td><img src="${val.image}" class="img"></td>
                          <td>${val.title}</td>
                          <td>${val.sku}</td>
                          <td>${val.price}</td>
                          <td>${val.category_id}</td>
                          <td>${val.sub_category}</td>;
                          <td>${val.brand ?? ''}</td>
                          <td>${val.total_qty ?? ''}</td>
                          <td>${val.unit}</td></tr>`
            })
            html += `</tbody>
                                </table>
                            </div>
                        </div>
                    </div>`;

            $('#body-html').html(html);

            $('#orderModal').modal('show');
        }).catch((error) => {

        });
    });
</script>
@endpush
@endsection
