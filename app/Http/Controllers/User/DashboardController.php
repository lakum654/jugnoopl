<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Po;
use App\Models\SupplierProduct;
use App\Models\User;
use App\Models\User\WarehouseChallan;
use App\Models\Warehouse;
use App\Models\WarehouseChallan as ModelsWarehouseChallan;
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
        return view('user.dashboard', $data);
    }


    public function warehouseUserOrders() {
        $data['orders'] = [];
        $data['uncompletedOrders'] = [];
        $data = [];
        if (Auth::user()->role == 'warehouse') {
            foreach (Auth::user()->warehouses as $w) {
                $orders = Order::where('warehouse_id', $w)->orderBy('created', 'desc')->get();
                $uncompleted = Order::where('warehouse_id', $w)->where('status','!=','complete')->orderBy('created', 'desc')->get();
                foreach ($orders as $o) {
                    $data['orders'][] = $o;
                }

                foreach($uncompleted as $u) {
                    $data['uncompletedOrders'][] = $u;
                }
            }
        }

    return view('user.order.index',$data);
    }

    public function challan_index() {
        $data['challan_list'] = ModelsWarehouseChallan::where('warehouse_user_id',auth()->user()->_id)->get();
        return view('user.order.challan_index',$data);
    }

    public function saveChallan(Request $request) {
        $inputs = $request->all();
        $inputs['orders'] = $inputs['o_ids'];
        unset($inputs['_token']);
        unset($inputs['o_ids']);
        $inputs['warehouse_user_id'] = auth()->user()->_id;
        $data = ModelsWarehouseChallan::create($inputs);
        $last = ModelsWarehouseChallan::count();
        $challan_no = str_pad($last,12,0);
        ModelsWarehouseChallan::find($data->_id)->update(['challan_no' => ($challan_no+1)]);
        // return ModelsWarehouseChallan::first()->warehouse_user;
        if (!$data) {
            return back()->with(['error' => 'Challan Generated Successfully!']);
        }
        return back()->with(['success' => 'Challan Generated Successfully!']);
    }
    public function login2()
    {
        return view('login');
    }
}
