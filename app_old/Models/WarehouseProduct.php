<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class WarehouseProduct extends BaseModel
{
    use HasFactory;

    public function WpToPo()
    {
        return $this->hasMany('App\Models\WpToPo', 'product_id','_id');
    }

    public function Product(){

        return $this->hasOne('App\Models\Product','_id','product_id');
    }
}
