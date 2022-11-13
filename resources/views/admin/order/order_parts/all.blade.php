<div class="card">
     <div class="card-header">
         <h6 class="text-primary">Orders</h6>
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
                         {{-- <th>Total QTY</th> --}}
                         <th>Action</th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach($orders as $key=>$order)
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
                         {{-- <td>0</td> --}}
                         <td>
                             @if($order->order_status == 'pending')
                             <a href="javascript:void(0);" class="btn btn-md btn-success change_status_one" data-id="{{$order->_id}}">Accept</a>
                             <a href="javascript:void(0);" class="btn btn-md btn-danger change_status_two" data-id="{{$order->_id}}">Reject</a>
                             @endif
                             @if($order->order_status == 'accepted' || $order->order_status == 'processing' || $order->order_status == 'complete')
                             <!-- <a href="javascript:void(0);" class="btn btn-sm btn-primary order_info" data-id="{{$order->_id}}"><i class="mdi mdi-truck"></i></a> -->
                             @endif
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
