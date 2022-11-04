<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Validation\Sub_CategoryValidation;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;

class SubCategoryController extends Controller
{

    public function index(Request $request)
    {
        $perPage = (!empty($request->perPage)) ? $request->perPage : config('global.perPage');

        $data['lists'] = SubCategory::paginate($perPage);
        $data['categories'] = Category::get();
        return view('admin.sub_category.index', $data);
    }


    public function edit(Request $request, $id)
    {
        $record = SubCategory::where('_id', $id)->first();
        return response(['status' => 'success', 'data' => $record]);
    }


    public function store(Sub_CategoryValidation $request)
    {

        $save            = new SubCategory;
        $save->category_id = $request->category;
        $save->name      = $request->name;
        $save->status    = (int)$request->status;
        if (!empty($request->file('icon')))
            $save->icon     = singleFile($request->file('icon'), 'category');

        if (!$save->save())
            return response(['status' => 'error', 'msg' => 'SubCategory not Saved!']);

        return response(['status' => 'success', 'msg' => 'SubCategory Saved Successfully!']);
    }

    public function update(Sub_CategoryValidation $request, $id)
    {
        $save            = SubCategory::find($id);
        $save->category_id = $request->category;
        $save->name      = $request->name;
        $save->status    = (int)$request->status;
        if (!empty($request->file('icon')))
            $save->icon     = singleFile($request->file('icon'), 'category');

        if (!$save->save())
            return response(['status' => 'error', 'msg' => 'SubCategory not Updated!']);

        return response(['status' => 'success', 'msg' => 'SubCategory Updated Successfully!']);
    }


    public function show($id)
    {
        $subCat = SubCategory::Select('_id', 'name')->where('category_id', $id)->get()->toArray();
        return response()->json($subCat);
    }

    public function destrory($id)
    {
        $res = SubCategory::find($id)->delete();

        if (!$res)
            return response(['status' => 'error', 'msg' => 'SubCategory not Removed!']);

        return response(['status' => 'success', 'msg' => 'SubCategory Removed Successfully!']);
    }
}
