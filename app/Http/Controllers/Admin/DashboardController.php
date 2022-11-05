<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Po;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrder = Order::count();
        $totalWarehouse = Warehouse::count();
        $totalPO = Po::count();
        $totalSupplier = Supplier::count();

        return view('admin.dashboard', compact('totalOrder','totalWarehouse','totalPO','totalSupplier'));
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
