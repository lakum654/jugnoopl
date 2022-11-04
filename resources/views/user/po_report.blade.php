@extends('user.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">

    <div class="card shadow mb-4">

        <x-page-head title="Purchase Order Report" />

        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="collabse-table table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Stock</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lists as $key => $list)
                        @php $k = $key+1;@endphp
                        <tr colspan="5" data-toggle="collapse" data-target="#demo{{$k}}" class="accordion-toggle">
                            <td>{{ ++$key }}</td>
                            <td>{{ $list->title }}</td>
                            <td>{{ $list->sku }}</td>
                            <td>{{$list->price}}</td>
                            <td>{{ $list->total_qty}} {{$list->unit}}</td>
                            </td>
                        </tr>
                        <tr class="p">
                            <td colspan="5" class="hiddenRow">
                                <div class="accordian-body collapse p-1" id="demo{{$k}}">
                                    <table class="table">
                                        <thead>
                                            <tr class="p-1">
                                                <th>#</th>
                                                <th>Po Number</th>
                                                <th>SKU/Product</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <th>Price</th>
                                                <th>Receiving Date</th>
                                            </tr>
                                        </thead>
                                        @foreach($list->WpToPo as $count=>$po)
                                        <tr class="p-1">
                                            <td>{{$key}}.{{$count++}}</td>
                                            <td>{{!empty($po->PoItems->Po->po_no)?$po->PoItems->Po->po_no:''}}</td>
                                            <td>{{!empty($po->PoItems->sku)?$po->PoItems->sku:''}}/{{!empty($po->PoItems->title)?$po->PoItems->title:''}}</td>
                                            <td>{{!empty($po->PoItems->req_qty)?$po->PoItems->req_qty:''}}</td>
                                            <td>{{!empty($po->PoItems->unit)?$po->PoItems->unit:''}}</td>
                                            <td>{{!empty($po->PoItems->price_by_supplier)?$po->PoItems->price_by_supplier:''}}</td>
                                            <td></td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
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