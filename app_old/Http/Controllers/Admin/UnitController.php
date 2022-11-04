<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Validation\UnitValidation;
use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
 
    public function index(Request $request)
    {
        $perPage = (!empty($request->perPage)) ? $request->perPage : config('global.perPage');

        $data['lists'] = Unit::paginate($perPage);

        return view('admin.unit.index', $data);
    }


    public function edit(Request $request, $id)
    {
        $record = Unit::where('_id', $id)->first();
        return response(['status' => 'success', 'data' => $record]);
    }


    public function store(UnitValidation $request)
    {
        $save            = new Unit;
        $save->unit      = $request->unit;
        $save->status    = (int)$request->status;

        if (!$save->save())
            return response(['status' => 'error', 'msg' => 'Unit not Saved!']);

        return response(['status' => 'success', 'msg' => 'Unit Saved Successfully!']);
    }

    public function update(UnitValidation $request, $id)
    {
        $save            = Unit::find($id);
        $save->unit      = $request->unit;
        $save->status    = (int)$request->status;

        if (!$save->save())
            return response(['status' => 'error', 'msg' => 'Unit not Updated!']);

        return response(['status' => 'success', 'msg' => 'Unit Updated Successfully!']);
    }

    public function destrory($id)
    {
        $res = Unit::find($id)->delete();

        if (!$res)
            return response(['status' => 'error', 'msg' => 'Unit not Removed!']);

        return response(['status' => 'success', 'msg' => 'Unit Removed Successfully!']);
    }
}
