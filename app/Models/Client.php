<?php

namespace App\Models;

use App\Agency;
use App\Services\Deal\Dealable;
use App\Services\Document\Documentable;
use App\Services\Note\Noteable;
use App\Services\Task\Taskable;
use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Client extends Model implements Auditable, Documentable, Noteable, Taskable, Dealable

{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes, Multitenantable;

    //public $timestamps = false;
    //public $timestamps = false;
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'appointment_date' => 'datetime',
        'next_call' => 'datetime',
        'type' => 'boolean',
        'spoken' => 'boolean',
        'called' => 'boolean',
        'lang' => 'array',
        'country' => 'array',
        'nationality' => 'array',
        'budget_request' => 'array',
        'rooms_request' => 'array',
        'requirements_request' => 'array',
        'sellers' => 'array',
        'sells_names' => 'array',
    ];


    public function scopeRemoveGroupScope($query)
    {
        return $query->withoutGlobalScope('team_id')
            ->withoutGlobalScope('user_id');
    }

    public function getCompleteNameAttribute(): string
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    public function StatusLog()
    {
        return $this->hasMany(StatusLog::class, 'client_id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'agency_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function updateBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function createBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class, 'source_id', 'id')->withDefault();
    }


    /**
     * @return HasMany
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * @return HasMany
     */
    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class, 'client_id', 'id')
            ->orderBy('created_at', 'desc');
    }


    /**
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function shareClientWith(): BelongsToMany
    {
        return $this->belongsToMany(User::class, SharedClient::class)
            ->withPivot('user_name', 'added_by')
            ->withTimestamps()
            ->as('sharedClients');
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(ClientDocument::class, 'source');
    }


    public function getCreateDocumentEndpoint(): string
    {
        return route('documents.store', ['type' => 'client', 'external_id' => $this->id]);
    }


    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'source');
    }

    public function getCreateNoteEndpoint(): string
    {
        // TODO: Implement getCreateNoteEndpoint() method.
    }

    public function tasks(): MorphMany
    {
        return $this->morphMany(Task::class, 'source');
    }

    public function getCreateTaskEndpoint(): string
    {
        // TODO: Implement getCreateTaskEndpoint() method.
    }

    // Get column names
    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function Deals(): MorphMany
    {
        return $this->morphMany(Lead::class, 'origin');
    }

    public function getCreateDealEndpoint(): string
    {
        // TODO: Implement getCreateTaskEndpoint() method.
    }

    // this is a recommended way to declare event handlers

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($client) { // before delete() method call this
            $client->tasks()->delete();
            // do the rest of the cleanup...
        });

        static::creating(function ($client) { // On create() method call this
            $client->public_id = strtoupper(substr(uniqid(mt_rand(), true), 16, 6));
            //$client->team_id = auth()->user()->currentTeam->id ?? '1';
        });
    }
}
