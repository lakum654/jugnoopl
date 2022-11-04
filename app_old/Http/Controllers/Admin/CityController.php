<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Validation\CityValidation;
use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{

    public function index(Request $request)
    {
        $perPage = (!empty($request->perPage)) ? $request->perPage : config('global.perPage');

        $data['lists'] = City::paginate($perPage);
        return view('admin.city.index', $data);
    } 


    public function edit(Request $request, $id)
    {
        $record = City::where('_id', $id)->first();
        return response(['status' => 'success', 'data' => $record]);
    }


    public function store(CityValidation $request)
    {
        $save            = new city;
        $save->city      = $request->city;
        $save->status    = (int)$request->status;

        if (!$save->save())
            return response(['status' => 'error', 'msg' => 'City not Saved!']);

        return response(['status' => 'success', 'msg' => 'City Saved Successfully!']);
    }

    public function update(CityValidation $request, $id)
    {
        $save            = City::find($id);
        $save->city      = $request->city;
        $save->status    = (int)$request->status;

        if (!$save->save())
            return response(['status' => 'error', 'msg' => 'City not Updated!']);

        return response(['status' => 'success', 'msg' => 'City Updated Successfully!']);
    }

    public function destrory($id)
    {
        $res = City::find($id)->delete();

        if (!$res)
            return response(['status' => 'error', 'msg' => 'City not Removed!']);

        return response(['status' => 'success', 'msg' => 'City Removed Successfully!']);
    }
}
