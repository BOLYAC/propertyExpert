<?php

namespace App\Models;

use App\Services\Comment\Commentable;
use App\Services\Note\Noteable;
use App\Services\Task\Taskable;
use App\Traits\DealsTenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Lead extends Model implements Commentable, Taskable, Noteable
{
    use SoftDeletes, DealsTenantable;

    protected $guarded = [];

    protected $dates = ['deadline'];

    protected $casts = [
        'sellers' => 'array',
        'sells_names' => 'array',
        'budget_request' => 'array',
        'rooms_request' => 'array',
        'requirement_request' => 'array',
        'country' => 'array',
        'nationality' => 'array',
        'language' => 'array',
        'title_deed' => 'boolean',
        'expertise_report' => 'boolean'
    ];

    public function scopeRemoveGroupScope($query)
    {
        return $query->withoutGlobalScope('team_id')
            ->withoutGlobalScope('user_id');
    }

    public function displayValue()
    {
        return $this->title;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function stageLog()
    {
        return $this->hasMany(StageLog::class, 'lead_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function events(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'source');
    }

    public function getCreateCommentEndpoint(): string
    {
        return route('comments.create', ['type' => 'lead', 'external_id' => $this->external_id]);
    }

    public function getAssignedUserAttribute()
    {
        return User::findOrFail($this->user_assigned_id);
    }

    public function dealable(): MorphTo
    {
        return $this->morphTo('origin');
    }

    public function ShareWithSelles(): BelongsToMany
    {
        return $this->belongsToMany(User::class, SharedLead::class)
            ->withPivot('user_name', 'added_by')
            ->withTimestamps()
            ->as('sharedLeads');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function convertToOrder()
    {
        if (!$this->canConvertToOrder()) {
            return false;
        }
        $invoice = Invoice::create([
            'status' => 'draft',
            'client_id' => $this->client->id,
            'external_id' => Uuid::uuid4()->toString()
        ]);
        dd($invoice);
        $this->invoice_id = $invoice->id;
        //$this->status_id = Status::typeOfLead()->where('title', 'Closed')->first()->id;
        $this->save();

        return $invoice;
    }

    public function canConvertToOrder()
    {
        if ($this->invoice) {
            return false;
        }
        return true;
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

        static::creating(function ($lead) { // On create() method call this
            $lead->team_id = auth()->user()->currentTeam->id ?? '1';
        });
    }
}
