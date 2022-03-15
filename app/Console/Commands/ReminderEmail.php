<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\User;
use App\Notifications\EventsDailyNotification;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remainder:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily emails to users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /*$users = User::wherehas('sharedEvents')->orWhereHas('events')->wherehas('tasks')->withCount([
            'events as events_count' => function (Builder $query) {
                $query->whereDate('event_date', Carbon::tomorrow());
            },
            'tasks as tasks_count' => function (Builder $query) {
                $query->whereDate('date', Carbon::tomorrow());
            }
        ])->get();*/
        $users = User::withCount([
            'sharedEvents as events_count' => function (Builder $query) {
                $query->whereDate('event_date', Carbon::today());
            },
            'tasks as tasks_count' => function (builder $query) {
                $query->whereDate('date', Carbon::today());
            }
        ])->get();
        //\Illuminate\Support\Facades\Log::info($users->count());

        foreach ($users as $user) {
            if ($user->tasks_count > 0 || $user->events_count > 0) {
                $user->notify(new EventsDailyNotification($user));
                sleep(30);
                //\Illuminate\Support\Facades\Log::info($user);
            }
        }
    }
}
