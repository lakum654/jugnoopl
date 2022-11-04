<?php

namespace App\Http\Controllers\User\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\grn;
use App\Models\GrnItem;
use App\Models\Po;
use App\Models\PoItem;
use App\Models\WarehouseProduct;
use App\Models\WpToPo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GRNController extends Controller
{
    public function index($type = false)
    {
        $query = grn::query();
        // $data['lists'] = $query->whereIn('warehouse_id', Auth::user()->warehouses)->get();
        $data['lists'] = $query->get();

        return view('user.warehouse.grn.index', $data);
    }

    public function store(Request $request)
    {
        $grn = new grn();
        $grn->user_id          = Auth::user()->_id;
        // $grn->warehouse_id     = $request->warehouse_id;
        // $grn->supplier_id      = $request->supplier_id;
        $grn->grn_no           = 'GRN' . rand(1111, 9999);
        // $grn->po_id            = $request->po_id;
        $grn->po_ids           = $request->po_ids;
        $grn->receiving_date   = strtotime($request->receiving_date);
        $grn->driver_name      = $request->driver_name;
        $grn->driver_mobile    = $request->driver_mobile;
        $grn->vehicle_no       = $request->vehicle_no;
        $grn->type_of_supply   = $request->type_of_supply;
        $grn->bill_amount      = (int)$request->bill_amount;
        $grn->received_by      = $request->received_by;
        $grn->remarks          = $request->remarks;
        $grn->status           = 'pending';

        if (!empty($request->file('challen_no')))
            $grn->profile_image  = singleFile($request->file('challen_no'), 'grn');

        if (!$grn->save())
            return response(['status' => 'error', 'msg' => 'GRN not Created']);

        return response(['status' => 'success', 'msg' => 'GRN Created Successfully!']);
    }

    public function GRNPO($id)
    {
        $grn = grn::find($id);
        $data['po_items'] = PoItem::whereIn('po_id', $grn->po_ids)->get();
        $data['grn'] = $grn;

        return view('user.warehouse.grn.poItems', $data);
    }


    //for update po Item
    public function updatePOItem(Request $request)
    {
        $error = [];
        $errorMsg = '';

        foreach ($request->items as $key => $item) {
            $item = (object)$item;
            $poItem = PoItem::select('send_qty')->find($item->po_item_id);

            if ($item->received_qty > $poItem->send_qty) {
                $errorMsg = '<div>*Received Qty should not be greater then sent Qty.</div>';
            }
            $good_bad_qty = ($item->good_qty) + ($item->bad_qty);
            if ($item->received_qty > 0 && ($good_bad_qty != $item->received_qty)) {
                $errorMsg .= '<div>*Good Qty and Bad Qty should be equal to sent Qty.</div>';
            }
            if (!empty($errorMsg))
                $error['received_qty_' . $key] = $errorMsg;
        }

        if (!empty($error))
            return response(['validation' => $error]);

        $res = false;
        $grn_status = false;
        $po_items = [];

        foreach ($request->items as $key => $item) {
            $item = (object)$item;

            $poItem = PoItem::select('*')->find($item->po_item_id);
            $req_qty = 0;
            if (!empty($poItem->req_qty))
                $req_qty = $poItem->req_qty;

            $poItem->pending_qty  = (int)($req_qty - $item->received_qty);
            $poItem->received_qty = (int)$item->received_qty;
            $poItem->good_qty     = (int)$item->good_qty;
            $poItem->bad_qty      = (int)$item->bad_qty;
            $poItem->grn_id       = $request->grn_id;
            $res = $poItem->save();

            if ($poItem->pending_qty <= 0)
                $grn_status = true;

            $po_items[] = $poItem->_id;

            //for inserting warehouse product
            self::warehouseProduct($poItem);
        }

        //update here in grn collection
        $po_ids = [];
        if (!empty($request->grn_id)) {
            $grn = grn::find($request->grn_id);
            $grn->grn_items = $po_items;
            if ($grn_status)
                $grn->status    = 'completed';
            $grn->save();
            $po_ids = $grn->po_ids;
        }

        //here update po status
        foreach ($po_ids as $id) {
            $allGrnItem = PoItem::where('po_id', $id)->where('pending_qty', '!=', 0)->count();
            if ($allGrnItem <= 0) {
                $po = Po::find($id);
                $po->po_status = 'completed';
                $po->type      = 'received';
                $po->save();
            }
        }

        if (!$res)
            return response(['status' => 'error', 'msg' => 'Item not Updated']);

        return response(['status' => 'success', 'msg' => 'Item Updated Successfully!']);
    }


    //for insert record in warehouse_products collection
    private function warehouseProduct($poItem)
    {
        $wProduct = WarehouseProduct::where('sku', $poItem->sku)->first();
        if (!empty($wProduct)) {
            $po_item_ids = $wProduct->po_item_ids;
            $po_item_ids[] = $poItem->_id;
            $po_ids = $wProduct->po_ids;
            $po_ids[] = $poItem->po_id;

            $good_qty = $wProduct->good_qty + (int)$poItem->good_qty;
            $bad_qty  = $wProduct->bad_qty + (int)$poItem->bad_qty;
            $total_qty = $wProduct->total_qty + (int)$poItem->good_qty;

            $wProduct->po_item_ids = $po_item_ids;
            $wProduct->po_ids      = $po_ids;

            // $wProduct->product_id  = $poItem->product_id;
            // $wProduct->title      = $poItem->title;

            $wProduct->good_qty   = (int)$good_qty;
            $wProduct->bad_qty    = (int)$bad_qty;
            $wProduct->total_qty  = (int)$total_qty;
            $wProduct->save();
        } else {
            $wProduct = new WarehouseProduct();
            $wProduct->po_item_ids = [$poItem->_id];
            $wProduct->po_ids      = [$poItem->po_id];
            $wProduct->product_id  = $poItem->product_id;
            // $wProduct->po_price = $poItem->price;
            $wProduct->unit        = $poItem->unit;
            $wProduct->sku         = $poItem->sku;
            $wProduct->title       = $poItem->title;
            $wProduct->good_qty    = (int)$poItem->good_qty;
            $wProduct->bad_qty     = (int)$poItem->bad_qty;
            $wProduct->total_qty   = (int)$poItem->good_qty;
            $wProduct->user_id     = Auth::user()->_id;
            $wProduct->save();
        }

        self::warehosueProductToPo($poItem->po_id, $wProduct->_id);
    }

    private function warehosueProductToPo($po_id, $product_id)
    {
        $wpToPo = new WpToPo();
        $wpToPo->po_id = $po_id;
        $wpToPo->product_id = $product_id;
        $wpToPo->save();
    }
}
