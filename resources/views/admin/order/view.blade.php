@extends('admin.layouts.layouts')
@section('content')

@section('links')
@endsection

<div class="content-wrapper pb-0">
    <div class="page-header flex-wrap">

        <div class="header-right d-flex flex-wrap mt-2 mt-sm-0">
            <div class="d-flex align-items-center">
                <a href="#">
                    <p class="m-0 pr-3">{{ $warehouse->store_name }}' Orders</p>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h6 class="text-primary">{{ $warehouse->store_name }}' Orders</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order Number</th>
                            <th>Wearhouse</th>
                            {{-- <th>Shopkeeper</th> --}}
                            <th>Order Date</th>
                            <th>Payment Type</th>
                            <th>Order Total</th>
                            <th>Order Status</th>
                            <th>Total Product</th>
                            <th>Total QTY</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $key=>$order)
                        @php $qty=0;@endphp
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$order->order_no}}</td>
                            <td>{{$order->wearhouse->store_name ?? ''}}</td>
                            {{-- <td>{{$order->shopkeeper->name ?? '-'}}</td> --}}
                            <td>{{$order->dFormat((int)$order->created)}}</td>
                            <td>{{$order->payment_type}}</td>
                            <td>{{$order->order_total}}</td>
                            <td><span class="badge badge-info">{{ucfirst($order->order_status)}}</span></td>
                            <td>{{count(array_unique($order->products, SORT_REGULAR))}}</td>
                            <td>@foreach($order->products as $key => $val) @php $qty+=$val['total_qty'] @endphp @endforeach
                                {{$qty}}
                            </td>
                            <td>
                                <a href="javascript:void(0);" class="btn btn-sm btn-primary order-view" _id="{{$order->_id}}"><i class="mdi mdi-information"></i></a>


                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                       <tr>
                           <td colspan="9">
                               {{ $orders->links()}}
                           </td>
                       </tr>
                    </tfoot>
                </table>
            </div>
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

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>
    $(document).on('click', '.order-view', function() {
        let id = $(this).attr('_id');
        var url = "{{ url('admin/order-detail') }}/"+id;
        axios.get(url).then((response) => {
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
        <div class="card">
            <div class="card-header" id="OrderHeadingTwo">
            <h3 class="mb-0 btn" id="AddressToggle">
                View Address
                </button>
            </h3>
        </div>
        <div id="OrderAddress" class="d-none">
        <div class="card-body">
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
                </div>
            </div>
            </div>
        </div>
                `;

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
                                        <th>QTY</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                    </tr>`;
            $.each(products, (index, val) => {
                console.log(val)
                html += `<tr><td>${++index}</td>
                      <td><img src="${val.image_url === undefined ?? val.image}" class="img"></td>
                      <td>${val.title?? '-'}<
                      <td>${val.sku?? '-'}</td>
                      <td>${val.price?? '-'}</td>
                      <td>${val.unit??'-'}</td>
                      <td>${val.brand ?? '-'}</td>
                      <td>${val.total_qty ?? '-'}</td>
                      <td>${val.category_name ?? '-'}</td>
                      <td>${val.sub_category_name ?? '-'}</td>
                      </tr>`;
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

    $(document).ready(function() {
        $('#orderModal').on('click', '#AddressToggle', function() {
            $('#OrderAddress').toggleClass('d-none');
        });

        $('body').on('change','#state,#city',function() {
            var city = $(this).val();
            var state = $('#state').val();

            if(city != '' && state != '') {
            $.ajax({
                url: `{{ url('admin/order/get_warehouse') }}`,
                type: 'POST',
                data: {_token:"{{ @csrf_token() }}",state:state,city:city},
                beforeSend: () => {
                    $('#warehourse_list').html(`<option value=''>Loading....</option>`)
                },
                success: function(res) {
                    $('#warehourse_list').trigger('change').html('');
                    $('#warehourse_list').html(`<option value=''>Select Warehouse</option>`)
                    $.each(res, function(value, index) {
                        $('#warehourse_list').append(
                            `<option value=${index}>${value}</option>`)
                    })
                },
            });
            } else {
                alert('Please Select State & City.')
            }
        })
    });
</script>



@endsection
