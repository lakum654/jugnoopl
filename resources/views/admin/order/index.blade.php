@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">
    <div class="page-header flex-wrap">

        <div class="header-right d-flex flex-wrap mt-2 mt-sm-0">
            <div class="d-flex align-items-center">
                <a href="#">
                    <p class="m-0 pr-3">Orders</p>
                </a>
            </div>
        </div>
    </div>

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <button class="nav-link active" id="nav-order-tab" data-toggle="tab" data-target="#nav-order" type="button" role="tab" aria-controls="nav-order" aria-selected="true">Orders</button>
          <button class="nav-link" id="nav-warehouse-tab" data-toggle="tab" data-target="#nav-warehouse" type="button" role="tab" aria-controls="nav-warehouse" aria-selected="false">Warehouses</button>
          <button class="nav-link" id="nav-po-tab" data-toggle="tab" data-target="#nav-po" type="button" role="tab" aria-controls="nav-po" aria-selected="false">Purchase Orders</button>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-order" role="tabpanel" aria-labelledby="nav-order-tab">
            <div class="row">
                <div class="col-xl-12 stretch-card grid-margin">
                    @include('admin.order.order')
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-warehouse" role="tabpanel" aria-labelledby="nav-warehouse-tab">
            <div class="row">
                <div class="col-xl-12 stretch-card grid-margin">
                    @include('admin.order.warehouse')
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-po" role="tabpanel" aria-labelledby="nav-po-tab">
            <div class="row">
                <div class="col-xl-12 stretch-card grid-margin">
                    @include('admin.order.po')
                </div>
            </div>
        </div>
      </div>

</div>
@endsection
