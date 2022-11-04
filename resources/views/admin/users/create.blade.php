@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">
    <div class="card shadow mb-4">

        <div class="cover-loader d-none">
            <div class="loader"></div>
        </div>

        <x-page-head title="Add User " url="admin/user" type="create" />

        <div class="card-body h-body">
            <div class="row">

                <div class="col-lg-12">
                    <form id="user" method="POST" action="{{url('admin/user')}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label>Profile Image</label>
                                <input type="file" class="form-control form-control-sm" name="profile_img">
                                <span id="profile_img_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Name&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="name" placeholder="Enter Name">
                                <span id="name_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Email&nbsp;<span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-sm" name="email" placeholder="Enter Email">
                                <span id="email_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Password&nbsp;<span class="text-danger">*</span></label>
                                <input type="password" class="form-control form-control-sm" name="password" placeholder="Enter Password">
                                <span id="password_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Mobile No&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="mobile" placeholder="Enter Mobile No">
                                <span id="mobile_msg" class="c-text-danger"></span>
                            </div>


                            <div class="form-group col-md-4">
                                <label>Role&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" name="role" id="role">
                                    <option value="">Select</option>
                                    <option value="admin">Admin</option>
                                    <option value="supplier">Supplier</option>
                                    <option value="shopkeeper">Shopkeeper</option>
                                    <option value="warehouse">Warehouse</option>
                                </select>
                                <span id="role_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Country&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="country" value="" placeholder="Enter Country.">
                                <span id="country_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>State&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm" name="state">
                                    <option value="">-Select Here-</option>
                                    @foreach(config('global.state') as $state)
                                    <option value="{{$state}}">{{$state}}</option>
                                    @endforeach
                                </select>
                                <span id="state_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>City&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control form-control-sm" placeholder="Enter City">
                                <span id="city_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Pincode&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="pincode" placeholder="Enter Pincode">
                                <span id="pincode_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Address</label>
                                <textarea class="form-control form-control-sm" name="address" rows="2" placeholder="Enter Address"></textarea>
                                <span id="address_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Status&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <input type="submit" value="Submit" class="btn btn-success">
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
                $('span.c-text-danger').html('');
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