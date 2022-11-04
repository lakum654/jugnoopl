<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class GrnItem extends BaseModel
{
    use HasFactory;

    public function Products()
    {
        return $this->belongsTo('App\Models\Product','_id','GrnItems.product_id');
    }
}
