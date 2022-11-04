<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WarehouseProduct;

class ProductController extends Controller
{

    public function index()
    {
        $lists = WarehouseProduct::with(['Product.Category','Product.SubCategory'])->get();
        if ($lists->isEmpty())
            return $this->setResponse(false, 'No Record Found', 404);

        $records = [];
        foreach ($lists as $list) {
            $records[] = [
                '_id'        => $list->_id,
                'product_id' => $list->product_id,
                'unit'       => $list->unit,
                'sku'        => $list->sku,
                'title'      => $list->title,
                'good_qty'   => $list->good_qty,
                'bad_qty'    => $list->bad_qty,
                'total_qty'  => $list->total_qty,
                'user_id'    => $list->user_id,
                'price'      => $list->price,
                'image'      => imgPath('product', !empty($list->Product->image)?$list->Product->image:''),

                'category_id'      => !empty($list->product->Category->_id)?$list->product->Category->_id:'',
                'category_name'    =>  !empty($list->product->Category->name)?$list->product->Category->name:'',
                'category_icon'    =>  imgPath('product', !empty($list->product->Category->icon)?$list->product->Category->icon:''),
                'sub_category_id'  => !empty($list->product->SubCategory->_id)?$list->product->SubCategory->_id:'',
                'sub_category_name'=>  !empty($list->product->SubCategory->name)?$list->product->SubCategory->name:'',
                'sub_category_icon'=>  imgPath('product', !empty($list->product->SubCategory->icon)?$list->product->SubCategory->icon:''),

                'created'    => $list->created,
                'updated'    => $list->updated
            ];
        }
        return $this->setResponse(true, $records, 200);
    }
}
