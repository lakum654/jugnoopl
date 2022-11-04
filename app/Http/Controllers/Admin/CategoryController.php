<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Validation\CategoryValidation;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $perPage = (!empty($request->perPage)) ? $request->perPage : config('global.perPage');

        $data['lists'] = Category::paginate($perPage);
        return view('admin.category.index', $data);
    }


    public function edit(Request $request, $id)
    {
        $record = Category::where('_id', $id)->first();
        return response(['status' => 'success', 'data' => $record]);
    }


    public function store(CategoryValidation $request)
    {
        $save            = new Category;
        $save->name      = $request->name;
        $save->status    = (int)$request->status;
        if (!empty($request->file('icon')))
            $save->icon     = singleFile($request->file('icon'), 'category');

        if (!$save->save())
            return response(['status' => 'error', 'msg' => 'Category not Saved!']);

        return response(['status' => 'success', 'msg' => 'Category Saved Successfully!']);

        // }
    }

    public function update(CategoryValidation $request, $id)
    {
        $save            = Category::find($id);
        $save->name      = $request->name;
        $save->status    = (int)$request->status;
        if (!empty($request->file('icon')))
            $save->icon     = singleFile($request->file('icon'), 'category');

        if (!$save->save())
            return response(['status' => 'error', 'msg' => 'Category not Updated!']);

        return response(['status' => 'success', 'msg' => 'Category Updated Successfully!']);
    }

    public function destrory($id)
    {
        $res = Category::find($id)->delete();

        if (!$res)
            return response(['status' => 'error', 'msg' => 'Category not Removed!']);

        return response(['status' => 'success', 'msg' => 'Category Removed Successfully!']);
    }
}
