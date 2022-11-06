<?php

namespace App\Http\Controllers\User\Shopkeeper;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index($type = false)
    {
        $data['orders'] = Order::orderBy('created', 'desc')->paginate(10);

        return view('user.shopkeeper.order.index', $data);
    }


    public function show($id)
    {
        $order = Order::find($id);
        return response(['status' => 'success', 'order' => $order]);
    }
}
