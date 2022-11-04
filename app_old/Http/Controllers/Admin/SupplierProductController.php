<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupplierProduct;
use App\Models\Supplier;
use App\Models\Unit;

class SupplierProductController extends Controller
{

    public function index(Request $request)
    {
        if (!empty($request->supplier_id))
            $data['lists'] = SupplierProduct::with(['Product', 'Supplier'])->where('supplier_id', $request->supplier_id)->get();

        $data['suppliers'] = Supplier::get();

        return view('admin.supplierProduct.index', $data);
    }


    public function edit(Request $request, $id)
    {
        $record = SupplierProduct::where('_id', $id)->first();
        return response(['status' => 'success', 'data' => $record]);
    }


    public function update(Request $request, $id)
    {

        $dateRange = explode('-', $request->daterange);

        $save             = SupplierProduct::find($id);
        $save->price      = $request->price;
        $save->start_date = $dateRange[0];
        $save->end_date   = $dateRange[1];
        $save->status     = (int)$request->status;

        if (!$save->save())
            return response(['status' => 'error', 'msg' => 'Product not Updated!']);

        return response(['status' => 'success', 'msg' => 'Product Updated Successfully!']);
    }

    public function destrory($id)
    {
        $res = SupplierProduct::find($id)->delete();

        if (!$res)
            return response(['status' => 'error', 'msg' => 'Product not Removed!']);

        return response(['status' => 'success', 'msg' => 'Product Removed Successfully!']);
    }

    public function getSupplier(Request $request, $warehouse_id = false)
    {
        if (!$warehouse_id)
            return false;

        $records = Supplier::select('_id', 'store_name')->where('warehouses', 'all', [$warehouse_id])->get();

        return response(['status' => 'success', 'data' => $records]);
    }

    public function getSupplierProduct($id)
    {
        $records = SupplierProduct::with(['product.unit'])->where('supplier_id', $id)->get();
        return response(['status' => 'success', 'data' => $records]);
    }
}
