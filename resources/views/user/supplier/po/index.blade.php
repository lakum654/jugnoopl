@extends('user.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">

    <div class="card shadow mb-4">

        <x-page-head title="Purchase Order List" />

        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>PO No</th>
                            <th>Supplier Name</th>
                            <th>Warehouse Name</th>

                            <th>Item Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $list->po_no }}</td>
                            <td>{{ !empty($list->Supplier->store_name)?$list->Supplier->store_name:'' }}</td>
                            <td>{{ !empty($list->Warehouse->store_name)?$list->Warehouse->store_name:'' }}</td>

                            <td> @switch($list->item_status)
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
                            <td>{{ $list->dFormat($list->created)}}</td>
                            <td><a href="{{ url('user/supplier-po/'.$list->_id) }}" class="btn btn-sm btn-outline-info"><span class="mdi mdi-eye"></span></a></td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection