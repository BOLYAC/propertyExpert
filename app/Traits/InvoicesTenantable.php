<?php

namespace App\Traits;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait InvoicesTenantable
{
    protected static function bootInvoicesTenantable()
    {
        if (auth()->check()) {

            static::creating(function ($model) {
                $model->created_by = auth()->id();
                $model->department_id = auth()->user()->department_id;
            });

            static::updating(function ($model) {
                $model->updated_by = auth()->id();
            });

            if (auth()->user()->hasPermissionTo('simple-user')) {
                static::addGlobalScope('user_id', function (Builder $builder) {
                    $builder->Where('user_id', auth()->id());
                });
            }

            $l[] = json_encode(auth()->id());

            if (auth()->user()->hasPermissionTo('team-manager')) {
                if (auth()->user()->ownedTeams()->count() > 0) {
                    $teamUsers = auth()->user()->ownedTeams;
                    $teams = auth()->user()->allTeams();
                    foreach ($teamUsers as $u) {
                        foreach ($u->users as $ut) {
                            $users[] = $ut->id;
                        }
                    }
                    static::addGlobalScope('team_id', function (Builder $builder) use ($users) {
                        $builder->whereIn('user_id', $users);
                    });
                }
            }

            if (auth()->user()->hasPermissionTo('desk-manager')) {
                $teams = Team::whereIn('id', ['4', '7', '15'])->get();
                foreach ($teams as $u) {
                    foreach ($u->users as $ut) {
                        $users[] = $ut->id;
                    }
                }
                static::addGlobalScope('user_id', function (Builder $builder) use ($users) {
                    $builder->whereIn('user_id', $users)
                        ->orWhereJsonContains('sellers', $users);
                });
            }

            if (auth()->user()->hasPermissionTo('multiple-department')) {
                $teams = Team::whereIn('id', ['5', '4', '7', '15'])->get();
                $users[] = User::whereIn('id', ['5', '15'])->pluck('id');
                foreach ($teams as $u) {
                    foreach ($u->users as $ut) {
                        $users[] .= $ut->id;
                    }
                }
                static::addGlobalScope('user_id', function (Builder $builder) use ($users) {
                    $builder->whereIn('user_id', $users);
                });
            }

            if (auth()->user()->hasPermissionTo('desk-user')) {
                $teams = Team::whereIn('id', ['4', '7', '15'])->get();
                $users[] = User::where('id', '=', '5')->pluck('id');
                foreach ($teams as $u) {
                    foreach ($u->users as $ut) {
                        $users[] .= $ut->id;
                    }
                }
                static::addGlobalScope('user_id', function (Builder $builder) use ($users) {
                    $builder->whereIn('user_id', $users);
                });
            }

            if (auth()->user()->hasRole('Call center HP')) {
                static::addGlobalScope('user_id', function (Builder $builder) {
                    $builder->Where('user_id', auth()->id());
                });
            }

        }
    }
}
