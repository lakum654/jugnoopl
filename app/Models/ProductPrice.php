<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ProductPrice extends BaseModel
{
    use HasFactory;

    protected $guarded = [];

    public function product() {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function warehouse() {
        return $this->belongsTo(Warehouse::class,'warehouse_id');
    }
}
