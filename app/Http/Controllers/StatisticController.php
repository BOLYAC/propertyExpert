<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Note;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:stats-list', ['only' => ['index']]);
    }

    public function index(Request $request)
    {
        $team = auth()->user()->currentTeam;
        $q = User::query();
        if (auth()->user()->hasRole('Manager')) {
            $q->where('current_team_id', '=', $team->id)->get();
        }

        if ($request->ajax()) {
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

            $actifClients = ['1', '8', '12', '3', '4', '10'];
            $notActif = ['10', '5', '13', '7', '11', '9', '14'];
            $actifClients = is_array($actifClients) ? $actifClients : [$actifClients];
            $notActif = is_array($notActif) ? $notActif : [$notActif];
            $users = $q->withCount([
                'clients',
                'clients as new_clients_count' => function (Builder $query) use ($from, $to, $actifClients) {
                    $query->whereIn('status', $actifClients)
                        ->whereBetween('updated_at', [$from, $to]);
                },
                'clients',
                'clients as new_leads_count' => function (Builder $query) use ($from, $to) {
                    $query->where('type', true)
                        ->whereBetween('updated_at', [$from, $to]);
                },
                'clients as not_interested_clients_count' => function (Builder $query) use ($notActif, $from, $to) {
                    $query->whereIn('status', $notActif)
                        ->whereBetween('updated_at', [$from, $to]);
                },
                'tasks',
                'tasks as archive_tasks_count' => function (Builder $query) use ($from, $to) {
                    $query->archive(true)->whereBetween('date', [$from, $to]);
                },
                'notes',
                'notes as notes_count' => function (Builder $query) use ($from, $to) {
                    $query->whereBetween('date', [$from, $to]);
                },
                'events',
                'events as events_count' => function (Builder $query) use ($from, $to) {
                    $query->whereBetween('event_date', [$from, $to]);
                },
                'invoices',
                'invoices as invoices_count' => function (Builder $query) use ($from, $to) {
                    $query->where('status', '=', 2)
                        ->whereBetween('created_at', [$from, $to]);
                },
            ])->get();
            return Datatables::of($users)
                ->addColumn('details_url', function ($user) {
                    return route('api.report_single_details', $user->id);
                })->make(true);
        }
        return view('statics.reports');
    }

    public function getReportLead(Request $request)
    {
        if (request()->ajax()) {

            if (!empty($request->from_date)) {
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

            $leads = Client::withCount([
                'tasks',
                'tasks as archive_tasks_count' => function (Builder $query) use ($from, $to) {
                    $query->where('archive', true)
                        ->whereBetween('date', [new Carbon($from), new Carbon($to)]);
                },
                'notes',
                'notes as notes_count' => function (Builder $query) use ($from, $to) {
                    $query->whereBetween('date', [new Carbon($from), new Carbon($to)]);
                }
            ])->get();
            return datatables()->of($leads)
                ->make(true);
        }
    }

    public function callsIndex()
    {
        $teams = Team::where('department_id', 3)->get();
        return view('statics.call-reports', compact('teams'));
    }

    public function getCallsData(Request $request)
    {
        $team = auth()->user()->currentTeam;

        $q = User::query();

        $q->where('department_id', '=', 3);

        if (auth()->user()->hasRole('Manager')) {
            $q->where('current_team_id', '=', $team->id);
        }

        if ($request->ajax()) {

            if ($request->get('team')) {
                $q->where('current_team_id', '=', $request->get('team'));
            }

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


            $users = $q->withCount([
                'tasks as new_upcoming' => function (Builder $query) use ($from, $to) {
                    $query->where('task_entry', '=', 'inbound')
                        ->whereBetween('created_at', [$from, $to]);
                },
                'tasks as new_outgoing' => function (Builder $query) use ($from, $to) {
                    $query->where('task_entry', '=', 'outbound')
                        ->whereBetween('created_at', [$from, $to]);
                },
            ])->get();
            return Datatables::of($users)->make(true);
        }
    }
}
