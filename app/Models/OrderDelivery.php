<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDelivery extends BaseModel
{
    use HasFactory;

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', '_id');
    }
}
