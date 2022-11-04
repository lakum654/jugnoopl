<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Po extends BaseModel
{
    use HasFactory;

    public function Supplier()
    {
        return $this->hasOne('App\Models\Supplier', '_id', 'supplier_id')->select('store_name');
    }

    public function Warehouse()
    {
        return $this->hasOne('App\Models\Warehouse', '_id', 'warehouse_id')->select('store_name');
    }

    public function Items(){
        return $this->hasMany('App\Models\PoItem','po_id','_id')->select('*');
    }
}
