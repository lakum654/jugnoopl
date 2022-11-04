@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">

    <div class="card shadow mb-4">

        <x-page-head title="Users List" url="admin/user/create" type="list" />

        <div class="card-body p-0">
            <div class="table-responsive">
            
                <table class="table table-striped">
                    <tr>
                        <th>#</th>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <tbody>
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td class="py-1">
                                <img src="{{asset('users/'.$list->profile_img ?? '')}}" alt="Oop's No"> 
                            </td>
                            <td>{{$list->name}}</td>
                            <td>{{$list->email}}</td>
                            <td>{{$list->mobile}}</td>
                            <td>{{ucwords($list->role)}}</td>
                            <td>{!!$list->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">In Active</span>'!!}</td>
                            <td>
                                <a href="{{ url('admin/user/'.$list->_id.'/edit') }}" class="btn btn-sm btn-outline-info"><span class="mdi mdi-pencil-box-outline"></span></a>
                                <a onclick="return confirm('Are you sure to detele this?')" href="{{$list->id}}" class="btn btn-sm btn-outline-danger"><span class="mdi mdi-delete"></span></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $lists->appends($_GET)->links()}}
            </div>
        </div>
    </div>

</div>
@endsection