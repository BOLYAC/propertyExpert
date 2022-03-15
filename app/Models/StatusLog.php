<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'status_logs';

    public function leads()
    {
        return $this->hasMany(Client::class);
    }
}
