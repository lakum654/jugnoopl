<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Validation\WarehouseValidation;
use App\Models\Shopkeeper;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\UserDetails;
use App\Models\Warehouse;
use App\Models\User;
use App\Models\WarehouseProduct;
use Str;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (!empty($request->perPage)) ? $request->perPage : config('global.perPage');
        $data['lists'] = Warehouse::paginate($perPage);

        return view('admin.warehouse.index', $data);
    }

    public function warehouseStock(Request $request)
    {
        $data['warehouses'] = Warehouse::where('status', 1)->get();
        $data['lists'] = WarehouseProduct::with(['Product'])->where('warehouse_id', $request->warehouse_id)->get();

        return view('admin.warehouse.stock', $data);
    }

    public function create(Request $request)
    {
        $data['users'] = User::where('status', 1)->where('role', 'warehouse')->get();
        $data['suppliers'] = Supplier::where('status', 1)->get();
        return view('admin.warehouse.create', $data);
    }

    public function edit($id)
    {
        $data['res'] = Warehouse::find($id);
        $data['users'] = User::where('status', 1)->where('role', 'warehouse')->get();
        $data['suppliers'] = Supplier::where('status', 1)->get();
        return view('admin.warehouse.edit', $data);
    }

    public function store(WarehouseValidation $request)
    {
        $save = new Warehouse();
        $save->users           = $request->users;
        $save->suppliers       = $request->suppliers;
        $save->store_name      = $request->store_name;
        $save->store_email     = $request->store_email;
        $save->gst_no          = $request->gst_no;
        $save->store_mobile    = $request->store_mobile;
        $save->country         = $request->country;
        $save->state           = $request->state;
        $save->city            = $request->city;
        $save->pincode         = $request->pincode;
        $save->store_address   = $request->store_address;
        $save->status          = (int)$request->status;
        $save->verified        = (int)$request->verified;

        if (!empty($request->file('files')))
            $save->attachments     = multipleFile($request->file('files'), 'warehouse');

        if (!$save->save())
            return response(['status' => 'error', 'msg' => 'warehouse not Created']);

        self::updateWarehouseIds($save->users, $save->_id); //for update warehouse id in user collection
        self::updateSupplierIds($save->suppliers, $save->_id); // for update warehose id in seller collection

        return response(['status' => 'success', 'msg' => 'warehouse Created Successfully!']);
    }


    public function update(WarehouseValidation $request, $id)
    {
        $save = Warehouse::find($id);
        $save->users           = $request->users;
        $save->suppliers       = $request->suppliers;
        $save->store_name      = $request->store_name;
        $save->store_email     = $request->store_email;
        $save->gst_no          = $request->gst_no;
        $save->store_mobile    = $request->store_mobile;
        $save->country         = $request->country;
        $save->state           = $request->state;
        $save->city            = $request->city;
        $save->pincode         = $request->pincode;
        $save->store_address   = $request->store_address;
        $save->status          = (int)$request->status;
        $save->verified        = (int)$request->verified;

        if (!empty($request->file('files')))
            $save->attachments     = multipleFile($request->file('files'), 'warehouse');

        if (!$save->save())
            return response(['status' => 'error', 'msg' => 'warehouse not Created']);

        self::updateWarehouseIds($save->users, $save->_id); //for update warehouse id in user collection
        self::updateSupplierIds($save->suppliers, $save->_id); // for update warehose id in seller collection

        return response(['status' => 'success', 'msg' => 'warehouse Updated Successfully!']);
    }

    private function updateSupplierIds($suppliers = array(), $w_id = false)
    {
        if (empty($suppliers) || !$w_id)
            return false;

        foreach ($suppliers as $id) {
            $warehouses = [];

            $supplier = Supplier::find($id);
            if (!empty($supplier->warehouses))
                $warehouses = $supplier->warehouses;

            $warehouses[] = $w_id;
            $supplier->warehouses = $warehouses;
            $supplier->save();
        }
    }

    private function updateWarehouseIds($users = array(), $w_id = false)
    {
        if (empty($users) || !$w_id)
            return false;

        foreach ($users as $id) {
            $warehouses = [];

            $user = User::find($id);
            if (!empty($user->warehouses))
                $warehouses = $user->warehouses;

            $warehouses[] = $w_id;
            $user->warehouses = $warehouses;
            $user->save();
        }
    }

    public function destroy($id)
    {
        $res = Warehouse::find($id)->delete();

        if (!$res)
            return response(['status' => 'error', 'msg' => 'warehouse not Created']);

        return response(['status' => 'success', 'msg' => 'Supplier Updated Successfully!']);
    }
}
