@extends('user.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">

    <div class="card shadow mb-4">

        <x-page-head title="GRN List" />

        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>GRN No</th>
                            <th>Receiving Date</th>
                            <th>Driver Name</th>
                            <th>D. Mobile No</th>
                            <th>Vehicle No</th>
                            <th>Bill Amount</th>
                            <th>Received BY</th>
                            <th>Status</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td><a href="{{ url('user/grn-po/'.$list->_id) }}" class="text-primary">{{ $list->grn_no }}</a></td>
                            <td>{{ $list->dFormat($list->receiving_date) }}</td>
                            <td>{{ $list->driver_name }}</td>
                            <td>{{ $list->driver_mobile }}</td>
                            <td>{{ $list->vehicle_no }}</td>
                            <td>{{ $list->bill_amount }}</td>
                            <td>{{ $list->received_by}}</td>
                            <td>{{ ucwords($list->status) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection