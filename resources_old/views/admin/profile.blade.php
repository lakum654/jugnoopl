@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-warning card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if(!empty($user->profile_img))
                                <img class="profile-user-img img-fluid img-circle" src="{{asset('users/'.$user->profile_img)}}" alt="User profile picture">
                                @else
                                <img class="profile-user-img img-fluid img-circle" src="{{asset('assets')}}/images/faces/face1.jpg" alt="User profile picture">
                                @endif
                            </div>
                            <h3 class="profile-username text-center">{{ucwords(Auth::user()->name)}}</h3>
                            <p class="text-muted text-center">{{ucwords(Auth::user()->role)}}</p>
                            <!-- <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Followers</b> <a class="float-right">1,322</a>
                            </li>
                            <li class="list-group-item">
                                <b>Following</b> <a class="float-right">543</a>
                            </li>
                            <li class="list-group-item">
                                <b>Friends</b> <a class="float-right">13,287</a>
                            </li>
                        </ul>
                        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
                        </div>

                    </div>


                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">About Me</h3>
                        </div>

                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Address</strong>
                            <p class="text-muted">
                                {{ Auth::user()->address }}
                            </p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                            <p class="text-muted">{{ Auth::user()->city }}</p>
                        </div>

                    </div>

                </div>

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-1">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                                <li class="nav-item"><a class="nav-link" href="#passwordreset" data-toggle="tab">Password Reset</a></li>
                            </ul>
                        </div>
                        <div class="card-body">

                            <div class="cover-loader d-none">
                                <div class="loader"></div>
                            </div>

                            <div class="tab-content h-body">
                                <div class="tab-pane active" id="settings">
                                    <form class="form-horizontal" id="user" method="POST" action="{{url('admin/profile/'.$user->_id)}}" enctype="multipart/form-data">
                                        {{ method_field('PUT') }}
                                        @csrf
                                        <div class="mb-1 row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control form-control-sm" name="name" value="{{$user->name}}" placeholder="Enter Name">
                                                <span id="name_msg" class="c-text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="mb-1 row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control form-control-sm" name="email" value="{{$user->email}}" placeholder="Enter Email">
                                                <span id="email_msg" class="c-text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="mb-1 row">
                                            <label for="inputName2" class="col-sm-2 col-form-label">Mobile No</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control form-control-sm" name="mobile" value="{{$user->mobile}}" placeholder="Enter Mobile No">
                                                <span id="mobile_msg" class="c-text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="mb-1 row">
                                            <label for="inputSkills" class="col-sm-2 col-form-label">State</label>
                                            <div class="col-sm-10">
                                                <select class="form-select form-control form-control-sm" name="state">
                                                    <option value="">-Select Here-</option>
                                                    @foreach(config('global.state') as $state)
                                                    <option value="{{$state}}">{{$state}}</option>
                                                    @endforeach
                                                </select>
                                                <span id="state_msg" class="c-text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="mb-1 row">
                                            <label for="inputExperience" class="col-sm-2 col-form-label">City</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="city" value="{{$user->city}}" class="form-control form-control-sm" placeholder="Enter City">
                                                <span id="city_msg" class="c-text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="mb-1 row">
                                            <label for="inputExperience" class="col-sm-2 col-form-label">Pincode</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control form-control-sm" name="pincode" value="{{$user->pincode}}" placeholder="Enter Pincode">
                                                <span id="pincode_msg" class="c-text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="mb-1 row">
                                            <label for="inputExperience" class="col-sm-2 col-form-label">Address</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control form-control-sm" name="address" rows="2" placeholder="Address"><?= $user->address ?></textarea>
                                                <span id="address_msg" class="c-text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="mb-1 row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-success">Update</button>
                                                <button type="reset" class="btn btn-warning"><span class="mdi mdi-rotate-left"></span>&nbsp;Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="passwordreset">
                                    <form class="form-horizontal" id="user" method="POST" action="{{url('admin/profile')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-1 row">
                                            <label for="inputPassword1" class="col-sm-3 col-form-label">Old Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" name="old_password" id="old_password" class="form-control form-control-sm" placeholder="Enter Old Password" value="">
                                                <span class="c-text-danger" id="old_password_msg"></span>
                                            </div>
                                        </div>
                                        <div class="mb-1 row">
                                            <label for="inputPassword2" class="col-sm-3 col-form-label">New Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" name="password" id="password" class="form-control form-control-sm" placeholder="Enter Password " value="">
                                                <span class="c-text-danger" id="password_msg"></span>
                                            </div>
                                        </div>
                                        <div class="mb-1 row">
                                            <label for="inputPassword3" class="col-sm-3 col-form-label">Confirm Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-sm" placeholder="Enter Confirm Password" value="">
                                                <span class="c-text-danger" id="confirm_password_msg"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-center col-sm-10">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                                <button type="reset" class="btn btn-warning"><span class="mdi mdi-rotate-left"></span>&nbsp;Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
                        location.reload();
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