@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">
    <div class="card shadow mb-4">

        <div class="cover-loader d-none">
            <div class="loader"></div>
        </div>

        <x-page-head title="Add Shopkeeper " url="admin/shopkeeper" type="create" />
      
      		  @if(session('msg'))
                  <div class="alert alert-success">{{session('msg')}}</div>
              @endif

        <div class="card-body h-body">
            <div class="row">

                <div class="col-lg-12">
                    <form id="shopkeeper" method="POST" action="{{url('admin/shopkeeper')}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Select User&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm js-example-basic-multiple" multiple="multiple" name="users[]" id="user">
                                    <option>-Select Here-</option>
                                    @foreach($users as $show)
                                    <option value="{{ $show->_id }}">{{ ucwords($show->name)}}</option>
                                    @endforeach
                                </select>
                                <span id="users_msg" class="c-text-danger"></span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12">
                                <h6><span class="mdi mdi-store "></span>&nbsp;Store Details</h6>
                            </div>
                        </div>


                        <div class="form-group row">

                            <div class="form-group col-md-3">
                                <label>Store Name &nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="store_name" placeholder="Enter Store name">
                                <span id="store_name_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Store Email&nbsp;<span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-sm" name="store_email" placeholder="Enter Store email">
                                <span id="store_email_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Mobile&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="store_mobile" placeholder="Enter Store Mobile">
                                <span id="store_mobile_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label>GST No</label>
                                <input type="text" class="form-control form-control-sm" name="gst_no" placeholder="Enter GST No.">
                                <span id="gst_no_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Country&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="country" placeholder="Enter Country.">
                                <span id="country_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label>State&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm" name="state">
                                    <option value="">Select</option>
                                    @foreach(config('global.state') as $state)
                                    <option value="{{$state}}">{{$state}}</option>
                                    @endforeach
                                </select>
                                <span id="state_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label>City&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control form-control-sm" placeholder="Enter City">
                                <span id="city_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Pincode&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="pincode" placeholder="Enter Pincode">
                                <span id="pincode_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Store Address</label>
                                <textarea class="form-control form-control-sm" name="store_address" rows="4" cols="50" placeholder="Store Address"></textarea>
                                <span id="store_address_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Verified Store&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm" name="verified">
                                    <option value="1">Verified</option>
                                    <option value="0">Non Verified</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Status&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label>Logo</label>
                                <input type="file" name="files[logo]" class="form-control form-control-sm" accept="image/*,.pdf">

                            </div>
                            <div class="form-group">
                                <label>Store Cover Photo</label>
                                <input type="file" name="files[cover_photo]" class="form-control form-control-sm" accept="image/*,.pdf">

                            </div>
                            <div class="form-group">
                                <label>GST Certificate</label>
                                <input type="file" name="files[gst_certificate]" class="form-control form-control-sm" accept="image/*,.pdf">
                            </div>
                            <div class="form-group">
                                <label>Udyam Aadhar (MSME Certificate)</label>
                                <input type="file" name="files[msme_certificate]" class="form-control form-control-sm" accept="image/*,.pdf">
                            </div>
                            <div class="form-group">
                                <label>Shop & Establishment License</label>
                                <input type="file" name="files[shop_licence]" class="form-control form-control-sm" accept="image/*,.pdf">
                            </div>
                            <div class="form-group">
                                <label>Trade Certificate/Licence</label>
                                <input type="file" name="files[trade_licence]" class="form-control form-control-sm" accept="image/*,.pdf">
                            </div>
                            <div class="form-group">
                                <label>FSSAI Registration</label>
                                <input type="file" name="files[fssai_registration]" class="form-control form-control-sm" accept="image/*,.pdf">
                            </div>
                            <div class="form-group">
                                <label>Drug Licence</label>
                                <input type="file" name="files[drug_licence]" class="form-control form-control-sm" accept="image/*,.pdf">
                            </div>
                            <div class="form-group">
                                <label>Current Account Cheque</label>
                                <input type="file" name="files[current_account_cheque]" class="form-control form-control-sm" accept="image/*,.pdf">
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
    $('form#shopkeeper').submit(function(e) {
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
                    $('form#shopkeeper')[0].reset();
                    setTimeout(() => {
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