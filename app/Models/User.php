<?php

namespace App\Models;

use App\Membership;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use Notifiable, HasRoles, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'external_id', 'image_path', 'department_id', 'phone_1', 'phone_2', 'commission_rate', 'departments_ids'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'departments_ids' => 'array'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class)->withDefault();
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    /*public function department()
    {
        return $this->belongsToMany(Department::class);
    }*/

    public function SharedLeads(): BelongsToMany
    {

        return $this->belongsToMany(Lead::class, Membership::class)
            ->withPivot('user_name', 'added_by')
            ->withTimestamps()
            ->as('sharedLeads');
    }

    public function SharedEvents(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, EventUser::class)
            ->withPivot('user_name', 'added_by')
            ->withTimestamps()
            ->as('sharedEvents');
    }

    public function Sharedclients(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, SharedClient::class)
            ->withPivot('user_name', 'added_by')
            ->withTimestamps()
            ->as('sharedClients');
    }


    public function child(): HasMany
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Lead::class, 'user_id');
    }

    public function ownedDepartments()
    {
        return $this->belongsToMany(Department::class);
    }

    /**
     * Determine if the given team is the current team.
     *
     * @param mixed $team
     * @return bool
     */
    public function isCurrentTeam($team): bool
    {
        return $team->id === $this->currentTeam->id;
    }

    /**
     * Get the current team of the user's context.
     */
    public function currentTeam(): BelongsTo
    {
        if (is_null($this->current_team_id) && $this->id) {
            $this->switchTeam($this->personalTeam());
        }

        return $this->belongsTo(Team::class, 'current_team_id');
    }

    /**
     * Switch the user's context to the given team.
     *
     * @param $team
     * @return bool
     */
    public function switchTeam($team): bool
    {
        if (!$this->belongsToTeam($team)) {
            return false;
        }

        $this->forceFill([
            'current_team_id' => $team->id,
        ])->save();

        $this->setRelation('currentTeam', $team);

        return true;
    }


    /**
     * Get all of the teams the user owns or belongs to.
     *
     * @return Collection
     */
    public function allTeams(): Collection
    {
        return $this->ownedTeams->merge($this->teams)->sortBy('name');
    }

    /**
     * Get all of the teams the user owns.
     */
    public function ownedTeams()
    {
        return $this->hasMany(Team::class);
    }

    public function ownedTeam()
    {
        return $this->belongsTo(Team::class, 'current_team_id')->withDefault();
    }

    /**
     * Get all of the teams the user belongs to.
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, Membership::class)
            ->withTimestamps()
            ->as('membership');
    }

    /**
     * Get the user's "personal" team.
     *
     * @return Team
     */
    public function personalTeam()
    {
        return $this->ownedTeams->where('personal_team', true)->first();
    }

    /**
     * Determine if the user owns the given team.
     *
     * @param mixed $team
     * @return bool
     */
    public function ownsTeam($team)
    {
        return $this->id == $team->user_id;
    }

    /**
     * Determine if the user belongs to the given team.
     *
     * @param mixed $team
     * @return bool
     */
    public function belongsToTeam($team)
    {
        return $this->teams->contains(function ($t) use ($team) {
                return $t->id === $team->id;
            }) || $this->ownsTeam($team);
    }

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public function getNameAndDepartmentAttribute()
    {
        //dd($this->name, $this->department()->toSql(), $this->department()->getBindings());
        return $this->name . ' ' . '(' . $this->department()->name . ')';
    }


    public function getNameAndDepartmentEagerLoadingAttribute()
    {
        //dd($this->name, $this->department()->toSql(), $this->department()->getBindings());
        return $this->name . ' ' . '(' . $this->relations['department']->name . ')';
    }

    public function moveTasks($user_id, $department_id, $team_id)
    {
        $tasks = $this->tasks()->get();
        foreach ($tasks as $task) {
            $task->user_id = $user_id;
            $task->department_id = $department_id;
            $task->team_id = $team_id;
            $task->save();
        }
    }

    public function moveLeads($user_id, $department_id, $team_id)
    {
        $leads = $this->leads()->get();
        foreach ($leads as $lead) {
            $lead->user_assigned_id = $user_id;
            $lead->department_id = $department_id;
            $lead->team_id = $team_id;
            $lead->save();
        }
    }

    public function moveClients($user_id, $department_id, $team_id)
    {
        $clients = $this->clients()->get();
        foreach ($clients as $client) {
            $client->user_id = $user_id;
            $client->department_id = $department_id;
            $client->team_id = $team_id;
            $client->save();
        }
    }
}
