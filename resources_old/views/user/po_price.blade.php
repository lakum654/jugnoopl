@extends('user.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">

    <div class="card shadow mb-4">

        <x-page-head title="Purchase Order Price" />

        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>PO No</th>
                            <th>Warehouse Name</th>
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ !empty($list->po->po_no)?$list->po->po_no:'' }} </td>
                            <td>{{ !empty($list->Warehouse->store_name)?$list->Warehouse->store_name:'' }}</td>
                            <td>{{ $list->price }}</td>
                            <td> @switch($list->status)
                                @case('pending')
                                <span class="badge badge-outline-warning badge-pill">{{ strtoupper($list->item_status)}}</span>
                                @break
                                @case('complete')
                                <span class="badge badge-outline-success badge-pill">{{ strtoupper($list->item_status)}}</span>
                                @break
                                @default
                                <span class="badge badge-outline-warning badge-pill">Pending</span>
                                @break
                                @endswitch
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection