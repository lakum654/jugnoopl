<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;

class StateController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.profile');
    }

    public function stateAdd(Request $request)
    {
        return view('admin.shopkeeper.add');
    }

    public function stateEdit(Request $request, $id)
    {
        $data = State::where('_id', $id)->first();
        return view('admin.shopkeeper.edit', compact('data'));
    }

    public function stateSave(Request $request)
    {
        // dd($request->all());
        if ($request->id != '') {
            $this->validate($request, [
                'state_name'                  => 'required',
            ]);
        } else {
            $this->validate($request, [
                'state_name'                  => 'required',
            ]);
        }

        if ($request->id != '') {

            $saveData                       = State::find($request->id);
            $saveData->state_name           = $request->state_name;
            $saveData->status               = 1;
            $saveData->save();
            return redirect()->route('state')->with('success', 'Data updated successfully.');
        } else {

            $saveData                       = new State;
            $saveData->state_name           = $request->state_name;
            $saveData->status               = 1;
            $saveData->save();
            return redirect()->route('state')->with('success', 'Data saved successfully.');
        }
    }

    public function stateStatus($id)
    {
        $data = State::find($id);
        $data->delete();
        return redirect()->route('state')->with('success', 'Data deleted successfully.');
    }
}
