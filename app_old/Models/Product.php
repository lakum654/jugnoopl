<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Product extends BaseModel
{
    use HasFactory;

    public function Category()
    {

        return $this->belongsTo('App\Models\Category', 'category_id', '_id');
    }
    public function SubCategory()
    {

        return $this->belongsTo('App\Models\SubCategory', 'sub_category_id');
    }
    public function Brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }

    public function Unit()
    {
        return $this->hasOne('App\Models\Unit','_id','unit_id')->select('_id','unit');
    }



}
