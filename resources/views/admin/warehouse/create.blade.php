@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">
    <div class="card shadow mb-4">

        <x-page-head title="Add Warehouse " url="admin/warehouse" type="create" />

        <div class="cover-loader d-none">
            <div class="loader"></div>
        </div>

        <div class="card-body h-body">
            <div class="row">
                <div class="col-lg-12">
                    <form id="warehouse" method="POST" action="{{url('admin/warehouse')}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Select Users&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm multiple-select1" multiple="multiple" name="users[]" id="user">
                                    @foreach($users as $show)
                                    <option value="{{ $show->_id }}">{{ ucwords($show->name)}}</option>
                                    @endforeach
                                </select>
                                <span id="users_msg" class="c-text-danger"></span>
                            </div>


                            <div class="form-group col-md-4">
                                <label>Select Suppliers&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm multiple-select2" multiple="multiple" name="suppliers[]" id="supplier">
                                    @foreach($suppliers as $list)
                                    <option value="{{ $list->_id }}">{{ ucwords($list->store_name)}}</option>
                                    @endforeach
                                </select>
                                <span id="suppliers_msg" class="c-text-danger"></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <h6><span class="mdi mdi-store "></span>&nbsp;Store Details</h6>
                                <hr>
                            </div>
                        </div>


                        <div class="form-group row">

                            <div class="form-group col-md-3">
                                <label for="">Store Name&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="store_name" placeholder="Store name">
                                <span id="store_name_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Store Email&nbsp;<span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-sm" name="store_email" placeholder="Store email">
                                <span id="store_email_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">GST No</label>
                                <input type="text" class="form-control form-control-sm" name="gst_no" placeholder="GST no.">
                                <span id="gst_no_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Mobile&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="store_mobile" placeholder="Mobile">
                                <span id="store_mobile_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Country&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="country" value="" placeholder="Enter Country.">
                                <span id="country_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">State&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm" name="state">
                                    <option value="">-Select Here-</option>
                                    @foreach(config('global.state') as $state)
                                    <option value="{{$state}}">{{$state}}</option>
                                    @endforeach
                                </select>
                                <span id="state_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">City&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-select form-control form-control-sm" name="city">
                                <span id="city_msg" class="c-text-danger"></span>

                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Pincode&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="pincode" placeholder="pincode">
                                <span id="pincode_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Store Address</label>
                                <textarea class="form-control form-control-sm" name="store_address" rows="4" cols="50" placeholder="Store Address"></textarea>
                                <span id="store_address_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Verified Store&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm" name="verified_store">
                                    <option value="1">Verified</option>
                                    <option value="0">Not Verified</option>
                                </select>
                                <span id="verified_store_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Status&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <span id="status_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Logo</label>
                                <input type="file" name="flies[logo]" class="form-control form-control-sm" accept="image/*,.pdf">
                                <span id="files_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Store Cover Photo</label>
                                <input type="file" name="files[store_cover_photo]" class="form-control form-control-sm" accept="image/*,.pdf">
                                <span id="files_msg" class="c-text-danger"></span>
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
    $('form#warehouse').submit(function(e) {
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
                    $('form#warehouse')[0].reset();
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