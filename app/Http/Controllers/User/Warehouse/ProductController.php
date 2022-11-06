<?php

namespace App\Http\Controllers\User\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\grn;
use App\Models\GrnItem;
use App\Models\Po;
use App\Models\PoItem;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index($type = false)
    {
        $data['lists'] = WarehouseProduct::with(['Product.Category', 'Product.SubCategory'])->where('warehouse_id','all',Auth::user()->warehouses)->paginate(10);

        $data['warehouses']  = Warehouse::where('status', 1)->get();
        return view('user.warehouse.product.index', $data);
    }

    public function show($id)
    {
        $list = WarehouseProduct::find($id);

        return response($list);
    }

    public function store(Request $request)
    {
        $id = $request->_id;
        $wProduct = WarehouseProduct::find($id);
        $wProduct->price = (int)$request->price;
        if (!$wProduct->save())
            return response(['status' => 'error', 'msg' => 'Price not Updated']);

        return response(['status' => 'success', 'msg' => 'Price Updated Successfully!']);
    }

    public function searchProduct(Request $request)
    {
        $lists = WarehouseProduct::where('title', 'LIKE', "%$request->term%")->get();
        $data = [];
        foreach ($lists as $list) {

            $data[] = ['id' => $list->_id, 'text' => $list->title];
        }
        return response($data);
    }

    public function transferProduct(Request $request)
    {
        $items = $request->items;
        if (empty($items))
            return response(['status' => 'error', 'msg' => 'Please select any Item.']);

        $res = false;
        foreach ($items as $item) {
            $item = (object)$item;

            $product = WarehouseProduct::find($item->pro_id);

            $exist_pro = WarehouseProduct::where('warehouse_id', $request->warehouse_id)->where('product_id', $product->product_id)->first();
            if (!empty($exist_pro)) {
                $total_qty = ($exist_pro->total_qty) + ($item->stock);
                $exist_pro->total_qty = $total_qty;
                $res = $exist_pro->save();
            } else {
                $save = new WarehouseProduct();
                $save->po_items_ids = $product->po_items_ids;
                $save->po_ids       = $product->po_ids;
                $save->product_id   = $product->product_id;
                $save->unit         = $product->unit;
                $save->sku          = $product->sku;
                $save->title        = $product->title;
                $save->good_qty     = $product->good_qty;
                $save->bad_qty      = 0;
                $save->total_qty    = $item->stock;
                $save->warehouse_id = $request->warehouse_id;
                $res = $save->save();
            }
        }

        if(!$res)
        return response(['status'=>'error','msg'=>'Product not Transfered.']);

        return response(['status'=>'success','Product Transfered Successfully.']);
    }
}
