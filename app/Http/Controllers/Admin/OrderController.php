<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDelivery;
use App\Models\Po;
use App\Models\Warehouse;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {

        $data['orders'] = Order::with(['delivery', 'wearhouse',])->orderBy('created', 'desc')->paginate(10);
        $data['warehouses'] = Warehouse::orderBy('creared', 'desc')->paginate(10);
        $data['pos'] = Po::with(['Supplier'])->orderBy('created', 'desc')->paginate(10);

        // return json_encode($data);

        return view('admin.order.index', $data);
    }

    public function changeStatus(Request $request)
    {
        // return json_encode($request->all());
        try {
            $order = Order::find($request->id);

            if (empty($order))
                return $this->setResponse(false, 'Order not found', 404);

            $order->order_status = $request->status;
            $order->warehouse_id = $request->wear_house;
            $order->save();

            return redirect()->back()->with('msg', 'Order updated successfully');
        } catch (Exception $e) {
            return $this->setResponse(false, $e->getMessage(), 500);
        }
    }

    public function startDelivery(Request $request)
    {
        // return json_encode($request->all());
        try {
            $order = Order::find($request->id);

            if (empty($order))
                return $this->setResponse(false, 'Order not found', 404);

            if (!empty($request->product_id)) {
                foreach ($request->product_id as $key => $p) {
                    $delivery = new OrderDelivery();
                    $delivery->order_id = $request->id;
                    $delivery->product_id = $request->product_id[$key];
                    $delivery->quantity = $request->quantity[$key];
                    $delivery->save();
                }

                $order->order_status = $request->status;
                $order->save();

                return redirect()->back()->with('msg', 'Order updated successfully');
            }
        } catch (Exception $e) {
            return $this->setResponse(false, $e->getMessage(), 500);
        }
    }

    public function getWarehouses($id) {

        try {
            $order = Order::find($id);
            $orderCity = $order->shipping_details['city'];
            $warehouses = Warehouse::where('city',$orderCity)->pluck('_id','store_name');
            return response()->json($warehouses);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }
}
