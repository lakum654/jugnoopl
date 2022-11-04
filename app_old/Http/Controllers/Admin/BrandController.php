<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Validation\BrandValidation;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{

    public function index(Request $request)
    {
        $perPage = (!empty($request->perPage)) ? $request->perPage : config('global.perPage');

        $data['lists'] = Brand::paginate($perPage);
        return view('admin.brand.index', $data);
    }


    public function edit(Request $request, $id)
    {
        $record = Brand::where('_id', $id)->first();
        return response(['status' => 'success', 'data' => $record]);
    }
    public function store(BrandValidation $request)
    {

        $save            = new Brand;
        $save->brand      = $request->brand;
        $save->status    = (int)$request->status;

        if (!$save->save())
            return response(['status' => 'error', 'msg' => 'Brand not Saved!']);

        return response(['status' => 'success', 'msg' => 'Brand Saved Successfully!']);
    }

    public function update(BrandValidation $request, $id)
    {
        $save            = Brand::find($id);
        $save->brand      = $request->brand;
        $save->status    = (int)$request->status;

        if (!$save->save())
            return response(['status' => 'error', 'msg' => 'Brand not Updated!']);

        return response(['status' => 'success', 'msg' => 'Brand Updated Successfully!']);
    }

    public function destrory($id)
    {
        $res = Brand::find($id)->delete();

        if (!$res)
            return response(['status' => 'error', 'msg' => 'Brand not Removed!']);

        return response(['status' => 'success', 'msg' => 'Brand Removed Successfully!']);
    }
}
