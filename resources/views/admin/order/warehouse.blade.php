 <div class="card">
     <div class="card-header">
         <h6 class="text-primary">Warehouses</h6>
     </div>
     <div class="card-body p-0">
         <div class="table-responsive">
             <table class="table datatable">
                 <thead>
                     <tr>
                         <th>#</th>
                         <th>Store Name</th>
                         <th>Store Email</th>
                         <th>Store Address</th>
                         <th>Verified</th>
                         <th>Status</th>
                         <th>Created</th>
                         <th>Action</th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach($warehouses as $key => $value)
                     <tr>
                         <td>{{ ++$key }}</td>
                         <td>{{$value->store_name}}</td>
                         <td>{{$value->store_email}}</td>
                         <td>{{$value->store_address}}</td>
                         <td>{!! $value->verified == 1? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-warning">No</span>' !!}</td>
                         <td>{!!$value->status == 1 ? '<span class="badge badge-success">Avtive</span>' : '<span class="badge badge-warning">In Active</span>'!!}</td>
                         <td>{{ $value->dformat($value->created)}}</td>
                         <td><a href="{{ url('admin/orders_list/'.$value->_id.'/view') }}" class="btn btn-sm btn-primary warehouse-view" _id="{{$value->_id}}"><i class="mdi mdi-information"></i></a></td>
                     </tr>
                     @endforeach
                 </tbody>

                 <tfoot>
                    <tr>
                        <td colspan="9">
                            {{ $warehouses->links()}}
                        </td>
                    </tr>
                 </tfoot>
             </table>
         </div>
     </div>
 </div>

 @push('order')

 <div class="modal fade" id="warehouseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" style="max-width: 40%;" role="document">

         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="modalHeading">Warehouse Details</h5>

                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>

             <div class="modal-body" id="warehouse-html">

             </div>
         </div>
     </div>
 </div>
 </div>

 <script>
    //  $(document).on('click', '.warehouse-view', function() {
    //      let id = $(this).attr('_id');

    //      axios.get('warehouse-detail/' + id).then((response) => {

    //          let res = response.data.data;
    //          let verified = res.verified == 1 ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-warning">No</span>';
    //          let status   = res.status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Inactive</span>'
    //          let html = `<div class="row">
    //                  <div class="col-md-12">
    //                      <div class="table-responsive">
    //                      <table class="table">
    //                          <thead>
    //                              <tr>
    //                              <th>Store Name</th><td>${res.store_name??''}</td></tr>
    //                              <tr><th>Store Email</th><td>${res.store_email??''}</td></tr>
    //                              <tr><th>Gst No</th><td>${res.gst_no??''}</td></tr>
    //                              <tr><th>Store Mobile</th><td>${res.store_mobile??''}</td></tr>
    //                              <tr><th>Country</th><td>${res.country??''}</td></tr>
    //                              <tr><th>City</th><td>${res.city??''}</td></tr>
    //                              <tr><th>State</th><td>${res.state??''}</td></tr>
    //                              <tr><th>Pincode</th><td>${res.pincode??''}</td></tr>
    //                              <tr><th>Store Address</th><td>${res.store_address??''}</td></tr>
    //                              <tr><th>Verified</th><td>${verified}</td></tr>
    //                              <tr><th>Status</th><td>${status}</td></tr>
    //                              <tr><th>Country</th><td>${res.created}</td></tr>
    //                          </thead>
    //                      </table>
    //                      </div>
    //                  </div>
    //              </div>`;

    //          $('#warehouse-html').html(html);

    //          $('#warehouseModal').modal('show');
    //      }).catch((error) => {

    //      });
    //  });
 </script>
 @endpush
