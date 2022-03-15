<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'description',
        'task_id',
        'user_id',
        'external_id'
    ];
    protected $hidden = ['remember_token'];

    /**
     * Get all of the owning commentable models.
     */
    public function commentable()
    {
        return $this->morphTo('source');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function mentionedUsers()
    {
        preg_match_all('/@([\w\-]+)/', $this->description, $matches);

        return $matches[1];
    }

    // this is a recommended way to declare event handlers

    public static function boot()
    {
        parent::boot();

        static::creating(function ($comment) { // On create() method call this
            $comment->team_id = auth()->user()->teams->first()->id ?? '1';
        });
    }
}

