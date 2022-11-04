@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">

    <div class="card shadow mb-4">

        <x-page-head title="Warehouse Stock" />

        <div class="card-body p-2">

            <div class="row">
                <div class="form-group col-md-3">
                    <select class="form-control form-control-sm" id="selectWarehouse">
                        <option value="">Select Warehouse</option>
                        @foreach($warehouses as $list)
                        <option value="{{ $list->_id }}" {{ (app('request')->input('warehouse_id')==$list->_id)?"selected":"" }}>{{ ucwords($list->store_name)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped table-hovered">
                    <!-- <thead> -->
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>SKU</th>
                        <th>Stock</th>
                    </tr>
                    <!-- </thead> -->
                    <tbody>
                        @if(!empty($lists))
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td><img src="{{ imgPath('product', !empty($list->Product->image)?$list->Product->image:'')}}" class="img"></td>
                            <td>{{ ucwords($list->title) }}</td>
                            <td>{{ $list->sku }}</td>
                            <td>{{ $list->total_qty }}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7" class="text-center">Not Found Any Record</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@push('modal')
<!-- Modal -->
<div class="modal fade" id="ContractProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHeading">Make Contract</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="cover-loader d-none">
                <div class="loader"></div>
            </div>

            <div class="modal-body h-body">
                <form id="contractProduct" action="" method="post">
                    @csrf
                    <div id="put"></div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Price</label>
                            <input type="text" name="price" id="price" class="form-control form-control-sm" placeholder="Enter Price" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Date Range</label>
                            <input type="text" id="daterange" class="form-control form-control-sm daterange" name="daterange">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success" id="submitproduct">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endpush
@push('script')
<script>
    $(document).ready(function() {

        //for warehosue select filter
        $('#selectWarehouse').on('load change', function() {
            window.location.href = window.location.origin + '/admin/warehouse-stock' + '?warehouse_id=' + $(this).val();
        })

    })
</script>
@endpush
@endsection