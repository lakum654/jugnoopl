@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">
    <div class="page-header flex-wrap">

        <div class="header-right d-flex flex-wrap mt-2 mt-sm-0">
            <div class="d-flex align-items-center">
                <a href="#">
                    <p class="m-0 pr-3">Dashboard</p>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 stretch-card grid-margin">
            @include('admin.dashboard.order')
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 stretch-card grid-margin">
            @include('admin.dashboard.warehouse')
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 stretch-card grid-margin">
            @include('admin.dashboard.po')
        </div>
    </div>


</div>
@endsection