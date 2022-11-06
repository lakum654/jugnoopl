<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Validation\Supplier\PoValidation;
use App\Models\Po;
use App\Models\PoItem;
use App\Models\PoPrice;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoReportController extends Controller
{
    public function index()
    {
        $query = WarehouseProduct::query();

        $data['lists'] = $query->with(['WpToPo.PoItems.Po'])->paginate(10);

        //  pr($data['lists']);die;
        return view('user.po_report', $data);
    }
}
