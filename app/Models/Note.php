<?php

namespace App\Models;

use App\Agency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Note extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['client'];

    protected $fillable = [
        'body', 'favorite', 'date', 'user_id', 'client_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
        'favorite' => 'boolean'
    ];

    private $tableName = "Note";

    public function getTableName()
    {
        return $this->tableName;
    }

    public function scopeFavorite($query, $value)
    {
        return $query->where('favorite', $value);
    }

    /**
     * Get all of the owning notes models.
     */
    public function noteable(): MorphTo
    {
        return $this->morphTo('source');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'agency_id')->withDefault();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($note) { // On create() method call this
            $note->team_id = auth()->user()->currentTeam->id ?? '1';
        });
    }
}
