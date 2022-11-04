<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SubCategory extends BaseModel
{
    use HasFactory;

    public function Category(){

        return $this->hasOne('App\Models\Category','_id','category_id');
    }
}
