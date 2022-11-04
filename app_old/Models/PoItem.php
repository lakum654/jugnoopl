<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PoItem extends BaseModel
{
    use HasFactory;

    public function Po()
    {
        return $this->hasOne('App\Models\Po', '_id', 'po_id');
    }
}
