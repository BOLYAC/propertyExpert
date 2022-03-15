<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SharedLead extends Model
{
    /**
     * The table associated with the pivot model.
     *
     * @var string
     */
    protected $table = 'user_lead';
}
