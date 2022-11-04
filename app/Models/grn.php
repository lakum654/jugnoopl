<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Relations\HasMany;

class grn extends BaseModel
{
    use HasFactory;


    public function GrnItems()
    {
        return $this->HasMany('App\Models\GrnItem', 'grn_id', '_id');
    }

    public function poItems()
    {
        return $this->HasMany('App\Models\PoItem', 'po_id', 'po_id');
    }
}
