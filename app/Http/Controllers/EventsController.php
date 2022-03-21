<?php

namespace App\Http\Controllers;

use App\Agency;
use App\Mail\SendCreateEventMail;
use App\Models\Client;
use App\Models\Department;
use App\Models\Event;
use App\Models\Lead;
use App\Models\Source;
use App\Models\Team;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\Facades\DataTables;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|View
     */
    public function index(Request $request)
    {
        if ($request->has('today-event')) {
            $events = Event::whereDate('event_date', Carbon::today())->orderBy('event_date', 'desc')->get();
        } else {
            $events = Event::orderBy('event_date', 'desc')->get();
        }
        if (\auth()->user()->hasRole('Admin')) {
            $users = User::all();
            $teams = Team::all();
            $departments = Department::all();
            return view('events.index', compact('events', 'departments', 'teams', 'users'));
        } elseif (\auth()->user()->hasRole('Call center HP')) {
            $teamsId = auth()->user()->ownedTeams->pluck('id');
            $teams = auth()->user()->ownedTeams;
            $users = User::with(['roles', 'teams'])->whereIn('current_team_id', $teamsId)->get();
            $sellsRep = User::all();
            return view('events.index', compact('users', 'sellsRep', 'teams'));
        } elseif (\auth()->user()->hasPermissionTo('team-manager')) {
            if (auth()->user()->ownedTeams()->count() > 0) {
                $teamUsers = auth()->user()->ownedTeams;
                $teams = auth()->user()->allTeams();
                foreach ($teamUsers as $u) {
                    foreach ($u->users as $ut) {
                        $users[] = $ut;
                    }
                }
            }
            return view('events.index', compact('events', 'users', 'teams'));
        } else {
            $users = User::all();
            $teams = Team::all();
            return view('events.index', compact('events', 'users', 'teams'));
        }
    }

    /**
     * Make json response for datatable
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function anyData(Request $request)
    {

        if (\auth()->user()->hasRole('Call center HP')) {
            $users2 = [];
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
            $events = $events1->unionAll($events2);

        } else {

            $events = Event::with(['client', 'user']);

        }

        if ($request->get('user')) {

            $events->where('user_id', '=', $request->get('user'))
                ->orWhereJsonContains('sellers', $request->input('user'));

        }
        if ($request->userRep) {
            $l = json_encode($request->userRep);
            $events->whereJsonContains('sellers', $l);
        }

        if ($request->get('department')) {
            $events->where('department_id', '=', $request->get('department'));
        }
        if ($request->get('team')) {
            $events->where('team_id', '=', $request->get('team'));
        }
        if ($request->confirmed === 'true') {
            $events->where('confirmed', '=', 1);
        }

        switch ($request->get('val')) {
            case 'event-date':
                $events->where('zoom_meeting', false);
                break;
            case 'zoom-meeting':
                $events->where('zoom_meeting', true);
                break;
        }

        if ($request->get('daterange')) {
            $date = explode('-', $request->get('daterange'));
            $from = $date[0];
            $to = $date[1];

            $from = \Carbon\Carbon::parse($from)
                ->startOfDay()        // 2018-09-29 00:00:00.000000
                ->toDateTimeString(); // 2018-09-29 00:00:00

            $to = Carbon::parse($to)
                ->endOfDay()          // 2018-09-29 23:59:59.000000
                ->toDateTimeString(); // 2018-09-29 23:59:59

            $events->whereBetween('event_date', [$from, $to]);
        }


        return Datatables::of($events)
            ->setRowId('id')
            ->editColumn('name', function ($events) {
                return '<a href="' . route('events.show', $events) . '">' . ($events->name ?? '') . '</a>';
            })
            ->editColumn('lead_name', function ($events) {
                return $events->lead_name ?? $events->client->full_name;
            })
            ->editColumn('event_date', function ($events) {
                return Carbon::parse($events->event_date)->format('Y-m-d H:i');
            })
            ->editColumn('place', function ($events) {
                return $events->place ?? '';
            })
            ->addColumn('user', function ($events) {
                return '<span class="badge badge-success">' . optional($events->user)->name . '</span>';
            })
            ->editColumn(
                'sells_name',
                function ($events) {
                    $cou = '';
                    $sellRep = collect($events->sells_name)->toArray();
                    foreach ($sellRep as $name) {
                        $cou .= '<span class="badge badge-dark">' . $name . '</span>';
                    }
                    return $cou;
                })
            ->addColumn('confirmed', function ($events) {
                return $events->confirmed === 1 ? '<label class="badge badge-success">Yes</label>' : '<label class="badge badge-danger">No</label>';
            })
            ->addColumn('action', '<a href="{{ route(\'events.show\', $id) }}"
                                               class="m-r-15 text-muted f-18"><i
                                                    class="icofont icofont-eye-alt"></i></a>
                                            <a href="#!"
                                               class="m-r-15 text-muted f-18 delete"><i
                                                    class="icofont icofont-trash"></i></a>')
            ->rawColumns(['user', 'name', 'action', 'confirmed', 'sells_name'])
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|View
     */
    public function create()
    {
        $users = User::all();
        return view('events.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $this->validate($request, [
            'name' => 'required',
            'event_date' => 'required'
        ]);


        $data = $request->except('share_with', 'files');

        $users = $request->get('share_with');

        $adminEmail = User::findOrFail(1);

        if ($request->has('share_with')) {
            $u = User::whereIn('id', $users)->pluck('name');
            $data['sellers'] = $users;
            if (auth()->user()->hasRole('Admin')) {
                $uEmails = User::whereIn('id', $users)->pluck('email');
            }
        }

        //$client = Client::findOrFail($request->get('client_id'));
        $lead = Lead::findOrfail($request->get('lead_id'));
        $user = User::find($request->user_id);
        $team = $user->current_team_id ?? 1;

        $data['created_by'] = Auth::id();
        $data['user_id'] = $request->user_id ?? Auth::id();
        $data['team_id'] = $team;
        $data['owner_name'] = Auth::user()->name;
        $data['country'] = $lead->country ?? $lead->client->country ?? '';
        $data['nationality'] = $lead->nationality ?? $lead->client->nationality ?? '';
        $data['language'] = $lead->language ?? $lead->client->lang ?? '';
        $data['lead_name'] = $lead->lead_name ?? $lead->client->complete_name ?? '';
        $data['lead_number'] = $lead->lead_phone ?? $lead->client->phone_number ?? '';
        $data['lead_email'] = $lead->lead_email ?? $lead->client->client_email ?? '';
        $data['budget_request'] = $lead->budget_request ?? '';
        $data['rooms_request'] = $lead->rooms_request ?? $lead->client->rooms_request ?? '';
        $data['requirement_request'] = $lead->requirements_request ?? $lead->client->requirements_request ?? '';
        $data['lead_lang'] = $lead->language ?? $lead->client->lang ?? '';
        $data['source_id'] = $lead->source_id;
        $data['source_name'] = $lead->source_name;
        $data['agency_name'] = $lead->agency_name ?? '';
        $data['status_id'] = $lead->status_id;
        $data['status_name'] = $lead->status_name;
        $data['priority'] = $lead->priority ?? '';
        $data['lead_description'] = $lead->description ?? '';
        $data['zoom_meeting'] = $request->has('zoom_meeting') ? 1 : 0;
        $data['customer_name'] = $lead->customer_name;
        $data['customer_passport_id'] = $lead->customer_passport_id;
        $data['customer_phone_number'] = $lead->customer_phone_number;
        $data['customer_name'] = $lead->customer_name;
        $data['lead_flags'] = $lead->lead_flags;

        if ($request->has('share_with')) {
            $data['sell_rep'] = $users[0];
            $data['sells_name'] = $u;
        }

        $event = Event::create($data);

        $link = route('events.edit', $event);

        $emailData = [
            'title' => $data['name'],
            'client' => $data['lead_name'],
            'user' => $user->name,
            'date' => $request->get('event_date'),
            'place' => $data['place'],
            'description' => $data['description'],
            'link' => $link
        ];

        $uEmails[] = $adminEmail->email;
        $uEmails[] = auth()->user()->email;

        Mail::to($uEmails)->send(new SendCreateEventMail($emailData));

        if ($request->has('share_with')) {
            $event->SharedEvents()->attach($users, ['added_by' => Auth::id(), 'user_name' => Auth::user()->name]);
        }

        return redirect()->route('events.index')
            ->with('toast_success', __('Event created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param Event $event
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|View
     */
    public
    function show(Event $event)
    {
        $users = User::all();
        //dd($event);
        return \view('events.show', compact('event', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Event $event
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|View
     */
    public
    function edit(Event $event)
    {
        $users = User::all();

        return view('events.edit', compact('event', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Event $event
     */
    public function update(Request $request, Event $event)
    {

        if ($request->has('share_with')) {
            $users = $request->get('share_with');
            $u = User::whereIn('id', $users)->pluck('name');
        }

        if ($request->has('user_id')) {
            $user = User::find($request->user_id);
        } else {
            $user = User::find($event->user_id);
        }

        $team = $user->current_team_id ?? 1;

        $data = $request->except('share_with', 'files');

        $data['user_id'] = $user->id;
        $data['team_id'] = $team;
        $data['owner_name'] = $user->name;
        $data['zoom_meeting'] = $request->has('zoom_meeting') ? 1 : 0;

        if ($request->has('share_with')) {
            $data['sellers'] = $users;
            $data['sell_rep'] = $users[0];
            $data['sells_name'] = $u;
        }

        $event->update($data);

        $lead = Lead::RemoveGroupScope()->findOrfail($event->lead_id);
        if ($request->get('feedback')) {
            $lead->comments()->create([
                'external_id' => Uuid::uuid4()->toString(),
                'description' => $request->get('feedback'),
                'user_id' => $request->user_id ?? Auth::id()
            ]);
        }

        if ($request->has('share_with')) {
            $lead->ShareWithSelles()->detach();
            $lead->ShareWithSelles()->attach($users, ['added_by' => Auth::id(), 'user_name' => Auth::user()->name]);
            $lead->update(['sellers' => $users, 'sells_names' => $u]);
            $event->SharedEvents()->detach();
            $event->SharedEvents()->attach($users, ['added_by' => Auth::id(), 'user_name' => Auth::user()->name]);
        }

        return redirect()->route('events.index')
            ->with('toast_success', __('Event updated successfully'));
    }

    /**
     * @param Event $event
     * @return RedirectResponse
     */
    public
    function replicate(Event $event): RedirectResponse
    {
        $newEvent = $event->replicate();
        $newEvent->created_at = \Carbon\Carbon::now();
        $newEvent->updated_at = \Carbon\Carbon::now();

        $newEvent->save();
        return redirect()->route('events.edit', $newEvent)
            ->with('toast_success', __('Event duplicated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event $event
     * @return RedirectResponse
     * @throws \Exception
     */
    public
    function destroy(Event $event): RedirectResponse
    {
        $event->delete();
        return redirect()->route('events.index')
            ->with('toast_success', __('Event deleted successfully'));
    }

    public
    function dataAjax(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = [];

        $key = $request->get('q');

        if ($key) {
            $data = Client::where(function ($query) use ($key) {
                $query->where('full_name', 'like', '%' . $key . '%')
                    ->orWhere('public_id', 'LIKE', '%' . $key . '%')
                    ->orWhere('client_number', 'LIKE', '%' . $key . '%')
                    ->orWhere('client_email', 'like', '%' . $key . '%')
                    ->orWhere('first_name', 'like', '%' . $key . '%')
                    ->orWhere('last_name', 'like', '%' . $key . '%');
            })->get(['id', 'full_name']);
        }
        return response()->json($data);
    }

    public
    function showReport($val)
    {
        if ($val === 'today') {
            $events = Event::whereDate('event_date', Carbon::today()->toDateString())->get();

            $confirmedEvents = Event::where(function ($query) {
                $query->where('confirmed', '=', '1')
                    ->whereDate('event_date', Carbon::today()->toDateString());
            })->count();

            $notConfirmedEvents = Event::where(function ($query) {
                $query->where('confirmed', '=', '0')
                    ->whereDate('event_date', Carbon::today()->toDateString());
            })->count();
        } elseif ($val === 'tomorrow') {
            $events = Event::whereDate('event_date', Carbon::tomorrow()->toDateString())->get();

            $confirmedEvents = Event::where(function ($query) {
                $query->where('confirmed', '=', '1')
                    ->whereDate('event_date', Carbon::tomorrow()->toDateString());
            })->count();

            $notConfirmedEvents = Event::where(function ($query) {
                $query->where('confirmed', '=', '0')
                    ->whereDate('event_date', Carbon::tomorrow()->toDateString());
            })->count();
        }
        if ($events->isEmpty()) {
            return back()->with('toast_error', __('There is no appointment in this date'))->withInput();
        }

        return view('events.report', compact('events', 'val', 'confirmedEvents', 'notConfirmedEvents'));
    }

    public
    function createReport(Request $request, $val = array())
    {
        if ($val === 'today') {

            $events = Event::whereDate('event_date', Carbon::today()->toDateString())->get();

            $confirmedEvents = Event::where('confirmed', '=', '1', function ($query) {
                $query->whereDate('event_date', Carbon::today()->toDateString());
            })->count();

            $notConfirmedEvents = Event::where('confirmed', '=', '0', function ($query) {
                $query->whereDate('event_date', Carbon::today()->toDateString());
            })->count();

        } elseif ($val === 'tomorrow') {

            $events = Event::whereDate('event_date', Carbon::tomorrow()->toDateString())->get();

            $confirmedEvents = Event::where('confirmed', '=', '1', function ($query) {
                $query->whereDate('event_date', Carbon::tomorrow()->toDateString());
            })->count();

            $notConfirmedEvents = Event::where('confirmed', '=', '0', function ($query) {
                $query->whereDate('event_date', Carbon::tomorrow()->toDateString());
            })->count();

        } else {

            $d = $request->all();
            $t = array_keys($d);
            $p = explode("_", $t[0]);
            $to = $p[0] . ' ' . $p[1];
            $from = $val;
            $events = Event::whereBetween('event_date', [$from, $to])->get();

            $confirmedEvents = Event::where(function ($query) use ($from, $to) {
                $query->where('confirmed', '=', '1')
                    ->whereBetween('event_date', [$from, $to]);
            })->count();

            $notConfirmedEvents = Event::where(function ($query) use ($from, $to) {
                $query->where('confirmed', '=', '0')
                    ->whereBetween('event_date', [$from, $to]);
            })->count();

        }

        if ($events->isEmpty()) {
            return back()->with('toast_error', __('There is no appointment in this date'))->withInput();
        }

        //return view('events.preview',compact('events'));
        $pdf = PDF::loadView('events.preview', compact('events', 'confirmedEvents', 'notConfirmedEvents', 'val'));
        $pdf->setPaper('Tabloid', 'landscape');
        return $pdf->stream('test_pdf.pdf');
    }

    public function customReport(Request $request)
    {
        if (!empty($request->from_date) && !empty($request->to_date)) {
            $from = $request->from_date;
            $to = $request->to_date;
        } else {
            $from = now();
            $to = now();
        }
        $from = Carbon::parse($from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00

        $to = Carbon::parse($to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59

        if (\auth()->user()->hasRole('Call center HP')) {
            $users2 = [];
            $teams2 = Team::where('id', '4')->get();
            foreach ($teams2 as $u) {
                foreach ($u->users as $ut) {
                    $users2[] = $ut->id;
                }
            }
            $events2 = Event::withoutGlobalScope('user_id');
            $events2->where('zoom_meeting', '=', '1')
                ->whereBetween('event_date', [$from, $to])
                ->whereIn('user_id', $users2)
                ->orWhereJsonContains('sellers', $users2);

            $events1 = Event::with(['client', 'user'])->whereBetween('event_date', [$from, $to])->where('team_id', '!=', '4');
            $events = $events1->unionAll($events2)->get();
        } else {
            $events = Event::with(['client', 'user'])->whereBetween('event_date', [$from, $to])->get();
        }

        /*        $confirmedEvents = $events->where('confirmed', '=', '1')->count();
                $notConfirmedEvents = $events->where('confirmed', '=', '0')->count();*/

        /*$confirmedEvents = Event::where(function ($query) use ($from, $to) {
            $query->where('confirmed', '=', '1')
                ->whereBetween('event_date', [$from, $to]);
        })->count();

        $notConfirmedEvents = Event::where(function ($query) use ($from, $to) {
            $query->where('confirmed', '=', '0')
                ->whereBetween('event_date', [$from, $to]);
        })->count();*/

        if (!$events) {
            return back()->with('toast_error', __('There is no appointment in this date'))->withInput();
        }

        $val = [$from, $to];

        return view('events.report', compact('events', 'val'));

        /*$pdf = PDF::loadView('events.preview', compact('events', 'val'));
        $pdf->setPaper('Tabloid', 'landscape');
        return $pdf->stream('test_pdf.pdf');*/
    }

    public function applyConfirmation()
    {
        $event = Event::findOrFail(\request()->get('event_id'));
        $event->update([
            'confirmed' => '1',
            'confirmed_at' => now(),
            'confirmed_by' => Auth::id()
        ]);

        try {
            return json_encode($event, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return back()->withError($e->getMessage())->withInput();
        }

    }
}

