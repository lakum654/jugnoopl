 <div class="card">
     <div class="card-header">
         <h6>Purchase Order</h6>
     </div>
     <div class="card-body p-0">
         <div class="row">
             <div class="col-md-12">
                 <nav>
                     <div class="nav nav-tabs" id="nav-tab" role="tablist">
                         <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Requested</a>
                         <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Inprogress</a>
                         <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Received</a>
                     </div>
                 </nav>
                 <div class="tab-content" id="nav-tabContent">
                     <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                         <div class="table-responsive">
                             <table class="table table-striped">
                                 <thead>
                                     <tr>
                                         <th>#</th>
                                         <th>PO No</th>
                                         <th>Supplier Name</th>
                                         <th>Warehouse Name</th>
                                         <th>Estimated Del. Date</th>
                                         <th>Po Status</th>
                                         <th>Item Status</th>
                                         <th>Requested Date</th>
                                         <th>Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach($pos as $key => $list)
                                     @if($list->type=='requested')
                                     <tr>
                                         <td>{{ ++$key }}</td>
                                         <td>{{ $list->po_no }}</td>
                                         <td>{{ !empty($list->Supplier->store_name)? $list->Supplier->store_name:'' }}</td>
                                         <td>{{ !empty($list->Warehouse->store_name)?$list->Warehouse->store_name:'' }}</td>
                                         <td>{{ $list->dformat((int)$list->estimated_del_date)}}</td>
                                         <td>{!! $list->po_status == 'completed'? '<span class="badge badge-success">Completed</span>' : '<span class="badge badge-warning">Pending</span>' !!}</td>
                                         <td>{!! $list->item_status == 'completed'? '<span class="badge badge-success">Completed</span>' : '<span class="badge badge-warning">Pending</span>' !!}</td>
                                         <td>{{ $list->dformat($list->created)}}</td>
                                         <td><a href="javascript:void(0);" class="btn btn-sm btn-primary po-view" _id="{{$list->_id}}"><i class="mdi mdi-information"></i></a></td>
                                     </tr>
                                     @endif
                                     @endforeach
                                 </tbody>
                             </table>
                         </div>
                     </div>
                     <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                         <div class="table-responsive">
                             <table class="table table-striped">
                                 <thead>
                                     <tr>
                                         <th>#</th>
                                         <th>PO No</th>
                                         <th>Supplier Name</th>
                                         <th>Warehouse Name</th>
                                         <th>Estimated Del. Date</th>
                                         <th>Po Status</th>
                                         <th>Item Status</th>
                                         <th>Requested Date</th>
                                         <th>Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach($pos as $key => $list)
                                     @if($list->type=='in-progress')
                                     <tr>
                                         <td>{{ ++$key }}</td>
                                         <td>{{ $list->po_no }}</td>
                                         <td>{{ !empty($list->Supplier->store_name)? $list->Supplier->store_name:'' }}</td>
                                         <td>{{ !empty($list->Warehouse->store_name)?$list->Warehouse->store_name:'' }}</td>
                                         <td>{{ $list->dformat((int)$list->estimated_del_date)}}</td>
                                         <td>{!! $list->po_status == 'completed'? '<span class="badge badge-success">Completed</span>' : '<span class="badge badge-warning">Pending</span>' !!}</td>
                                         <td>{!! $list->item_status == 'completed'? '<span class="badge badge-success">Completed</span>' : '<span class="badge badge-warning">Pending</span>' !!}</td>
                                         <td>{{ $list->dformat($list->created)}}</td>
                                         <td><a href="javascript:void(0);" class="btn btn-sm btn-primary po-view" _id="{{$list->_id}}"><i class="mdi mdi-information"></i></a></td>
                                     </tr>
                                     @endif
                                     @endforeach
                                 </tbody>
                             </table>
                         </div>
                     </div>
                     <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                         <div class="table-responsive">
                             <table class="table table-striped">
                                 <thead>
                                     <tr>
                                         <th>#</th>
                                         <th>PO No</th>
                                         <th>Supplier Name</th>
                                         <th>Warehouse Name</th>
                                         <th>Estimated Del. Date</th>
                                         <th>Po Status</th>
                                         <th>Item Status</th>
                                         <th>Requested Date</th>
                                         <th>Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach($pos as $key => $list)
                                     @if($list->type=='received')
                                     <tr>
                                         <td>{{ ++$key }}</td>
                                         <td>{{ $list->po_no }}</td>
                                         <td>{{ !empty($list->Supplier->store_name)? $list->Supplier->store_name:'' }}</td>
                                         <td>{{ !empty($list->Warehouse->store_name)?$list->Warehouse->store_name:'' }}</td>
                                         <td>{{ $list->dformat((int)$list->estimated_del_date)}}</td>
                                         <td>{!! $list->po_status == 'completed'? '<span class="badge badge-success">Completed</span>' : '<span class="badge badge-warning">Pending</span>' !!}</td>
                                         <td>{!! $list->item_status == 'completed'? '<span class="badge badge-success">Completed</span>' : '<span class="badge badge-warning">Pending</span>' !!}</td>
                                         <td>{{ $list->dformat($list->created)}}</td>
                                         <td><a href="javascript:void(0);" class="btn btn-sm btn-primary po-view" _id="{{$list->_id}}"><i class="mdi mdi-information"></i></a></td>
                                     </tr>
                                     @endif
                                     @endforeach
                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

 @push('order')

 <div class="modal fade" id="poModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" style="max-width: 70%;" role="document">

         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="modalHeading">PO Details</h5>

                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>

             <div class="modal-body" id="po-html">

             </div>
         </div>
     </div>
 </div>
 </div>

 <script>
     $(document).on('click', '.po-view', function() {
         let id = $(this).attr('_id');

         axios.get('po-detail/' + id).then((response) => {

             let res = response.data.data;
             console.log(res);
             let poStatus = res.po_status == 'completed' ? '<span class="badge badge-success">Completed</span>' : '<span class="badge badge-warning">Pending</span>';
             let itemStatus = res.item_status == 'completed' ? '<span class="badge badge-success">Completed</span>' : '<span class="badge badge-warning">Pending</span>'

             let html = `<div class="row">
                         <div class="col-md-12">

                         <div class="table-responsive card">
                         <table class="table">
                             <tbody>
                                 <tr>
                                 <th>Po Number</th><td>${res.po_no}</td>
                                 <th>Store Name</th><td>${res.supplier.store_name}</td>
                                 <th>Warehouse Name</th><td>Test</td>
                                 <th>Type</th><td>${res.type}</td></tr>

                                <tr><th>Estimated Del Date</th><td>${res.estimated_del_date}</td>
                                 <th>Po Status</th><td>${poStatus}</td>
                                 <th>Item Status</th><td>${itemStatus}</td>
                                 </tr>
                             </tbody>
                         </table>
                         </div>

                        <hr>
                        <h6 class="text-primary">Products</h6>
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


                                </tr>`;

             let items = res.items;
             $.each(items, (index, val) => {
                 let image = imgPath('product', val.image);
                 html += `<tr><td>${++index}</td>
                          <td><img src="${image}" class="img"></td>
                          <td>${val.title}</td>
                          <td>${val.sku}</td>
                          <td>${val.price}</td>
                          <td>${val.unit}</td>
                        </tr>`;
             });

             html += `</tbody>
                         </table>
                         </div>
                     </div>
                 </div>`;

             $('#po-html').html(html);

             $('#poModal').modal('show');
         }).catch((error) => {

         });
     });
 </script>
 @endpush