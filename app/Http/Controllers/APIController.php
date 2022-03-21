<?php

namespace App\Http\Controllers;

use App\Agency;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Source;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Carbon\Carbon;
use phpseclib3\System\SSH\Agent;

class APIController extends Controller
{
    public function getRowDetailsData()
    {
        $customers = Client::select(['id', 'full_name', 'client_email', 'created_at', 'updated_at']);

        return Datatables::of($customers)->make(true);
    }

    public function getMasterDetailsData(Request $request)
    {
        $customers = Client::with(['source', 'user'])->select();
        if ($request->get('user')) {
            $customers->where('user_id', '=', $request->get('user'));
        }
        if ($request->get('source')) {
            $customers->where('source_id', '=', $request->get('source'));
        }
        if ($request->get('status')) {
            $customers->where('status', '=', $request->get('status'));
        }
        if ($request->get('priority')) {
            $customers->where('priority', '=', $request->get('priority'));
        }
        if ($request->get('phone')) {
            $customers->Where('client_number', 'LIKE', '%' . $request->get('phone') . '%')
                ->orWhere('client_number_2', 'LIKE', '%' . $request->get('phone') . '%');
        }
        if ($request->get('country')) {
            $customers->Where('country', 'LIKE', '%' . $request->get('country') . '%');
        }

        return Datatables::of($customers)
            ->addColumn('details_url', function ($customer) {
                return route('api.master_single_details', $customer->id);
            })
            ->editColumn('public_id', function ($customer) {
                return '<a href="clients/' . $customer->id . '/edit">' . $customer->public_id . '</a>';
            })
            ->addColumn('details', '<span>Send Quota</span><p class="text-danger">{{ $client_email }}</p><p class="text-danger">{{ $client_number }}<br>{{ $client_number_2 }}</p><span>Originate Country</span><p class="text-bold"><b>{{ $country }}</b></p>')
            ->addColumn('details_2', '
      <div class="row mb-4">
        <div class="col">
          <p>{{ $full_name }}</p>
        </div>
        <div class="col">
          <a href="{{ route(\'clients.edit\', $id) }}" class="btn btn-primary btn-sm">Sales
            details
          </a>
        </div>
      </div>
      <div>
        <a class="btn btn-sm btn-default" style="color:black" href="#">
          Show/Hide
        </a>
        <a class="btn btn-sm btn-danger" href="#">
          Reallocate
        </a>
        <a class="btn btn-sm btn-warning" href="#" style="color:black">
          To Cameron
        </a>
      </div>
      <div class="row mt-2">
        <div class="col-2">
          <a class="btn btn-sm btn-danger" href="#" role="button">
            Junk
          </a>
        </div>
        <div class="col-2">
          <label>
            <input type="checkbox" class="p-0 m-0" name="call-{{ $id }}"{{ $called ? \'checked\' : null }}>Called
          </label>
        </div>
        <div class="col-2">
          <label>
            <input type="checkbox" class="p-0 m-0" name="speak-{{ $id }}"{{ $spoken ? \'checked\' : null }}>Spoken
          </label>
        </div>
      </div>')
            ->addColumn('status', '
                          <div class="form-group form-group-sm">
                          <label for="budget">Status</label>
                            <select name="status-{{ $id }}" class="form-control form-control-sm">
                              <option value="0" selected disabled> -- Client status
                                --
                              </option>
                              <option value="1" {{ $status == \'1\' ? \'selected\' : \'\' }}>
                                New Lead
                              </option>
                              <option value="2" {{ $status == \'2\' ? \'selected\' : \'\' }}>
                                In contact
                              </option>
                              <option value="3" {{ $status == \'3\' ? \'selected\' : \'\' }}>
                                Potential
                                appointment
                              </option>
                              <option value="4" {{ $status == \'4\' ? \'selected\' : \'\' }}>
                                Appointment
                                set
                              </option>
                              <option value="5" {{ $status == \'5\' ? \'selected\' : \'\' }}>
                                Sold
                              </option>
                              <option value="6" {{ $status == \'6\' ? \'selected\' : \'\' }}>
                                Sleeping
                                Client
                              </option>
                              <option value="7" {{ $status == \'7\' ? \'selected\' : \'\' }}>
                                Not interested
                              </option>
                              <option value="8" {{ $status == \'8\' ? \'selected\' : \'\' }}>
                                No Answer
                              </option>
                              <option value="9" {{ $status == \'9\' ? \'selected\' : \'\' }}>
                                Wrong Number
                              </option>
                            </select>
                          </div>
                          <div class="form-group form-group-sm">
                            <label for="budget">Budget</label>
                            <select name="budget-{{ $id }}" class="form-control form-control-sm">
                              <option value="0" selected disabled> Select budget
                              </option>
                              <option value="1" {{ $budget == \'1\' ? \'selected\' : \'\' }}>
                                Less then
                                50K
                              </option>
                              <option value="2" {{ $budget == \'2\' ? \'selected\' : \'\' }}>
                                50K <> 100K
                              </option>
                              <option value="3" {{ $budget == \'3\' ? \'selected\' : \'\' }}>
                                100K <>
                                  150K
                              </option>
                              <option value="4" {{ $budget == \'4\' ? \'selected\' : \'\' }}>
                                150K <>
                                  200K
                              </option>
                              <option value="5" {{ $budget == \'5\' ? \'selected\' : \'\' }}>
                                200K <>
                                  300K
                              </option>
                              <option value="6" {{ $budget == \'6\' ? \'selected\' : \'\' }}>
                                300K <>
                                  400k
                              </option>
                              <option value="7" {{ $budget == \'7\' ? \'selected\' : \'\' }}>
                                400k <>
                                  500K
                              </option>
                              <option value="8" {{ $budget == \'8\' ? \'selected\' : \'\' }}>
                                500K <>
                                  600k
                              </option>
                              <option value="9" {{ $budget == \'9\' ? \'selected\' : \'\' }}>
                                600K <> 1M
                              </option>
                              <option value="10" {{ $budget == \'10\' ? \'selected\' : \'\' }}>
                                1M <> 2M
                              </option>
                              <option value="11" {{ $budget == \'11\' ? \'selected\' : \'\' }}>
                                More then
                                2M
                              </option>
                            </select>
                          </div>'
            )
            ->addColumn('calls',
                '
      <div class="form-group form-group-sm">
        <label>Next Call</label>
        <input type="datetime-local" name="next_call-{{ $id }}"
          class="form-control form-control-sm"
          value="{{ $next_call ? Carbon\Carbon::parse($next_call)->format(\'Y-m-d\TH:i\') : null }}"
          placeholder="">
      </div>
      <p>
        <b>Created at:</b>
        <br>
        <span
          style="font:bold;">{{ Carbon\Carbon::parse($created_at)->format(\'Y-m-d H:i\') }}</span>
      </p>
      '
            )
            ->addColumn('assigne', function ($customer) {
                $u = '<span class="badge badge-success">' . optional($customer->user)->name . '</span>';
                $result =
                    '<div class="form-group form-group-sm">
        <label for="priority">Priority</label>
        <select name="priority-' . $customer->id . '" class="form-control form-control-sm">
          <option value="0" selected disabled> Priority
          </option>
          <option value="1"' . ($customer->priority == '1' ? 'selected' : '') . '>
            Low
          </option>
          <option value="2"' . ($customer->priority == '2' ? 'selected' : '') . '>
            Medium
          </option>
          <option value="3"' . ($customer->priority == '3' ? 'selected' : '') . '>
            High
          </option>
        </select>
      </div>
      <div>
      <span class="badge badge-success">' . $u . '</span> <a href="#" class="assign"><i class="icofont icofont-plus f-w-600"></i></a>
      </div>
      <div class="form-group mt-2">
        <label>
          <input type="checkbox" class="form-control form-control-sm mass-check" name="update[]" value="' . $customer->id . '"
            autocomplete="off">
          Apply changes
        </label>
      </div>';
                return $result;
            })
            ->rawColumns(['details', 'details_2', 'status', 'calls', 'assigne', 'public_id'])
            ->make(true);
    }

    public function getMasterDetailsSingleData($id)
    {
        $notes = Client::findOrFail($id)->notes;
        $tasks = Client::findOrFail($id)->tasks;

        $all = $notes->merge($tasks);

        return Datatables::of($all)
            ->editColumn('body', '{!! $body !!}')
            ->editColumn('tableName', function ($all) {
                return '<span class="badge badge-primary">' . $all->getTable() . '</span>';
            })
            ->addColumn(
                'user_id',
                function ($all) {
                    return '<span class="badge badge-success">' . optional($all->user)->name . '</span>';
                }
            )
            ->editColumn('created_at', function ($customer) {
                return $customer->date->format('Y/m/d');
            })
            ->rawColumns(['body', 'user_id', 'tableName'])
            ->make(true);
    }

    public function getRowAttributesData()
    {
        $customers = Client::select(['id', 'full_name', 'email', 'created_at', 'updated_at']);

        return Datatables::of($customers)
            ->addColumn('action', function ($customer) {
                return '<a href="#edit-' . $customer->id . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            })
            ->editColumn('id', '{{$id}}')
            ->removeColumn('updated_at')
            ->setRowId('id')
            ->setRowClass(function ($user) {
                return $user->id % 2 == 0 ? 'alert-success' : 'alert-warning';
            })
            ->setRowData([
                'id' => 'test',
            ])
            ->setRowAttr([
                'color' => 'red',
            ])
            ->make(true);
    }

    public function getSalesPerformance(Request $request)
    {
        $users = User::withCount([
            'clients',
            'clients as calls_count' => function (Builder $query) {
                $query->where('spoken', true);
            },
            'clients as spoken_count' => function (Builder $query) {
                $query->where('called', true);
            },
        ])->get();
        return datatables()->of($users)->make(true);
    }

    public function getReportDetailsData(Request $request)
    {
        $team = auth('api')->user()->currentTeam;
        $q = User::query();
        if (auth('api')->user()->hasRole('Manager')) {
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
            $users = $q->withCount([
                'leads',
                'leads as new_leads_count' => function (Builder $query) use ($from, $to) {
                    $query->where('status', '=', 3)
                        ->whereBetween('created_at', [new Carbon($from), new Carbon($to)]);
                },
                'clients',
                'clients as new_clients_count' => function (Builder $query) {
                    $query->where('type', true);
                },
                'clients as not_interested_clients_count' => function (Builder $query) {
                    $query->where('status', '=', 7);
                },
                'tasks',
                'tasks as archive_tasks_count' => function (Builder $query) use ($from, $to) {
                    $query->archive(true)->whereBetween('date', [new Carbon($from), new Carbon($to)]);
                },
                'notes',
                'notes as notes_count' => function (Builder $query) use ($from, $to) {
                    $query->whereBetween('date', [new Carbon($from), new Carbon($to)]);
                },
                'events',
                'events as events_count' => function (Builder $query) use ($from, $to) {
                    $query->whereBetween('event_date', [new Carbon($from), new Carbon($to)]);
                },
                'invoices',
                'invoices as invoices_count' => function (Builder $query) use ($from, $to) {
                    $query->where('status', '=', 2)
                        ->whereBetween('created_at', [new Carbon($from), new Carbon($to)]);
                },
            ])->get();
            return datatables()->of($users)->make(true);
        }
        return view('statics.index');
    }

    public function getReportDetailsSingleData(Request $request, $id)
    {
        $from = $request->from_date;
        $to = $request->to_date;
        $from = Carbon::parse($from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00

        $to = Carbon::parse($to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59

        $tasks = User::findOrFail($id)
            ->tasks()
            ->archive(true)
            ->whereBetween('date', [new Carbon($from), new Carbon($to)])
            ->get();

        return Datatables::of($tasks)
            ->editColumn('full_name', function ($task) {
                return '<a href="clients/' . $task->client->id . '/edit">' . $task->client->full_name ?? '' . '</a>';
            })->editColumn('date', function ($task) {
                return $task->date->format('Y-m-d');
            })
            ->rawColumns(['full_name'])
            ->make(true);
    }

    public function getAgencyDetailsSingleData($id)
    {
        $clients = Agency::findOrFail($id)->clients;

        return Datatables::of($clients)
            ->editColumn('public_id', function ($client) {
                return $client->public_id ?? '';
            })
            ->editColumn('full_name', function ($client) {
                return '<a href="clients/' . $client->id . '/edit">' . $client->full_name ?? '' . '</a>';
            })
            ->editColumn(
                'assigned',
                function ($client) {
                    return '<span class="badge badge-success">' . optional($client->user)->name . '</span> <a href="#" class="assign"></a>';
                }
            )
            ->editColumn('type', function ($clients) {
                return $clients->type === true ? '<label class="label label-success">Yes</label>' : '<label class="label label-danger">No</label>';
            })
            ->editColumn(
                'status',
                function ($client) {
                    $i = $client->status;
                    switch ($i) {
                        case 1:
                            return '<span class="badge badge-default badge-sm">New Lead</span>';
                            break;
                        case 8:
                            return '<span class="badge badge-default badge-sm">No Answer</span>';
                            break;
                        case 12:
                            return '<span class="badge badge-default badge-sm">In progress</span>';
                            break;
                        case 3:
                            return '<span class="badge badge-default badge-sm">Potential
                appointment</span>';
                            break;
                        case 4:
                            return '<span class="badge badge-default badge-sm">Appointment
                set</span>';
                            break;
                        case 10:
                            return '<span class="badge badge-default badge-sm">Appointment
                follow up</span>';
                            break;
                        case 5:
                            return '<span class="badge badge-default badge-sm">Sold</span>';
                            break;
                        case 13:
                            return '<span class="badge badge-default badge-sm">Unreachable</span>';
                            break;
                        case 7:
                            return '<span class="badge badge-default badge-sm">Not interested</span>';
                            break;
                        case 11:
                            return '<span class="badge badge-default badge-sm">Low budget</span>';
                            break;
                        case 9:
                            return '<span class="badge badge-default badge-sm">Wrong Number</span>';
                            break;
                        case 14:
                            return '<span class="badge badge-default badge-sm">Unqualified</span>';
                            break;
                    }
                }
            )
            ->editColumn(
                'source_id',
                function ($client) {
                    return optional($client->source)->name;
                }
            )
            ->rawColumns(['full_name', 'assigned', 'type', 'status'])
            ->make(true);
    }

    public function getData(Request $request)
    {
        Log::debug($request->all());
        $payload = $request->all();
        return response()->json(['data' => $payload, 'status' => \Symfony\Component\HttpFoundation\Response::HTTP_OK]);
    }

    public function getSalesPerformanceDashboard(Request $request)
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


        $users = User::withCount([
            'tasks as tasks_made' => function (Builder $query) use ($from, $to) {
                $query->whereBetween('created_at', [$from, $to]);
            },
            'tasks as tasks_done' => function (Builder $query) use ($from, $to) {
                $query
                    ->whereBetween('created_at', [$from, $to])
                    ->where('archive', true);
            },
            'notes as notes_made' => function (Builder $query) use ($from, $to) {
                $query
                    ->whereBetween('created_at', [$from, $to]);
            },
        ])->get();

        return datatables()->of($users)->make(true);
    }
}

