<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\WarehouseProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index()
    {
        // $lists = WarehouseProduct::get();

        // if ($lists->isEmpty())
        //     return $this->setResponse(false, 'No Record Found', 404);

        // $records = [];
        // foreach ($lists as $list) {
        //     $records[] = [
        //         '_id'        => $list->_id,
        //         'product_id' => $list->product_id,
        //         'unit'       => $list->unit,
        //         'sku'        => $list->sku,
        //         'title'      => $list->title,
        //         'good_qty'   => $list->good_qty,
        //         'bad_qty'    => $list->bad_qty,
        //         'total_qty'  => $list->total_qty,
        //         'user_id'    => $list->user_id,
        //         'price'      => $list->price,
        //         'created'    => $list->created,
        //         'updated'    => $list->updated
        //     ];
        // }
        // return $this->setResponse(true, $records, 200);
    }
  
  	public function userOrders($id)
    {
      $orders = Order::where('shokeeper_id', $id)->get();
      
      return $this->setResponse(true, $orders, 200);
    }


    public function store(Request $request)
    {
        $save = new Order();
        $save->shokeeper_id     = Auth::user()->id;
        $save->warehouse_id     = $request->warehouse_id;
        $save->order_no         = rand(111111,999999);
        $save->order_date       = (int)strtotime($request->order_date);
        $save->payment_type     = $request->payment_type;
        $save->order_status     = $request->order_status;
        $save->shipping_details = $request->shipping_details;
        $save->billing_details  = $request->billing_details;
        $save->products         = $request->products;
        $save->order_total      = (int)$request->order_total;
        if ($save->save())
            return $this->setResponse(true, 'Order Created Successfully!', 200, 'm');

        return $this->setResponse(false, 'No Record Found', 404);
    }
}
