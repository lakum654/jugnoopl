<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Validation\ProfileValidation;
use App\Http\Validation\ResetValidation;

class ProfileController extends Controller
{
    public function index()
    {
        $data['user'] = User::find(Auth::user()->_id);
        //  $data['state'] = State::get();
        return view('admin.profile', $data);
    }


    public function store(ResetValidation $request)
    {
      
        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            
            return response(['status' => 'error', 'msg' => 'Current password does not match!']);
        }

        $user->password = Hash::make($request->password);
        if (!$user->save())
            return response(['status' => 'error', 'msg' => 'Password not changed']);

        return response(['status' => 'success', 'msg' => 'Password successfully changed!']);
    }

    public function update(ProfileValidation $request, $id)
    {
        $save = User::find($id);
        $save->name            = $request->name;
        $save->email           = $request->email;
        $save->mobile          = $request->mobile;
        $save->state           = $request->state;
        $save->city            = $request->city;
        $save->pincode         = $request->pincode;
        $save->address         = $request->address;

        if (!$save->save())
            return response(['status' => 'error', 'msg' => 'Profile not Created']);

        return response(['status' => 'success', 'msg' => 'Profile Updated Successfully!']);
    }

    
}
