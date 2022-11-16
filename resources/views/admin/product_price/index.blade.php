@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">

    <div class="card shadow mb-4">

        @php $addons = ['assign'=>['selector'=>'assingProduct','name'=>'Assing']];@endphp
        <x-page-head title="Product Price List" url="admin/product_price/create" type="list" :addons=$addons />

        <div class="card-body p-2">
            <div class="row">
                <div class="form-group col-md-3">
                    <select class="form-control form-control-sm" id="selectWarehouse">
                        <option value="">Select Warehouse</option>
                        <option value="All">All</option>
                        @foreach($warehouses as $list)
                        <option value="{{ $list->_id }}" {{ (app('request')->input('warehouse_id')==$list->_id)?"selected":"" }}>{{ ucwords($list->store_name)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Warehouse</th>
                            <th>Selling Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($products_prices as $key => $val)
                                    <tr>
                                        <td>{{ $key +1 }}</td>
                                        <td>{{ $val->product->title}}</td>
                                        <td>{{ $val->warehouse->store_name}}</td>
                                        <td>{{ number_format($val->price,2) }}</td>
                                        <td>
                                            <a href="{{ route('product_price.edit',$val->_id) }}"><i class="fa fa-pencil"></i></a>
                                            <a href="{{ route('product_price.delete',$val->_id) }}"><i class="fa fa-trash"></i></a>
                                        </td>

                                    </tr>
                            @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="5">{{ $products_prices->links() }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
    $(document).ready(function() {
        @if(session()->has('success'))
            Swal.fire('success',"{{ session()->get('success') }}",'success');
        @endif
    })

    $('#selectWarehouse').on('load change', function() {
            var warehouse_id = $('#selectWarehouse').val();
            if(warehouse_id == 'All') {
                window.location.href = `/admin/product_price`;
            } else {
                window.location.href = `/admin/product_price?warehouse_id=${warehouse_id}`;
            }
    })
</script>
@endpush
@endsection
