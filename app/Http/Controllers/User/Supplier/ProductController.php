<?php

namespace App\Http\Controllers\User\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $data['lists'] = SupplierProduct::with(['Product', 'Supplier'])->whereIn('supplier_id', Auth::user()->suppliers)->get();

        $data['suppliers'] = Supplier::where('users', 'all', [Auth::user()->_id])->get();

        return view('user.supplier.product.index', $data);
    }
}
