<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Validation\Supplier\PoValidation;
use App\Models\Po;
use App\Models\PoItem;
use App\Models\PoPrice;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoPriceController extends Controller
{
    public function index()
    {
        $query = PoPrice::query();

        if (role() == 'supplier')
            $query->where('supplier_id', Auth::user()->_id);
        if (role() == 'warehouse')
            $query->whereIn('warehouse_id', Auth::user()->warehouses);

        $data['lists'] = $query->with(['po', 'warehouse'])->get();

        return view('user.po_price', $data);
    }
}
