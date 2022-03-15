<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientDocument extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'client_documents';

    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [
        'client_id' => 'integer',
    ];


    /**
     * Get all of the owning commentable models.
     */
    public function documentable()
    {
        return $this->morphTo('source');
    }


    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class)->withDefault();
    }

    public function documents(): BelongsTo
    {
        return $this->belongsTo(Invoice::class)->withDefault();
    }
}
