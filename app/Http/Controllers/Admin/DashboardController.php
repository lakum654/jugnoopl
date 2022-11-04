<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Po;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        $data['orders'] = Order::with(['delivery', 'wearhouse',])->orderBy('created', 'desc')->get();
        $data['warehouses'] = Warehouse::orderBy('creared', 'desc')->limit(10)->get();
        $data['pos'] = Po::with(['Supplier'])->orderBy('created', 'desc')->limit(10)->get();

        // return json_encode($data);

        return view('admin.dashboard', $data);
    }

    public function orderDetail($id)
    {
        $order = Order::with(['delivery'])->find($id);

        return response(['status' => 'success', 'order' => $order]);
    }

    public function warehouseDetail($id)
    {
        $warehouse = Warehouse::find($id);
        return response(['status' => 'success', 'data' => $warehouse]);
    }

    public function poDetail($id)
    {

        $po = Po::with(['Supplier', 'Items'])->find($id);

        return response(['status' => 'success', 'data' => $po]);
    }

    public function login2()
    {
        return view('login');
    }
}
