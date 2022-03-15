<?php

namespace App\Models;

use App\Services\Deal\Dealable;
use App\Services\Document\Documentable;
use App\Services\Note\Noteable;
use App\Services\Task\Taskable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model implements Documentable, Taskable, Noteable, Dealable
{
    use SoftDeletes;

    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'projects' => 'array',
        'representatives' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class)->withDefault();
    }

    /**
     * @return BelongsTo
     */
    public function updateBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function deals(): MorphMany
    {
        return $this->morphMany(Lead::class, 'origin');
    }

    public function getCreateDealEndpoint(): string
    {
        // TODO: Implement getCreateDealEndpoint() method.
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(ClientDocument::class, 'source');
    }

    public function getCreateDocumentEndpoint(): string
    {
        return route('documents.store', ['type' => 'company', 'external_id' => $this->id]);
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
