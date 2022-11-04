@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">

    <div class="card shadow mb-4">

        <x-page-head title="Shopkeeper List" url="admin/shopkeeper/create" type="list" />
      
       @if(session('msg'))
                  <div class="alert alert-success">{{session('msg')}}</div>
              @endif


        <div class="card-body p-0 table-responsive">
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
                    @foreach($lists as $key => $list)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{$list->store_name}}</td>
                        <td>{{$list->store_email}}</td>
                        <td>{{$list->store_address}}</td>
                        <td>{!! $list->verified == 1? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-warning">No</span>' !!}</td>
                        <td>{!!$list->status == 1 ? '<span class="badge badge-success">Avtive</span>' : '<span class="badge badge-warning">In Active</span>'!!}</td>
                        <td>{{$list->dFormat($list->created)}}</td>
                        <td>
                            <a href="{{ url('admin/shopkeeper/'.$list->_id.'/edit') }}" class="btn btn-sm btn-outline-info"><span class="mdi mdi-pencil-box-outline"></span></a>
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
@endsection