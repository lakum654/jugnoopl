<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Po;
use App\Models\PoItem;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class PoController extends Controller
{
    public function index($type = false)
    {
        $query = Po::with(['Supplier']);
        switch ($type) {
            case 'requested':
                $query->where('type', 'requested');
                break;
            case 'in-progress':
                $query->where('type', 'in-progress');
                break;
            case 'received':
                $query->where('type', 'received');
                break;
            default:
                break;
        }

        $data['lists'] = $query->paginate(10);

        // return $data['lists'];
        return view('admin.po.index', $data);
    }

    public function create()
    {
        $data['warehouse'] = Warehouse::where('status', 1)->get();
        return view('admin.po.create', $data);
    }

    public function store(Request $request)
    {
        $po = new Po();
        $po->po_no        = $request->po_no;
        $po->warehouse_id = $request->warehouse_id;
        $po->supplier_id  = $request->supplier_id;
        $po->estimated_del_date = $request->estimated_del_date;
        $po->type = 'requested';
        // $po->item_details = $request->item_details;

        if (!$po->save())
            return response(['status' => 'error', 'msg' => 'PO not Created!']);

        /**start item details adding functionality */
        if (!empty($request->item_details)) {
            foreach ($request->item_details as $item) {
                $item = (object)$item;
                if (!empty($item->id)) {
                    $poItem = new PoItem();
                    $poItem->warehouse_id = $request->warehouse_id;
                    $poItem->po_id       = $po->id;
                    $poItem->product_id  = $item->id;
                    $poItem->req_qty     = (int)$item->req_qty;
                    $poItem->pending_qty = (int)$item->req_qty;
                    $poItem->price       = (int)$item->price;
                    $poItem->unit        = $item->unit;
                    $poItem->sku         = $item->sku;
                    $poItem->title       = $item->title;
                    $poItem->save();
                }
            }
        }
        /**end item details adding functionality */

        return response(['status' => 'success', 'msg' => 'PO Created Successfully!']);
    }

    public function show($id) {
        $PO = Po::with(['Supplier','Warehouse','Items'])->find($id);
        return view('admin.po.view', compact('PO'));
    }
}
