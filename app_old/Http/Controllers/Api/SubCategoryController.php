<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index()
    {
        $lists = SubCategory::get();

        if ($lists->isEmpty())
            return $this->setResponse(false, 'No Record Found', 404);

        $record = array();
        foreach ($lists as $list) {
            $record[] = [
                '_id'     => $list->_id,
                'category_id' => $list->category_id,
                'name'    => $list->name,
                'status'  => $list->isActive($list->status),
                'icon'    => imgPath('category', $list->icon),
                'created' => $list->created,
                'updated' => $list->updated
            ];
        }

        return $this->setResponse(true, $record, 200);
    }
}
