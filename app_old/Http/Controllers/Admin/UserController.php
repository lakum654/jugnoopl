<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Validation\UserValidation;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function index(Request $request)
    {
        try {
            $perPage = (!empty($request->perPage)) ? $request->perPage : config('global.perPage');
            $data['lists'] = User::where('parent_id', Auth::user()->id)->paginate($perPage);
          	//return json_encode($data);
            return view('admin.users.index', $data);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function create(Request $request)
    {
        return view('admin.users.create');
    }

    public function edit($id)
    {
        $data['res'] = User::find($id);

        return view('admin.users.edit', $data);
    }

    public function store(UserValidation $request)
    {
        $save = new User();
        $save->parent_id       = Auth::user()->id;
      $save->profile_img            = $request->profile_img;
        $save->name            = $request->name;
        $save->email           = $request->email;
        $save->mobile          = $request->mobile;
        $save->role            = $request->role;
        $save->password        = Hash::make($request->password);
        $save->state           = $request->state;
        $save->city            = $request->city;
        $save->country         = $request->country;
        $save->pincode         = $request->pincode;
        $save->address         = $request->address;
        $save->status          = (int)$request->status;

        if (!empty($request->file('profile_img')))
            $save->profile_image  = singleFile($request->file('profile_img'), 'users');

        if (!$save->save())
            return response(['status' => 'error', 'msg', 'User not Created']);
      
    //  return redirect()->back()->with('msg', 'User not Created');

        return response(['status' => 'success', 'msg' => 'User Created Successfully!']);
      
     //  return redirect()->back()->with('msg', 'User Created Successfully!');
    }


    public function update(UserValidation $request, $id)
    {
        $save = User::find($id);
    //  $save->profile_img            = $request->profile_img;
        $save->name            = $request->name;
        $save->email           = $request->email;
        $save->role            = $request->role;
        $save->mobile          = $request->mobile;
        $save->state           = $request->state;
        $save->city            = $request->city;
        $save->country         = $request->country;
        $save->pincode         = $request->pincode;
        $save->address         = $request->address;
        $save->status          = (int)$request->status;

        if (!empty($request->file('profile_img')))
            $save->profile_img   = singleFile($request->file('profile_img'), 'users');

        if (!$save->save())
          //  return response(['status' => 'error', 'msg' => 'User not Updated']);
          
          return redirect()->back()->with('msg', 'User not Updated');

       // return response(['status' => 'success', 'msg' => 'User Updated Successfully!']);
      
			// return Back('/user')->with('msg', 'User Updated Successfully!');
      return redirect()->back()->with('msg', 'User Updated Successfully!');
    }


    public function destroy($id)
    {
        $res = User::find($id)->delete();

        if (!$res)
            return response(['status' => 'error', 'msg' => 'User not Deleted']);

        return response(['status' => 'success', 'msg' => 'User Deleted Successfully!']);
    }
}
