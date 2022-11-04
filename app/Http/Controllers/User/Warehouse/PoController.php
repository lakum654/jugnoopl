<?php

namespace App\Http\Controllers\User\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\grn;
use App\Models\GrnItem;
use App\Models\Po;
use App\Models\PoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoController extends Controller
{
    public function index($type = false)
    {
        $query = Po::with(['Supplier', 'Warehouse']);
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

        $data['lists'] = $query->whereIn('warehouse_id', Auth::user()->warehouses)->get();

        return view('user.warehouse.po.index', $data);
    }

    public function show($id)
    {
        $data['po']    = PO::with(['Supplier', 'Warehouse'])->find($id);
        $data['items'] = PoItem::where('po_id', $id)->whereNull('grn_id')->get();
        $data['grns']  = grn::with(['GrnItems', 'poItems'])->where('po_id', $id)->get();

        return view('user.warehouse.po.po_details', $data);
    }


    public function viewItem($po_id = false)
    {
        if (!$po_id)
            return response(['status' => 'error', 'msg' => 'Not Found Any Reccord!']);

        $items = PoItem::where('po_id', $po_id)->get();
        $table = '<table class="table">
        <thead>
        <tr>
        <th>#</th>
        <th>Title</th>
        <th>SKU</th>
        <th>Unit</th>
        <th>Requested Qty</th>
        <th>Pending Qty</th>
        <th>Sent Qty</th>
        </tr>
        </thead>';
        foreach ($items as $key => $item) {
            $table .= '<tr>
            <td>' . ++$key . '</td>
            <td>' . $item->title . '</td>
            <td>' . $item->sku . '</td>
            <td>' . $item->unit . '</td>
            <td>' . $item->req_qty . '</td>
            <td>' . $item->pending_qty . '</td>
            <td>' . $item->send_qty . '</td>

            </tr>';
        }

        $table .= '</table>';

        return response(['status' => 'success', 'data' => $table]);
    }

    public function saveItem(Request $request)
    {
        $po = PO::find($request->po_id);
        $po->type = 'received';
        $po->save();

        $res = false;
        foreach ($request->items as $item) {
            $item = (object)$item;
            $poItem = PoItem::find($item->id);
            $poItem->received_qty = (int)$item->received_qty ?? 0;
            $res = $poItem->save();
        }
        if (!$res)
            return response(['status' => 'error', 'msg' => 'Received Quantity not Updated!']);

        return response(['status' => 'success', 'msg' => 'Received Quantity Updated Successfully!']);
    }


    // public function saveGRN(Request $request)
    // {
    //     $grn = new grn();
    //     $grn->user_id          = Auth::user()->_id;
    //     $grn->warehouse_id     = $request->warehouse_id;
    //     $grn->supplier_id      = $request->supplier_id;
    //     $grn->grn_no           = 'GRN' . rand(1111, 9999);
    //     $grn->po_id            = $request->po_id;
    //     $grn->po_no            = $request->po_no;
    //     $grn->receiving_date   = strtotime($request->receiving_date);
    //     $grn->driver_name      = $request->driver_name;
    //     $grn->driver_mobile    = $request->driver_mobile;
    //     $grn->vehicle_no       = $request->vehicle_no;
    //     $grn->type_of_supply   = $request->type_of_supply;
    //     $grn->bill_amount      = (int)$request->bill_amount;
    //     $grn->received_by      = $request->received_by;
    //     $grn->remarks          = $request->remarks;
    //     $grn->status           = 'pending';

    //     if (!empty($request->file('challen_no')))
    //         $grn->profile_image  = singleFile($request->file('challen_no'), 'grn');

    //     if (!$grn->save())
    //         return response(['status' => 'error', 'msg' => 'GRN not Created']);

    //     return response(['status' => 'success', 'msg' => 'GRN Created Successfully!']);
    // }


    // public function saveGRNItem(Request $request)
    // {
    //     $error = [];
    //     $errorMsg = '';

    //     foreach ($request->items as $key => $item) {
    //         $item = (object)$item;
    //         $poItem = PoItem::select('send_qty')->find($item->po_item_id);

    //         if ($item->received_qty > $poItem->send_qty) {
    //             $errorMsg = '<div>*Received Qty should not be greater then sent Qty.</div>';
    //         }
    //         $good_bad_qty = ($item->good_qty) + ($item->bad_qty);
    //         if ($item->received_qty > 0 && ($good_bad_qty != $item->received_qty)) {
    //             $errorMsg .= '<div>*Good Qty and Bad Qty should be equal to sent Qty.</div>';
    //         }
    //         if (!empty($errorMsg))
    //             $error['received_qty_' . $key] = $errorMsg;
    //     }

    //     if (!empty($error))
    //         return response(['validation' => $error]);

    //     $grn_items = [];
    //     $grn_status = 'pending';
    //     foreach ($request->items as $key => $item) {
    //         $item = (object)$item;

    //         $poItem = PoItem::select('req_qty')->find($item->po_item_id);
    //         $req_qty = 0;
    //         if (!empty($poItem->req_qty))
    //             $req_qty = $poItem->req_qty;

    //         $save = new GrnItem();
    //         if (!empty($item->_id))
    //             $save = GrnItem::find($item->_id);

    //         $save->user_id      = Auth::user()->_id;
    //         $save->po_id        = $request->po_id;
    //         $save->grn_id       = $request->grn_id;
    //         $save->po_item_id   = $item->po_item_id;
    //         $save->product_id   = $item->product_id;
    //         $save->received_qty = (int)$item->received_qty;
    //         $save->good_qty     = (int)$item->good_qty;
    //         $save->bad_qty      = (int)$item->bad_qty;
    //         $save->pending_qty  = (int)($req_qty - $item->received_qty);
    //         $res =  $save->save();
    //         $grn_items[] = $save->_id;

    //         if ($save->pending_qty <= 0)
    //             $grn_status = 'completed';

    //         //update grn id in po_items collection
    //         $poItem->grn_id = $save->_id;
    //         $poItem->save();
    //     }

    //     if (!empty($request->grn_id)) {
    //         $grn = grn::find($request->grn_id);
    //         $grn->grn_items = $grn_items;
    //         $grn->status    = $grn_status;
    //         $grn->save();
    //     }

    //     //here update po status
    //     $allGrnItem = grn::where('po_id', $request->po_id)->where('pending_qty', 0)->count();
    //     if ($allGrnItem <= 0) {
    //         $po = Po::find($request->po_id);
    //         $po->po_status = 'completed';
    //         $po->type      = 'received';
    //         $po->save();
    //     }

    //     if (!$res)
    //         return response(['status' => 'error', 'msg' => 'Item not Updated']);

    //     return response(['status' => 'success', 'msg' => 'Item Updated Successfully!']);
    // }
}
