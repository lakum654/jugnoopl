@extends('user.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">

    <div class="card shadow mb-4">

        <x-page-head title="Supplier Product List" />

        <div class="card-body p-2">

            <div class="table-responsive">
                <table class="table table-hover table-striped table-hovered">
                    <!-- <thead> -->
                    <tr>
                        <th>#</th>
                        <th>Supplier Name</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Date Range</th>
                        <th>Assign Date</th>
                        <!-- <th>Action</th> -->
                    </tr>
                    <!-- </thead> -->
                    <tbody>
                        @if(!empty($lists))
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{!empty($list->Supplier->store_name) ? ucwords($list->Supplier->store_name): ''}}</td>
                            <td>{{!empty($list->Product->title) ? ucwords($list->Product->title): ''}}</td>
                            <td>{{ $list->price }}</td>
                            <td>{{ !empty($list->start_date) ? $list->start_date:'' }} To {{ !empty($list->end_date) ? $list->end_date: ''}}</td>
                            <td>{{ $list->dformat($list->created)}}</td>
                            <!-- <td>
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-info contractProduct" _id="{{$list->_id}}"><span class="mdi mdi-book-plus"></span></a>
                            </td> -->
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7" class="text-center">Not Found Any Record</td>
                        </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                {{ $lists->links()}}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection
