<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;

class CalenderController extends Controller
{
    public function __invoke()
    {
        if (\auth()->user()->hasRole('Call center HP')) {
            $teams2 = Team::where('id', '4')->get();
            foreach ($teams2 as $u) {
                foreach ($u->users as $ut) {
                    $users2[] = $ut->id;
                }
            }
            $events2 = Event::withoutGlobalScope('user_id');
            $events2->where('zoom_meeting', '=', '1')
                ->whereIn('user_id', $users2)
                ->orWhereJsonContains('sellers', $users2);

            $events1 = Event::with(['client', 'user'])->where('team_id', '!=', '4');
            $events = $events1->unionAll($events2)->get();
        } else {
            $events = Event::with(['client', 'user'])->get();
        }
        return view('calender.index', compact('events'));
    }
}
