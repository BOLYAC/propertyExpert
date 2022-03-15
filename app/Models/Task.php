<?php

namespace App\Models;

use App\Agency;
use App\Traits\TasksTenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Task extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes, TasksTenantable;


    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['client'];

    protected $fillable = [
        'title',
        'date',
        'user_id',
        'client_id',
        'archive',
        'team_id',
        'task_entry',
        'contact_type',
        'contact_name',
        'agency_id',
        'body',
        'department_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
        'archive' => 'boolean',
        'called' => 'boolean',
        'spoken' => 'boolean'
    ];

    public $tableName = "Task";

    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * Get all of the owning commentable models.
     */
    public function taskable(): MorphTo
    {
        return $this->morphTo('source');
    }

    public function scopeArchive($query, $value)
    {
        return $query->where('archive', $value);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id')->withDefault();
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'agency_id')->withDefault();
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'lead_id')->withDefault();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($task) { // On create() method call this
            $task->team_id = auth()->user()->currentTeam->id ?? '1';
        });
    }
}
