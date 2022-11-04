<?php

namespace App\Http\Controllers\User\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\grn;
use App\Models\GrnItem;
use App\Models\Po;
use App\Models\PoItem;
use App\Models\WarehouseProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index($type = false)
    {
        $data['lists'] = WarehouseProduct::with(['Product.Category','Product.SubCategory'])->get();

        return view('user.warehouse.product.index', $data);
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
}
