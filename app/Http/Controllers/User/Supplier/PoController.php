<?php

namespace App\Http\Controllers\User\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Validation\Supplier\PoValidation;
use App\Models\Po;
use App\Models\PoItem;
use App\Models\PoPrice;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoController extends Controller
{
    public function index()
    {
        $data['lists'] = Po::with(['Supplier', 'Warehouse'])->whereIn('supplier_id', Auth::user()->suppliers)->paginate(10);
        return view('user..supplier.po.index', $data);
    }

    public function show($id)
    {
        $data['po'] = PO::with(['Supplier', 'Warehouse'])->find($id);
        $data['items'] = PoItem::where('po_id', $id)->get();
        return view('user.supplier.po.po_details', $data);
    }


    public function saveItem(PoValidation $request)
    {

        /** start send qty validation here */
        $validation = [];
        foreach ($request->items as $key => $item) {
            $item = (object)$item;
            $poItem = PoItem::find($item->id);
            if (!empty($item->send_qty) && $poItem->pending_qty < $item->send_qty)
                $validation["items.$key.send_qty"]  = 'Qty Should not be greater then Pendign Qty';
        }

        if (!empty($validation))
            return response(['validation' => $validation]);
        /** end send qty validation here*/

        $res = false;
        $flag = true;
        $total_price = 0;
        foreach ($request->items as $item) {
            $item = (object)$item;
            $poItem = PoItem::find($item->id);
            $send_qty = !empty($item->send_qty) ? (int)$item->send_qty : 0;
            $poItem->send_qty = $send_qty;
            $poItem->pending_qty = (int)($poItem->pending_qty - $send_qty ?? 0);
            $poItem->price_by_supplier = $item->price;
            $poItem->supplier_id = Auth::user()->_id;
            $res = $poItem->save();

            if ($poItem->pending_qty > 0)
                $flag = false;

            $total_price += ($item->price) * ($send_qty);
            $item_ids[] = $poItem->_id;
        }
        if (!$res)
            return response(['status' => 'error', 'msg' => 'Item Quantity not Updated!']);

        /** start po updation functionality */
        $po = PO::find($request->po_id);
        $po->type = 'in-progress';
        $item_status = 'pending';
        if ($flag)
            $item_status = 'complete';

        $po->item_status = $item_status;
        $po->save();
        /** end po updation functionality */

        //for supplier product report
        $poPrice = [
            'total_price' => $total_price,
            'po_id' => $po->_id,
            'item_ids' => $item_ids,
            'warehouse_id' => $po->warehouse_id
        ];
        self::poPrice($poPrice);

        return response(['status' => 'success', 'msg' => 'Item Quantity Updated Successfully!']);
    }


    private function poPrice($poPrice)
    {
        $request = (object)$poPrice;
        $save = new PoPrice();
        $save->supplier_id = Auth::user()->_id;
        $save->po_id        = $request->po_id;
        $save->price        = $request->total_price;
        $save->item_ids     = $request->item_ids;
        $save->warehouse_id = $request->warehouse_id;
        $save->status       = 'pending';

        if ($save->save())
            return true;

        return false;
    }
}
