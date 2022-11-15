@extends('admin.layouts.layouts')
@section('content')
    <div class="content-wrapper pb-0">
        <div class="card shadow mb-4">

            <div class="cover-loader d-none">
                <div class="loader"></div>
            </div>
            <x-page-head title="Add Product Price" url="admin/product_price" type="create" />

            <div class="card-body h-body">
                <div class="row">

                    <div class="col-lg-12">
                        <form id="product" action="{{ route('product_price.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Select Products<span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm" id="product_id" name="product_id" required>
                                        <option value="">Select</option>
                                        @foreach ($products as $key => $val)
                                            <option value="{{ $val->_id }}">{{ $val->title }}</option>
                                        @endforeach

                                    </select>
                                    <span id="product_id_msg" class="c-text-danger"></span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Select Warehouse<span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm" id="warehouse_id" name="warehouse_id"
                                        required>
                                        <option value="">Select</option>
                                        @foreach ($warehouses as $key => $val)
                                            <option value="{{ $val->_id }}">{{ $val->store_name }}</option>
                                        @endforeach
                                    </select>
                                    <span id="warehouse_id_msg" class="c-text-danger"></span>
                                </div>


                                <div class="form-group col-md-4">
                                    <label>Price<span class="text-danger">*</span></label>
                                    <input type="number" name="price" id="price" class="form-control form-control-sm"
                                        placeholder="Enter Selling Price" required>
                                    <span id="price_msg" class="c-text-danger"></span>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 text-center">
                                    <input type="submit" value="Submit" class="btn btn-success">
                                    <button type="reset" class="btn btn-warning"><span
                                            class="mdi mdi-rotate-left"></span>&nbsp;Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script>
            $(document).ready(function() {
                @if (session()->has('success'))
                    Swal.fire('success', "{{ session()->get('success') }}", 'success');
                @endif

                @if (session()->has('error'))
                    Swal.fire('error', "{{ session()->get('success') }}", 'error');
                @endif
            })
        </script>
    @endpush
@endsection
