<?php

namespace App;

use App\Models\Client;
use App\Models\ClientDocument;
use App\Models\Lead;
use App\Models\Note;
use App\Models\Task;
use App\Models\User;
use App\Services\Deal\Dealable;
use App\Services\Document\Documentable;
use App\Services\Note\Noteable;
use App\Services\Task\Taskable;
use App\Traits\AgenciesTenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agency extends Model implements Documentable, Taskable, Noteable, Dealable
{
    use SoftDeletes, AgenciesTenantable;

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

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function updateBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(ClientDocument::class, 'source');
    }

    public function getCreateDocumentEndpoint(): string
    {
        return route('documents.store', ['type' => 'agency', 'external_id' => $this->id]);
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

    public function Deals(): MorphMany
    {
        return $this->morphMany(Lead::class, 'origin');
    }

    public function getCreateDealEndpoint(): string
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
        });

        static::updating(function ($agency) { // On create() method call this
            $agency->updated_by = auth()->id();
        });
    }

    public function setRepresentativesAttribute($value)
    {
        $representatives = [];

        foreach ($value as $array_item) {
            if (!is_null($array_item['key'])) {
                $representatives[] = $array_item;
            }
        }

        $this->attributes['representatives'] = json_encode($representatives);
    }

}
