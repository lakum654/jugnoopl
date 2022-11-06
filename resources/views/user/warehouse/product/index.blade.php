@extends('user.layouts.layouts')
@section('content')
<style>
    .custom-m {
        margin-top: 35px;
    }

    .a-custom-m {
        margin-top: 10px;
    }
</style>
<div class="content-wrapper pb-0">

    <div class="card shadow mb-4">

        @php $addons = ['assign'=>['selector'=>'productTrans','name'=>'Transfer Product']];@endphp
        <x-page-head title="Product List" :addons=$addons />

        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td><img src="{{ imgPath('product', !empty($list->Product->image)?$list->Product->image:'')}}" class="img"></td>
                            <td>{{ ucwords($list->title) }}</td>
                            <td>{{ $list->sku }}</td>
                            <td>{{!empty($list->product->Category->name)?$list->product->Category->name:''}}</td>
                            <td>{{!empty($list->product->SubCategory->name)?$list->product->SubCategory->name:''}}</td>
                            <td>{{$list->price}}</td>
                            <td>{{ $list->total_qty}} {{$list->unit}}</td>
                            <td><a href="javascript:void(0);" class="btn btn-sm btn-outline-info addPrice" _id="{{$list->_id}}" price="{{$list->price}}" data-toggle="tooltip" title="Add Price"><span class="mdi mdi-grease-pencil"></span></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="9">
                                {{ $lists->links()}}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@push('modal')
<!-- Modal -->
<div class="modal fade" id="AddPriceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Product Price</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="cover-loader d-none">
                <div class="loader"></div>
            </div>

            <div class="modal-body h-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="add-price" action="{{url('user/warehouse-product')}}" method="post">
                            @csrf
                            <input type="hidden" name="_id" id="_id">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" id="price" class="form-control form-control-sm" name="price" placeholder="Enter Price">
                            </div>
                            <div class="form-group text-center">
                                <input type="submit" class="btn btn-primary" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--for transfer product modal-->

<div class="modal fade" id="productTransModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Transfer Product to Warehouse</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="cover-loader d-none">
                <div class="loader"></div>
            </div>

            <div class="modal-body h-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="transfer-product" action="{{url('user/transfer-product')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <select class="form-control form-control-sm" id="warehouse_id" name="warehouse_id">
                                    <option value="">Select Warehouse</option>
                                    @foreach($warehouses as $list)
                                    <option value="{{$list->_id}}">{{$list->store_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="product">
                                <div class="row">
                                    <div class="col-md-8 mb-1">
                                        <label>Product</label>
                                        <select class="form-control form-control-sm product_search" id="product_id" i="0" name="items[0][pro_id]">
                                            <option value="">Enter Product Name</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 p-0">
                                        <label>Stock</label>
                                        <input type="number" id="stock-0" class="form-control form-control-sm" name="items[0][stock]" placeholder="Enter Stock">
                                    </div>
                                    <div class="col-md-1 custom-m p-0">
                                        <small id="unit-0"></small>
                                    </div>
                                    <div class="col-md-1 custom-m p-0">
                                        <a href="javascript:void(0);" id="add-more" class="btn btn-primary btn-sm">+</a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <input type="submit" class="btn btn-primary" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endpush


@push('script')

<script>
    $('.addPrice').click(function(e) {
        e.preventDefault();
        $('#_id').val($(this).attr('_id'));
        $('#price').val($(this).attr('price'));
        $('#AddPriceModal').modal('show');
    });

    //save grn herer
    $('form#add-price').submit(function(e) {
        e.preventDefault();
        formData = new FormData(this);
        let url = $(this).attr('action');
        $('.cover-loader').removeClass('d-none');
        $('.h-body').addClass('d-none');
        axios.post(url, formData)
            .then(function(response) {
                res = response.data;

                $('.cover-loader').addClass('d-none');
                $('.h-body').removeClass('d-none');

                /*Start Validation Error Message*/
                $('span.custom-text-danger').html('');
                $.each(res.validation, (index, msg) => {
                    $(`#${index}_msg`).html(`${msg}`);
                })
                /*Start Validation Error Message*/

                /*Start Status message*/
                if (res.status == 'success' || res.status == 'error') {
                    Swal.fire(
                        `${res.status}!`,
                        res.msg,
                        `${res.status}`,
                    )
                }
                /*End Status message*/

                //for reset all field
                if (res.status == 'success') {
                    // $('form#save-item')[0].reset();
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }

            })
            .catch(function(error) {
                console.log(error);
                Swal.fire(
                    `Error!`,
                    error,
                    `error`,
                );
            });
    });

    $('#productTrans').click(function(e) {
        e.preventDefault();
        $('#productTransModal').modal('show');
        select2();
        $('.select2-container').css("width", "100%");
    })

    //save grn herer
    $('form#transfer-product').submit(function(e) {
        e.preventDefault();
        formData = new FormData(this);
        let url = $(this).attr('action');
        $('.cover-loader').removeClass('d-none');
        $('.h-body').addClass('d-none');
        axios.post(url, formData)
            .then(function(response) {
                res = response.data;

                $('.cover-loader').addClass('d-none');
                $('.h-body').removeClass('d-none');

                /*Start Validation Error Message*/
                $('span.custom-text-danger').html('');
                $.each(res.validation, (index, msg) => {
                    $(`#${index}_msg`).html(`${msg}`);
                })
                /*Start Validation Error Message*/

                /*Start Status message*/
                if (res.status == 'success' || res.status == 'error') {
                    Swal.fire(
                        `${res.status}!`,
                        res.msg,
                        `${res.status}`,
                    )
                }
                /*End Status message*/

                //for reset all field
                if (res.status == 'success') {
                    // $('form#save-item')[0].reset();
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }

            })
            .catch(function(error) {
                console.log(error);
                Swal.fire(
                    `Error!`,
                    error,
                    `error`,
                );
            });
    });

    var i = 1;
    $(document).on('click', '#add-more', function() {
        $('#product').append(`<div class="row" id="row-${i}">
                                    <div class="col-md-8 mb-1">
                                        <select class="form-control form-control-sm product_search" i="${i}" name="items[${i}][pro_id]">
                                            <option value="">Enter Product Name</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 p-0">
                                        <input type="number" id="stock-${i}" class="form-control form-control-sm" name="items[${i}][stock]" placeholder="Enter Stock">
                                    </div>
                                    <div class="col-md-1 a-custom-m p-0">
                                        <small id="unit-${i}"></small>
                                    </div>
                                    <div class="col-md-1 a-custom-m p-0">
                                        <a href="javascript:void(0);" onclick="remove(${i})" class="remove btn btn-warning btn-sm">-</a>
                                    </div>
                                </div>`);
        i++;
        select2();
    });

    function remove(i) {
        $('#row-' + i).fadeOut('slow');
    }

    function select2() {
        $('.product_search').select2({
            ajax: {
                url: '{{url("user/search-product")}}',
                processResults: function(data) {
                    return {
                        results: data
                    };
                }
            }
        }).on('change', function() {
            let product_id = $(this).val();
            let _id = $(this).attr('i');
            $.ajax({
                type: 'GET',
                url: '{{url("user/warehouse-product")}}/' + product_id,
                dataType: 'JSON',
                success: function(res) {
                    $('#stock-' + _id).val(res.total_qty);
                    $('#unit-' + _id).html(res.unit);
                }
            })
        });
    }
</script>
@endpush

@endsection
