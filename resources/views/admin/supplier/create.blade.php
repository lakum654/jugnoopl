@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">
    <div class="card shadow mb-4">

        <div class="cover-loader d-none">
            <div class="loader"></div>
        </div>

        <x-page-head title="Add Supplier " url="admin/supplier" type="create" />

        <div class="card-body h-body">
            <div class="row">
                <div class="col-lg-12">
                    <form id="supplier" method="POST" action="{{url('admin/supplier')}}" enctype="multipart/form-data">
                        @csrf

                        <!-- <div class="form-row">
                            <div class="col-md-12">
                                <h6><span class="mdi mdi-account-check"></span>&nbsp;Persional Details</h6>
                                <hr>
                            </div>
                        </div> -->

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Select Users&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm js-example-basic-multiple" multiple="multiple" name="users[]" id="user">
                                    <option>-Select Here-</option>
                                    @foreach($users as $show)
                                    <option value="{{ $show->_id }}" @selected(old('users')==$show->_id)>{{ ucwords($show->name)}}</option>
                                    @endforeach
                                </select>
                                <span id="users_msg" class="c-text-danger"></span>
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
                                <input type="text" class="form-control form-control-sm" name="store_name" placeholder="Store name" value="{{old('store_name')}}">
                                <span id="store_name_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Store Email&nbsp;<span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-sm" name="store_email" placeholder="Store email" value="{{old('store_email')}}">
                                <span id="store_email_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">GST No</label>
                                <input type="text" class="form-control form-control-sm" name="gst_no" placeholder="GST no." value="{{old('gst_no')}}">
                                <span id="gst_no_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Mobile&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="store_mobile" placeholder="Mobile" value="{{old('store_mobile')}}">
                                <span id="store_mobile_msg" class="c-text-danger"></span>
                            </div>


                            <div class="form-group col-md-3">
                                <label for="">Select Country&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm" name="country" id="country">
                                    <option value="">Select Country</option>
                                    @foreach ($country as $key => $val)
                                            <option value="{{ ucfirst(strtolower($val)) }}">{{ ucfirst(strtolower($val)) }}</option>
                                    @endforeach
                                </select>
                                <span id="country_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label>State&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm" name="state">
                                    <option value="">-Select Here-</option>
                                    @foreach(config('global.state') as $state)
                                    <option value="{{$state}}">{{$state}}</option>
                                    @endforeach
                                </select>
                                <span id="state_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">City&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm" name="city">
                                    <option>Select City</option>
                                    @foreach ($city as $key => $val)
                                            <option value="{{ ucfirst(strtolower($val->city)) }}">{{ ucfirst(strtolower($val->city)) }}</option>
                                    @endforeach
                                </select>
                                <span id="city_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Pincode&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="pincode" placeholder="pincode" value="{{old('pincode')}}">
                                <span id="pincode_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Store Address</label>
                                <textarea class="form-control form-control-sm" name="store_address" rows="4" cols="50" placeholder="Store Address">{{old('store_address')}}</textarea>
                                <span id="store_address_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Verified Store&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm" name="verified_store">
                                    <option value="1" {{ old('verified_store') ==1?'selected':''}}>Verified</option>
                                    <option value="0">Non Verified</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Status&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm" name="status">
                                    <option value="1" {{ old('status') ==1?'selected':''}}>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Logo</label>
                                <input type="file" name="flies[logo]" class="form-control form-control-sm" accept="image/*,.pdf">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Store Cover Photo</label>
                                <input type="file" name="file[store_cover_photo]" class="form-control form-control-sm" accept="image/*,.pdf">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">GST Certificate</label>
                                <input type="file" name="file[gst_certificate]" class="form-control form-control-sm" accept="image/*,.pdf">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Udyam Aadhar (MSME Certificate)</label>
                                <input type="file" name="file[u_a_msme_certificate]" class="form-control form-control-sm" accept="image/*,.pdf">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Shop & Establishment License</label>
                                <input type="file" name="file[shop_licence]" class="form-control form-control-sm" accept="image/*,.pdf">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Trade Certificate/Licence</label>
                                <input type="file" name="file[trade_licence]" class="form-control form-control-sm" accept="image/*,.pdf">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">FSSAI Registration</label>
                                <input type="file" name="file[fssai_registration]" class="form-control form-control-sm" accept="image/*,.pdf">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Drug Licence</label>
                                <input type="file" name="file[drug_licence]" class="form-control form-control-sm" accept="image/*,.pdf">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">Current Account Cheque</label>
                                <input type="file" name="file[current_account_cheque]" class="form-control form-control-sm" accept="image/*,.pdf">
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
    $('form#supplier').submit(function(e) {
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
                    $('form#supplier')[0].reset();
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
