<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;


    protected static function boot()
    {
        parent::boot();

        self::observe(\App\Observers\AttachTimeStamp::class);
    }

    public function scopeDesc($query)
    {

        return $query->orderBy('created', 'DESC');
    }

    public function dFormat($date)
    {
        if (empty($date))
            return false;

        return date('d M Y', $date);
    }

    public function isActive($status)
    {

        return ($status) ? 'Active' : 'Inactive';
    }
}
