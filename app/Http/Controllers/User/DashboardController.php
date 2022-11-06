<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Po;
use App\Models\SupplierProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $data['orders'] = [];
        $data = [];
        if (Auth::user()->role == 'warehouse') {
            foreach (Auth::user()->warehouses as $w) {
                $orders = Order::where('warehouse_id', $w)->orderBy('created', 'desc')->get();
                foreach ($orders as $o) {
                    $data['orders'][] = $o;
                }
            }
        }



        if(auth()->user()->role == 'supplier') {
            $data['totalSupplierPO'] = Po::with(['Supplier', 'Warehouse'])->whereIn('supplier_id', Auth::user()->suppliers)->count();
            $data['totalSupplierProduct'] = SupplierProduct::with(['Product', 'Supplier'])->whereIn('supplier_id', Auth::user()->suppliers)->count();
        } else {
            $data['totalSupplierPO'] = 0;
            $data['totalSupplierProduct'] = 0;
        }

        $data['orders'] = [];
        return view('user.dashboard', $data);
    }


    public function login2()
    {
        return view('login');
    }
}
