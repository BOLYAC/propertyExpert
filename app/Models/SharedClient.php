<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedClient extends Model
{
    use HasFactory;
    /**
     * The table associated with the pivot model.
     *
     * @var string
     */
    protected $table = 'user_client';
}
