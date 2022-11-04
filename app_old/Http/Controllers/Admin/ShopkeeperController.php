<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Validation\ShopkeeperValidation;
use App\Models\Shopkeeper;
use App\Models\User;
use Illuminate\Http\Request;

class ShopkeeperController extends Controller
{

    public function index(Request $request)
    {
        $perPage = (!empty($request->perPage)) ? $request->perPage : config('global.perPage');

        $data['lists'] = Shopkeeper::paginate($perPage);

        return view('admin.shopkeeper.index', $data);
    }

    public function create(Request $request)
    {
        $data['users'] = User::where('status', 1)->where('role','shopkeeper')->get();
        return view('admin.shopkeeper.create', $data);
    }

    public function edit($id)
    {
        $data['res'] = Shopkeeper::find($id);
        $data['users'] = User::where('status', 1)->where('role','shopkeeper')->get();
        return view('admin.shopkeeper.edit', $data);
    }

    public function store(Shopkeepervalidation $request)
    {
        $save = new Shopkeeper();
        $save->users           = $request->users;
        $save->store_name      = $request->store_name;
        $save->store_mobile    = $request->store_mobile;
        $save->store_email     = $request->store_email;
        $save->gst_no          = $request->gst_no;
        $save->country         = $request->country;
        $save->state           = $request->state;
        $save->city            = $request->city;
        $save->pincode         = $request->pincode;
        $save->store_address   = $request->store_address;
        $save->status          = (int)$request->status;
        $save->verified        = (int)$request->verified;

        if (!empty($request->file('files')))
            $save->attachments     = multipleFile($request->file('files'), 'shopkeeper');

        if (!$save->save())
         //   return response(['status' => 'error', 'msg' => 'Shopkeeper not Created']);
          
          return redirect()->back()->with('msg', 'Shopkeeper not Created');

      //  return response(['status' => 'success', 'msg' => 'Shopkeeper Created Successfully!']);
      
      return redirect()->back()->with('msg','Shopkeeper Created Successfully!');
    }


    public function update(Request $request, $id)
    {
        $save = Shopkeeper::find($id);
        $save->users           = $request->users;
        $save->store_name      = $request->store_name;
        $save->store_mobile    = $request->store_mobile;
        $save->store_email     = $request->store_email;
        $save->gst_no          = $request->gst_no;
        $save->country         = $request->country;
        $save->state           = $request->state;
        $save->city            = $request->city;
        $save->pincode         = $request->pincode;
        $save->store_address   = $request->store_address;
        $save->status          = (int)$request->status;
        $save->verified        = (int)$request->verified;

        if (!empty($request->file('files')))
            $save->attachments     = multipleFile($request->file('files'), 'shopkeeper');

        if (!$save->save())
         //   return response(['status' => 'error', 'msg' => 'Shopkeeper not Created']);
          
          return redirect()->back()->with('msg', 'Shopkeeper not Updated');

      //  return response(['status' => 'success', 'msg' => 'Shopkeeper Updated Successfully!']);
      return redirect()->back()->with('msg', 'Shopkeeper Updated Successfully!');
      
    }


    public function destroy($id)
    {
     
       $res = Shopkeeper::find($id)->delete();
     
        if (!$res)
         //   return response(['status' => 'error', 'msg' => 'Shopkeeper not Deleted']);
          
          return redirect()->back()->with('msg','Shopkeeper not Deleted');

      //  return response(['status' => 'success', 'msg' => 'Shopkeeper Deleted Successfully!']);
      
      return reditect()->back()->with('msg','Shopkeeper Deleted Successfully!');
    }
}
