<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marketing extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $guarded = [];


    public static function boot()
    {
        parent::boot();

        static::creating(function ($agency) { // On create() method call this
            $agency->created_by = auth()->id();
            $agency->updated_by = auth()->id();
        });

        static::updating(function ($agency) { // On create() method call this
            $agency->updated_by = auth()->id();
        });
    }

}
