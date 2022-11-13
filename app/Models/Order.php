<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Relations\HasMany;

class Order extends BaseModel
{
    use HasFactory;

    public function wearhouse()
    {
        return $this->hasOne(Warehouse::class, '_id', 'warehouse_id');
    }

    public function delivery()
    {
        return $this->hasMany(OrderDelivery::class, 'order_id', '_id');
    }

    public function shopkeeper() {
        return $this->hasOne(User::class,'_id','shokeeper_id');
    }
}
