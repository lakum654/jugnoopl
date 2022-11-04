<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [];
        if (Auth::user()->role == 'warehouse') {
            foreach (Auth::user()->warehouses as $w) {
                $orders = Order::where('warehouse_id', $w)->orderBy('created', 'desc')->get();
                foreach ($orders as $o) {
                    $data['orders'][] = $o;
                }
            }
        }
        return view('user.dashboard', $data);
    }


    public function login2()
    {
        return view('login');
    }
}
