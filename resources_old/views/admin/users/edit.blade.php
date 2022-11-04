@extends('admin.layouts.layouts')
@section('content')
<div class="content-wrapper pb-0">
    <div class="card shadow mb-4">

        <x-page-head title="Edit User " url="admin/user" type="create" />

        <div class="cover-loader d-none">
            <div class="loader"></div>
        </div>
      
       @if(session('msg'))
                  <div class="alert alert-success">{{session('msg')}}</div>
              @endif
    

        <div class="card-body h-body">
            <div class="row">
                <div class="col-lg-12">
                    <form id="user" method="POST" action="{{url('admin/user/'.$res->_id)}}" enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        @csrf


                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Profile Image</label>
                                <input type="file" class="form-control form-control-sm" name="profile_img">
                                <span id="profile_img_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Name&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="name" value="{{old('name')??$res->name}}" placeholder="Enter Name">
                                <span id="name_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Email&nbsp;<span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-sm" name="email" value="{{old('email')??$res->email}}" placeholder="Enter Email">
                                <span id="email_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Mobile No&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="mobile" value="{{old('mobile')??$res->mobile}}" placeholder="Enter Mobile No">
                                <span id="mobile_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Role</label>
                                <select class="form-control form-control-sm" name="role" id="role">
                                    <option value="">Select</option>
                                    <option value="admin" @selected(old('role')=='admin' || $res->role =='admin')>Admin</option>
                                    <option value="supplier" @selected(old('role')=='supplier' || $res->role =='supplier')>Supplier</option>
                                    <option value="shopkeeper" @selected(old('role')=='shopkeeper' || $res->role =='shopkeeper')>Shopkeeper</option>
                                    <option value="warehouse" @selected(old('role')=='warehouse' || $res->role =='warehouse')>Warehouse</option>
                                </select>
                                <span id="role_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Country&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="country" value="{{old('country')??$res->country}}" placeholder="Enter Country.">
                                <span id="country_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>State&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm" name="state">
                                    <option value="">-Select Here-</option>
                                    @foreach(config('global.state') as $state)
                                    <option value="{{$state}}" @selected(old('state')==$state || $res->state ==$state)>{{$state}}</option>
                                    @endforeach
                                </select>
                                <span id="state_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>City&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" name="city" value="{{old('city')??$res->city}}" class="form-control form-control-sm" placeholder="Enter City">
                                <span id="city_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Pincode&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="pincode" value="{{old('pincode')??$res->pincode}}" placeholder="Enter Pincode">
                                <span id="pincode_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Address</label>
                                <textarea class="form-control form-control-sm" name="address" rows="2" placeholder="Address"><?= old('address')??$res->address ?></textarea>
                                <span id="address_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Status&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm" name="status">
                                    <option value="1" @selected(old('status')=='admin' || $res->status ==1)>Active</option>
                                    <option value="0" @selected(old('status')=='admin' || $res->status ==0)>Deactive</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <input type="submit" value="Update" class="btn btn-success">
                                <button type="reset" class="btn btn-warning"><span class="mdi mdi-rotate-left"></span>&nbsp;Reset</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@push('script')
<script>
    $('form#user').submit(function(e) {
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
                $('span.custom-text-danger').html('');
                $.each(res.validation, (index, msg) => {
                    $(`#${index}_msg`).html(`${msg}`);
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
                    $('form#user')[0].reset();
                    setTimeout(() => {
                        // location.reload();
                      location.reload(): 
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
    })
</script>
@endpush

@endsection