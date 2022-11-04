<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class WpToPo extends BaseModel
{
    use HasFactory;

    public function PoItems()
    {
        return $this->hasOne('App\Models\PoItem', 'po_id', 'po_id');
    }
}
