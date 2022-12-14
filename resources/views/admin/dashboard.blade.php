@extends('admin.layouts.layouts')
@section('content')

@section('css')
<style>
    body{
    margin-top:20px;
    background:#FAFAFA;
}
.order-card {
    color: #fff;
}

.bg-c-blue {
    background: linear-gradient(45deg,#4099ff,#73b4ff);
}

.bg-c-green {
    background: linear-gradient(45deg,#2ed8b6,#59e0c5);
}

.bg-c-yellow {
    background: linear-gradient(45deg,#FFB64D,#ffcb80);
}

.bg-c-pink {
    background: linear-gradient(45deg,#FF5370,#ff869a);
}


.card {
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    border: none;
    margin-bottom: 30px;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

.card .card-block {
    padding: 25px;
}

.order-card i {
    font-size: 26px;
}

.f-left {
    float: left;
}

.f-right {
    float: right;
}
</style>
@endsection

@section('links')
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
@endsection
<div class="container">
    <div class="row">
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-blue order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Orders</h6>
                    <h2 class="text-right"><i class="fa fa-cart-plus f-left"></i><span>{{ $totalOrder}}</span></h2>
                    {{-- <p class="m-b-0">Completed Orders<span class="f-right">351</span></p> --}}
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-green order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Purchase Orders</h6>
                    <h2 class="text-right"><i class="fa fa-square f-left"></i><span>{{$totalPO}}</span></h2>
                    {{-- <p class="m-b-0">Completed Orders<span class="f-right">351</span></p> --}}
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-yellow order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Warehouses</h6>
                    <h2 class="text-right"><i class="fa fa-home f-left"></i><span>{{$totalWarehouse}}</span></h2>
                    {{-- <p class="m-b-0">Completed Orders<span class="f-right">351</span></p> --}}
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-pink order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Suppliers</h6>
                    <h2 class="text-right"><i class="fa fa-users f-left"></i><span>{{ $totalSupplier}}</span></h2>
                    {{-- <p class="m-b-0">Completed Orders<span class="f-right">351</span></p> --}}
                </div>
            </div>
        </div>
	</div>
</div>

<div class="container-fluid">
    <nav class="mb-3">
        <div class="nav nav-tabs nav-justified  nav-fill" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-order-tab" data-toggle="tab" data-target="#nav-order" type="button"
                role="tab" aria-controls="nav-order" aria-selected="true">Orders</button>
            <button class="nav-link" id="nav-warehouse-tab" data-toggle="tab" data-target="#nav-warehouse"
                type="button" role="tab" aria-controls="nav-warehouse" aria-selected="false">Warehouses</button>
            <button class="nav-link" id="nav-po-tab" data-toggle="tab" data-target="#nav-po" type="button"
                role="tab" aria-controls="nav-po" aria-selected="false">Purchase Orders</button>
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
