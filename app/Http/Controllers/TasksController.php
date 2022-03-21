<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use JsonException;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    function __construct()
    {
        $this->middleware('permission:task-list|task-create|task-edit|task-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:task-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:task-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:task-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (\auth()->user()->hasRole('Admin')) {
            $users = User::all();
            $teams = Team::all();
            return view('tasks.index', compact('users', 'teams'));
        } elseif (\auth()->user()->hasPermissionTo('team-manager')) {
            if (auth()->user()->ownedTeams()->count() > 0) {
                $users = auth()->user()->currentTeam->allUsers();
                $teams = auth()->user()->allTeams();
            }
            return view('tasks.index', compact('users', 'teams'));
        } elseif (\auth()->user()->hasRole('Call center HP')) {
            $teams = auth()->user()->ownedTeams->pluck('id');
            $users = User::with(['roles', 'teams'])->whereIn('current_team_id', $teams)->get();
            return view('tasks.index', compact('users'));
        } else {
            return view('tasks.index');
        }
    }

    /**
     * Make json respnse for datatables
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function anyData(Request $request)
    {
        $tasks = Task::with(['client', 'user', 'agency', 'lead'])->select(['id', 'date', 'client_id', 'agency_id', 'title', 'user_id', 'archive', 'source_type', 'source_id']);

        if ($request->get('user')) {
            $tasks->where('user_id', '=', $request->get('user'));
        }
        if ($request->get('team')) {
            $tasks->where('team_id', '=', $request->get('team'));
        }
        if ($request->get('stat') == 1) {
            $tasks->archive(true);
        }
        if ($request->get('stat') == 2) {
            $tasks->archive(false);
        }
        if ($request->contact_type) {
            $tasks->where('contact_type', '=', $request->contact_type);
        }

        if ($request->get('val') == 'custom') {
            $date = explode('-', $request->get('daterange'));
            $from = $date[0];
            $to = $date[1];

            $from = \Carbon\Carbon::parse($from)
                ->startOfDay()        // 2018-09-29 00:00:00.000000
                ->toDateTimeString(); // 2018-09-29 00:00:00

            $to = Carbon::parse($to)
                ->endOfDay()          // 2018-09-29 23:59:59.000000
                ->toDateTimeString(); // 2018-09-29 23:59:59

            $tasks->whereBetween('date', [$from, $to]);
        }

        $tasks->OrderByDesc('created_at');

        switch ($request->get('val')) {
            case 'today-tasks':
                $tasks->whereDate('date', Carbon::today());
                break;
            case 'future-tasks':
                $tasks->whereDate('date', '>', Carbon::today());
                break;
            case 'older-tasks':
                $tasks->whereDate('date', '<', Carbon::today());
                break;
            case 'pending-tasks':
                $tasks->archive(false)->whereDate('date', '<', Carbon::today());
                break;
            case 'completed-tasks':
                $tasks->archive(true);
                break;
        }

        return Datatables::of($tasks)
            ->setRowId('id')
            ->addColumn('more_details', function ($tasks) {
                return '<div class="d-inline-block align-middle">' .
                    '<div class="d-inline-block"><h6> ' . ($tasks->title ?? '') . ' </h6>' .
                    '<span class="ml-2 pl-2 f-w-600">Date: ' . optional($tasks->date)->format('d-m-Y') . '</span>' .
                    '</div></div>';
            })
            ->editColumn('client_id', function ($tasks) {
                if ($tasks->source_type === 'App\Models\Lead') {
                    return '<a href="/leads/' . $tasks->source_id . '">' . $tasks->lead->lead_name ?? '' . '</a>';
                }

                return '<a href="/clients/' . $tasks->client_id . '">' . $tasks->client->full_name ?? '' . '</a>';
            })
            ->addColumn('source_type', function ($tasks) {
                $modelsMapping = [
                    'App\Models\Client' => 'Lead',
                    'App\Models\Lead' => 'Deal',
                ];

                if (!array_key_exists($tasks->source_type, $modelsMapping)) {
                    return "Lead";
                }
                return $modelsMapping[$tasks->source_type];
            })
            ->addColumn('country', function ($tasks) {
                if (is_null($tasks->client->country)) {
                    return $tasks->client->getRawOriginal('country') ?? '';
                } else {
                    $cou = '';
                    $countries = collect($tasks->client->country)->toArray();
                    foreach ($countries as $name) {
                        $cou .= '<span class="badge badge-light-primary">' . $name . '</span>';
                    }
                    return $cou;
                }
            })
            ->addColumn('nationality', function ($tasks) {
                if (is_null($tasks->client->nationality)) {
                    return $tasks->client->getRawOriginal('nationality') ?? '';
                } else {
                    $cou = '';
                    $nat = collect($tasks->client->nationality)->toArray();
                    foreach ($nat as $name) {
                        $cou .= '<span class="badge badge-light-primary">' . $name . '</span>';
                    }
                    return $cou;
                }
            })
            ->addColumn('user_id',
                function ($tasks) {
                    return '<span class="badge badge-success">' . optional($tasks->user)->name . '</span> <a href="#" class="assign"><i class="icofont icofont-plus f-w-600"></i></a>';
                })
            ->addColumn('archive', function ($tasks) {
                return $tasks->archive === true ? '<label class="txt-success f-w-600">' . __('Done') . '</label>' : '<label class="txt-danger f-w-600">' . __('Pending') . '</label>';
            })
            ->editColumn('action', function ($tasks) {
                return '<a href="javascript:void(0)" class="m-r-15 text-muted f-18 delete"  data-original-title="View lead"><i class="icofont icofont-trash"></i></a>';
            })
            ->rawColumns(['user_id', 'more_details', 'archive', 'action', 'client_id', 'country', 'nationality'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public
    function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public
    function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();

        Task::create($data);

        return redirect()->back()
            ->with('toast_success', __('Task created successfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Task $task
     * @return Application|Factory|View
     */
    public
    function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Task $task
     * @return Response
     */
    public
    function update(Request $request, Task $task)
    {
        $data = $request->all();
        $task->update($data);

        return redirect()->route('tasks.index')
            ->with('toast_success', __('Task updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return void
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')
            ->with('toast_success', 'Task deleted successfully');
    }

    public function addTask(Request $request)
    {

        $note = Task::create([
            'title' => $request->nameTask,
            'body' => $request->bodyTask,
            'date' => $request->task_d,
            'client_id' => $request->client_id,
            'user_id' => Auth::id(),
        ]);

        $result = Task::query();
        $result->where('client_id', $request->client_id);
        $result->orderBy('created_at');
        $tasks = $result;
        return \View::make('clients.tasks.index', compact('tasks'));
    }

    public function archive(Request $request)
    {

        if ($request->get('archive')) {
            $task = Task::find($request->archive);
            $task->archive = !$task->archive;
            $task->update();
        }

        $result = Task::query();
        $result->where('client_id', $request->client_id);
        $result->orderBy('archive', 'ASC');
        $result->orderBy('created_at', 'DESC');
        $tasks = $result->get();

        return \View::make('clients.tasks.index', compact('tasks'));
    }

    public function assigneTask(Request $request)
    {
        $task = Task::find($request->task_assigned_id);
        $task->update([
            'user_id' => $request->user_id,
        ]);
        try {
            return json_encode($task, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function deleteSingleTasks($id)
    {
        Task::find($id)->delete($id);
        return response()->json("ok");

    }

}
