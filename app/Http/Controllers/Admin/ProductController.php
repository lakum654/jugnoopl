<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Validation\ProductValidation;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Brand;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $perPage = (!empty($request->perPage)) ? $request->perPage : config('global.perPage');

        $data['lists'] = Product::paginate($perPage);

        $data['suppliers'] = Supplier::where('status', 1)->get();

        return view('admin.products.index', $data);
    }


    public function create(Request $request)
    {
        $data['categories']    = Category::where('status', 1)->get();
        $data['units']         = Unit::where('status', 1)->get();
        $data['brands']        = Brand::where('status', 1)->get();
        return view('admin.products.create', $data);
    }


    public function edit($id)
    {
        $data['res']  = Product::find($id);

        $data['categories']    = Category::where('status', 1)->get();
        $data['units']         = Unit::where('status', 1)->get();
        $data['brands']        = Brand::where('status', 1)->get();
        return view('admin.products.edit', $data);
    }

    public function store(ProductValidation $request)
    {
        $save = new Product();
        $save->user_id         = Auth::user()->id;
        $save->title           = $request->title;
        $save->sku             = $request->sku;
        $save->category_id        = $request->category;
        $save->sub_category_id    = $request->sub_category;
        $save->brand_id        = $request->brand_id;
        $save->unit_id         = $request->unit_id;
        $save->status          = (int)$request->status;


        if (!empty($request->file('image')))
            $save->image     = singleFile($request->file('image'), 'product');

        if (!$save->save())
            return response(['status' => 'error', 'msg' => 'Product not Created']);

        return response(['status' => 'success', 'msg' => 'Product Created Successfully!']);
    }


    public function update(ProductValidation $request, $id)
    {
        $save = Product::find($id);
        $save->title           = $request->title;
        $save->sku             = $request->sku;
        $save->category_id     = $request->category;
        $save->sub_category_id = $request->sub_category;
        $save->brand_id        = $request->brand_id;
        $save->unit_id         = $request->unit_id;
        $save->status          = (int)$request->status;

        if (!empty($request->file('image')))
            $save->image     = singleFile($request->file('image'), 'product');

        if (!$save->save())
            return response(['status' => 'error', 'msg' => 'Product not Updated']);

        return response(['status' => 'success', 'msg' => 'Product Updated Successfully!']);
    }


    public function destroy($id)
    {
        $res = Product::find($id)->delete();

        if (!$res)
            return response(['status' => 'error', 'msg' => 'Product not Removed']);

        return response(['status' => 'success', 'msg' => 'Product Removed Successfully!']);
    }


    public function assignProduct(Request $request)
    {
        try {
            foreach ($request->products as $id) {
                $save = new SupplierProduct();
                $save->supplier_id = $request->supplier_id;
                $save->product_id  = $id;

                if (!$save->save())
                    return response(['status' => 'error', 'msg' => 'Product not Assigned!']);
            }

            return response(['status' => 'success', 'msg' => 'Product Assigned successfully!']);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
