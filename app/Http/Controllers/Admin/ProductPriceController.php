<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class ProductPriceController extends Controller
{
    public function index(Request $request) {
        $products = ProductPrice::with(['product','warehouse']);

        if($request->warehouse_id && $request->warehouse_id != null) {
            $products->where('warehouse_id',$request->warehouse_id);
        }

        $data['products_prices'] = $products->paginate(10);
        $data['warehouses'] = Warehouse::get();
        return view('admin.product_price.index',$data);
    }

    public function create() {
        $data['products'] = Product::get();
        $data['warehouses'] = Warehouse::get();
        return view('admin.product_price.create',$data);
    }

    public function store(Request $request) {
        $request->validate([
            'product_id' => 'required|unique:product',
            'warehouse_id' => 'required|unique:warehouse',
            'price' => 'required'
        ]);

        $inputs = $request->all();

        $check = ProductPrice::where('product_id',$request->product_id)->where('warehouse_id' ,$request->warehouse_id)->first();
        if($check) {
            return back()->with(['error' => 'Product Price Entry Already Exsist.']);
        }
        ProductPrice::create($inputs);

        return back()->with(['success' => 'Product Price Create Successfully.']);
    }

    public function edit($id) {
        $data['product'] = ProductPrice::find($id);
        $data['products'] = Product::get();
        $data['warehouses'] = Warehouse::get();
        return view('admin.product_price.edit',$data);
    }
    public function update(Request $request,$id) {
        $inputs = $request->all();
        $inputs = $request->all();
        ProductPrice::find($id)->update($inputs);
        return back()->with(['success' => 'Product Price Updated Successfully.']);
    }
    public function delete($id) {
        $data = ProductPrice::find($id)->forceDelete();
        return back()->with(['success' => 'Product Price Deleted Successfully.']);
    }
}
