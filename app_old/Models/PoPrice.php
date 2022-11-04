<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PoPrice extends BaseModel
{
    use HasFactory;

    public function po(){
        return $this->hasOne('App\Models\Po','_id','po_id');
    }

    public function warehouse(){
        return $this->hasOne('App\Models\Warehouse','_id','warehouse_id');
    }
}
