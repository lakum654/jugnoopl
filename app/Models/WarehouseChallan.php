<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseChallan extends BaseModel
{
    use HasFactory;

    protected $guarded = [];

    public function warehouse_user() {
        return $this->belongsTo(User::class,'warehouse_user_id');
    }
}
