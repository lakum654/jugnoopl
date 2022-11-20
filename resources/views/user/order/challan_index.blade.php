@extends('user.layouts.layouts')
@section('content')
<style>
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

<div class="content-wrapper pb-0">
    <!-- <div class="card shadow mb-4"> -->

    <!-- </div> -->
    <div class="page-header flex-wrap">
        <div class="header-right d-flex flex-wrap mt-2 mt-sm-0">
            <div class="d-flex align-items-center">
                <h5>{{ ucfirst(auth()->user()->role) }} Dashboard</h5>
            </div>
        </div>
    </div>

    <!-- first row starts here -->
    <div class="row">
        @if(Auth::user()->role == 'warehouse')
        <div class="col-xl-12 stretch-card grid-margin">
            <div class="card">
                <div class="card-header">
                    <h6>Warehouse Challan List</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Challan No</th>
                                    <th>Received Date</th>
                                    <th>Driver Name</th>
                                    <th>Driver Mobile</th>
                                    <th>Vehicle No</th>
                                    <th>Warehouse</th>
                                    <th>Bill Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($challan_list as $key => $val)
                                    <tr>
                                        <td>{{ $key+1}}</td>
                                        <td>{{$val->challan_no}}</td>
                                        <td>{{date('d-m-Y',strtotime($val->receiving_date))}}</td>
                                        <td>{{ $val->driver_name}}</td>
                                        <td>{{ $val->driver_mobile}}</td>
                                        <td>{{ $val->vehicle_no}}</td>
                                        <td>{{ $val->warehouse->store_name ?? '--'}}</td>
                                        <td>{{ $val->bill_amount}}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                    <tr>
                                        <td colspan="8">
                                            {{-- {{$orders->links()}} --}}
                                        </td>
                                    </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-xl-3 stretch-card grid-margin">

        </div>
    </div>


</div>


@endsection
