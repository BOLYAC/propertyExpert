<?php

namespace App\Models;

use App\Services\Comment\Commentable;
use App\Traits\DealsTenantable;
use App\Traits\EventsTenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Event extends Model implements Auditable, Commentable

{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes, EventsTenantable;

    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'event_date' => 'datetime:Y-m-d',
        'lang' => 'array',
        'sellers' => 'array',
        'sells_name' => 'array',
        'budget' => 'array',
        'budget_request' => 'array',
        'rooms_request' => 'array',
        'requirement_request' => 'array',
        'country' => 'array',
        'nationality' => 'array',
        'language' => 'array',
        'lead_budget' => 'array',
        'lead_lang' => 'array',
        'zoom_meeting'  => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function EventConfirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by')->withDefault('Not confirmed yet');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id')->withDefault();
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id')->withDefault();
    }

    public function SharedEvents(): BelongsToMany
    {
        return $this->belongsToMany(User::class, EventUser::class)
            ->withPivot('user_name', 'added_by')
            ->withTimestamps()
            ->as('sharedEvents');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($event) { // On create() method call this
            $event->team_id = auth()->user()->currentTeam->id ?? '1';
        });
    }

    public function eventConfirmed(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by')->withDefault();
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'source');
    }

    public function getCreateCommentEndpoint(): string
    {
        return route('comments.create', ['type' => 'event', 'external_id' => $this->id]);
    }
}
