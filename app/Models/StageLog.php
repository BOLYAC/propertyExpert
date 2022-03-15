<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StageLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'stage_logs';

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
