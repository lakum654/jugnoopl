@extends('admin.layouts.layouts')
@section('content')
<div class="content-wrapper pb-0">
    <div class="card shadow mb-4">

        <x-page-head title="Edit warehouse " url="admin/warehouse" type="create" />

        <div class="cover-loader d-none">
            <div class="loader"></div>
        </div>
  @if(session('msg'))
                  <div class="alert alert-success">{{session('msg')}}</div>
              @endif
        <div class="card-body h-body">
            <div class="row">
                <div class="col-lg-12">
                    <form id="warehouse" method="POST" action="{{url('admin/warehouse/'.$res->_id)}}" enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Select Users&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm js-example-basic-multiple" multiple="multiple" name="users[]" id="user">
                                    @foreach($users as $list)
                                    <option value="{{ $list->_id }}" {{(!empty($res->users) && in_array($list->_id,$res->users))?"selected":''}}>{{ ucwords($list->name)}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Select Suppliers&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm js-example-basic-multiple" multiple="multiple" name="suppliers[]" id="suppliers">
                                    @foreach($suppliers as $list)
                                    <option value="{{ $list->_id }}" {{(!empty($res->suppliers) && in_array($list->_id,$res->suppliers))?"selected":''}}>{{ ucwords($list->store_name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12">
                                <h6><span class="mdi mdi-store "></span>&nbsp;Store Details</h6>
                                <hr>
                            </div>
                        </div>


                        <div class="form-row">

                            <div class="form-group col-md-3">
                                <label>Store Name&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="store_name" value="{{$res->store_name}}" placeholder="Enter Store name">
                                <span id="store_name_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Store Email&nbsp;<span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-sm" name="store_email" value="{{$res->store_email}}" placeholder="Enter Store email">
                                <span id="store_email_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Mobile&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="store_mobile" value="{{$res->store_mobile}}" placeholder="Enter Store Mobile">
                                <span id="store_mobile_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label>GST No</label>
                                <input type="text" class="form-control form-control-sm" name="gst_no" value="{{$res->gst_no}}" placeholder="Enter GST No.">
                                <span id="gst_no_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Country&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="country" value="{{$res->country}}" placeholder="Enter Country.">
                                <span id="country_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">State&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm" name="state">
                                    <option value="">Select Here</option>
                                    @foreach(config('global.state') as $state)
                                    <option value="{{$state}}" {{(!empty($res->state) && $res->state==$state)?'selected':''}}>{{$state}}</option>
                                    @endforeach
                                </select>
                                <span id="state_msg" class="c-text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label>City&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" name="city" value="{{$res->city}}" class="form-control form-control-sm" placeholder="Enter City">
                                <span id="city_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Pincode&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="pincode" value="{{$res->pincode}}" placeholder="Enter Pincode">
                                <span id="pincode_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Store Address</label>
                                <textarea class="form-control form-control-sm" name="store_address" rows="4" cols="50" placeholder="Store Address">{{$res->store_address}}</textarea>
                                <span id="store_address_msg" class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Verified Store&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm" name="verified">
                                    <option value="1" {{ ($res->verified ==1)?'selected':''}}>Verified</option>
                                    <option value="0" {{ (isset($res->verified) && $res->verified ==0)?'selected':''}}>Non Verified</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Status&nbsp;<span class="text-danger">*</span></label>
                                <select class="form-select form-control form-control-sm" name="status">
                                    <option value="1" {{ ($res->status ==1)?'selected':''}}>Active</option>
                                    <option value="0" {{ (isset($res->status) && $res->status ==0)?'selected':''}}>Inactive</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label>Logo</label>
                                <input type="file" name="logo" class="form-control form-control-sm" accept="image/*,.pdf">

                            </div>
                            <div class="form-group">
                                <label>Store Cover Photo</label>
                                <input type="file" name="store_cover_photo" class="form-control form-control-sm" accept="image/*,.pdf">
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