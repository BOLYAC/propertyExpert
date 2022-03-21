<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;


class CalenderController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::all();
        return view('calender.index', compact('events'));
    }

    public function calendarEvents(Request $request)
    {

        switch ($request->type) {
            case 'show':
                $eventDetail = Event::findOrFail($request->id);
                return \View::make('calender.event-detail', compact('eventDetail'));
                break;
            default:
                # ...
                break;
        }
    }
}
