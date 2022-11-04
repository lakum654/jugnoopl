<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Filters\ProductFilter;
use Illuminate\Database\Eloquent\Builder;

class SupplierProduct extends BaseModel
{
    use HasFactory;

    public function Product()
    {
        return $this->hasOne('App\Models\Product', '_id', 'product_id');
    }

    public function Supplier()
    {
        return $this->hasOne('App\Models\Supplier', '_id', 'supplier_id')->select('store_name');
    }

    public function scopeFilter(Builder $builder, $request)
    {
        return (new ProductFilter($request))->filter($builder);
    }
}
