<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable =
        [
            'unit_type',
            'flat_type',
            'floor',
            'gross_sqm',
            'net_sqm',
        ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($agency) { // On create() method call this
            $agency->team_id = auth()->user()->currentTeam->id ?? '1';
            $agency->user_id = auth()->id();
            $agency->created_by = auth()->id();
            $agency->updated_by = auth()->id();
            $agency->department_id = auth()->user()->department_id;
        });

        static::updating(function ($agency) { // On create() method call this
            $agency->updated_by = auth()->id();
        });
    }

}
