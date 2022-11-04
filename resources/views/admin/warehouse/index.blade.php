@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">

    <div class="card shadow mb-4">
    <x-page-head title="warehouse List " url="admin/warehouse/create" type="list" />

        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Store Name</th>
                            <th>Store Email</th>
                            <th>Store Address</th>
                            <th>Verified</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lists as $key => $value)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{$value->store_name}}</td>
                            <td>{{$value->store_email}}</td>
                            <td>{{$value->store_address}}</td>
                            <td>{!! $value->verified == 1? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-warning">No</span>' !!}</td>
                            <td>{!!$value->status == 1 ? '<span class="badge badge-success">Avtive</span>' : '<span class="badge badge-warning">In Active</span>'!!}</td>
                            <td>{{ $value->dformat($value->created)}}</td>
                            <td>
                                <a href="{{ url('admin/warehouse/'.$value->_id.'/edit') }}" class="btn btn-sm btn-outline-info"><span class="mdi mdi-pencil-box-outline"></span></a>
                                <a onclick="return confirm('Are you sure to detele this?')" href="" class="btn btn-sm btn-outline-danger"><span class="mdi mdi-delete"></span></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $lists->onEachSide(5)->links() }}
            </div>
        </div>
    </div>

</div>
@endsection