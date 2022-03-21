<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Department;
use App\Models\Event;
use App\Models\Lead;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\UploadTrait;

class UsersController extends Controller
{
    use UploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $teams = auth()->user()->ownedTeams->pluck('id');
        if (auth()->user()->hasPermissionTo('team-manager')) {
            $users = User::with(['roles', 'teams'])->whereIn('current_team_id', $teams)->get();
        } elseif (auth()->user()->hasRole('Call center HP')) {
            $users = User::with(['roles', 'teams'])->whereIn('current_team_id', $teams)->get();
        } else {
            $users = User::with(['roles', 'teams'])->orderBy('id', 'DESC')->get();
        }
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        $departments = Department::all();

        $managers = User::all();
        return view('users.create', compact('roles', 'managers', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'roles' => 'required',
            'department_id' => 'required'
        ]);

        $input = $request->except('_token', 'roles');
        $input['password'] = Hash::make($input['password']);
        $input['external_id'] = Uuid::uuid4()->toString();
        $input['can_sse_country'] = $request->has('can_sse_country') ? 1 : 0;
        $input['can_sse_language'] = $request->has('can_sse_language') ? 1 : 0;
        $input['can_sse_source'] = $request->has('can_sse_source') ? 1 : 0;
        $input['can_sse_phone'] = $request->has('can_sse_phone') ? 1 : 0;
        $input['can_sse_email'] = $request->has('can_sse_email') ? 1 : 0;
        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('toast_success', __('User created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Application|Factory|View
     */
    public function show(user $user)
    {
        $leads = Lead::where('user_id', $user->id, function ($query) use ($user) {
            $query->orWhereIn('sellers', [$user->id]);
        });
        $events = Event::where('user_id', $user->id, function ($query) use ($user) {
            $query->orWhereIn('sellers', [$user->id])->count();
        });

        return view('users.show', compact('user'))
            ->with('client_statistics', $user->clients->count())
            ->with('task_statistics', $user->tasks->count())
            ->with('lead_statistics', $leads->count())
            ->with('event_statistics', $events->count());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        $managers = User::all();
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        $userManagers = $user->parent()->get();
        $departments = Department::all();


        return view('users.edit', compact('user', 'roles', 'userRole', 'managers', 'userManagers', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse|Response
     * @throws ValidationException
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'roles' => 'required',
            'image' => 'image|max:2048',
            'department_id' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = collect($input)->except(['password'])->toArray();
        }

        // Check if a profile image has been uploaded
        if ($request->has('full')) {
            // Get image file
            $image = $request->file('full');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->input('name')) . '_' . time();
            // Define folder path
            $folder = '/users/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $input['image_path'] = $filePath;
        }


        $input['can_sse_country'] = $request->has('can_sse_country') ? 1 : 0;
        $input['can_sse_language'] = $request->has('can_sse_language') ? 1 : 0;
        $input['can_sse_source'] = $request->has('can_sse_source') ? 1 : 0;
        $input['can_sse_phone'] = $request->has('can_sse_phone') ? 1 : 0;
        $input['can_sse_email'] = $request->has('can_sse_email') ? 1 : 0;

        $user->update($input);


        DB::table('model_has_roles')->where('model_id', $user->id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')->with('toast_success', __('User updated Successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse|void
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        if ($user->hasRole('Admin')) {
            return redirect()->route('users.index')
                ->with('toast_danger', __('Not allowed to delete super admin'));
        }

        try {
            $user->delete();
            redirect()->route('users.index')
                ->with('toast_success', __('User successfully deleted'));
        } catch (\Illuminate\Database\QueryException $e) {
            redirect()->route('users.index')
                ->with('toast_danger', __('User can NOT have, leads, clients, or tasks assigned when deleted'));
        }
    }

    /**
     * Json for Data tables
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function taskData(Request $request, $id)
    {
        $tasks = Task::with(['client'])->where('user_id', $id);

        if (!empty($request->from_date) && !empty($request->to_date)) {
            $from = $request->from_date;
            $to = $request->to_date;
        } else {
            $from = now();
            $to = now();
        }

        $from = \Carbon\Carbon::parse($from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00

        $to = Carbon::parse($to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59

        $tasks->whereBetween('date', [$from, $to]);

        if ($request->stat == 1) {
            $tasks->archive(true);
        }
        if ($request->stat == 2) {
            $tasks->archive(false);
        }

        return Datatables::of($tasks)
            ->editColumn('title', function ($tasks) {
                return $tasks->title;
            })
            ->editColumn('client', function ($tasks) {
                return '<a href="clients/' . $tasks->client_id . '/edit">' . optional($tasks->client)->full_name . '</a>';
            })
            ->editColumn('date', function ($tasks) {
                return optional($tasks->date)->format('d-m-Y') ?? '';
            })
            ->editColumn('archive', function ($tasks) {
                return $tasks->archive === true ? '<label class="txt-success f-w-600">' . __('Done') . '</label>' : '<label class="txt-danger f-w-600">' . __('Not yet') . '</label>';
            })
            ->rawColumns(['client', 'archive'])
            ->make(true);
    }

    /**
     * Json for Data tables
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function leadData(Request $request, $id)
    {
        $leads = Lead::with(['client']);


        if (!empty($request->from_date) && !empty($request->to_date)) {
            $from = $request->from_date;
            $to = $request->to_date;
        } else {
            $from = now();
            $to = now();
        }

        $from = \Carbon\Carbon::parse($from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00

        $to = Carbon::parse($to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59

        $leads->whereBetween('updated_at', [$from, $to]);

        if ($request->stat) {
            $leads->where('stage_id', '=', $request->stat);
        }

        $leads->where('user_id', $id, function ($query) use ($id) {
            $query->orWhereIn('sellers', [$id]);
        });

        return Datatables::of($leads)
            ->addColumn('full_name', function ($leads) {
                return '<a href="leads/' . $leads->id . '/show">' . optional($leads->client)->full_name ?? $leads->lead_name . '</a>';
            })
            ->editColumn('created_at', function ($leads) {
                return optional($leads->created_at)->format('d-m-Y');
            })
            ->editColumn('stage_id', function ($leads) {
                $i = $leads->stage_id;
                switch ($i) {
                    case 1:
                        return '<span class="badge badge-light-primary f-w-600">' . __('In contact') . '</span>';
                        break;
                    case 2:
                        return '<span class="badge badge-light-primary f-w-600">' . __('Appointment Set') . '</span>';
                        break;
                    case 3:
                        return '<span class="badge badge-light-primary f-w-600">' . __('Follow up') . '</span>';
                        break;
                    case 4:
                        return '<span class="badge badge-light-primary f-w-600">' . __('Reservation') . '</span>';
                        break;
                    case 5:
                        return '<span class="badge badge-light-primary f-w-600">' . __('Contract signed') . '</span>';
                        break;
                    case 6:
                        return '<span class="badge badge-light-primary f-w-600">' . __('Down payment') . '</span>';
                        break;
                    case 7:
                        return '<span class="badge badge-light-primary f-w-600">' . __('Developer invoice') . '</span>';
                        break;
                    case 8:
                        return '<span class="badge badge-light-success f-w-600">' . __('Won Deal') . '</span>';
                        break;
                    case 9:
                        return '<span class="badge badge-light-danger f-w-600">' . __('Lost') . '</span>';
                        break;
                }
            })
            ->rawColumns(['full_name', 'stage_id'])
            ->make(true);
    }

    /**
     * Json for Data tables
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function appointmentData(Request $request, $id)
    {
        $events = Event::with(['client']);

        if (!empty($request->from_date) && !empty($request->to_date)) {
            $from = $request->from_date;
            $to = $request->to_date;
        } else {
            $from = now();
            $to = now();
        }

        $from = \Carbon\Carbon::parse($from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00

        $to = Carbon::parse($to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59

        $events->whereBetween('event_date', [$from, $to]);

        $events->where('user_id', $id, function ($query) use ($id) {
            $query->orWhereIn('sellers', [$id]);
        });

        return Datatables::of($events)
            ->editColumn('event_date', function ($clients) {
                return optional($clients->event_date)->format('d-m-Y') ?? '';
            })
            ->addColumn('client_id', function ($events) {
                return '<a href="clients/' . $events->client_id . '/edit">' . optional($events->client)->full_name . '</a>';
            })
            ->editColumn('place', function ($clients) {
                return $clients->place ?? '';
            })
            ->rawColumns(['client_id'])
            ->make(true);
    }

    /**
     * Json for Data tables
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function clientData(Request $request, $id)
    {
        $clients = Client::select(['public_id', 'full_name', 'status', 'updated_at'])->where('user_id', $id);

        if (!empty($request->from_date) && !empty($request->to_date)) {
            $from = $request->from_date;
            $to = $request->to_date;
        } else {
            $from = now();
            $to = now();
        }

        $from = \Carbon\Carbon::parse($from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00

        $to = Carbon::parse($to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59

        $clients->whereBetween('updated_at', [$from, $to]);

        if ($request->stat) {
            $clients->where('status', '=', $request->stat);
        }

        return Datatables::of($clients)
            ->editColumn('public_id', function ($clients) {
                return $clients->public_id;
            })
            ->addColumn('full_name', function ($clients) {
                return '<a href="clients/' . $clients->id . '/edit">' . optional($clients)->full_name . '</a>';
            })
            ->addColumn('status', function ($clients) {
                $i = $clients->status;
                switch ($i) {
                    case 1:
                        return '<span class="badge badge-light-primary f-w-400">' . __('New Lead') . '</span>';
                        break;
                    case 8:
                        return '<span class="badge badge-light-primary f-w-400">' . __('No Answer') . '</span>';
                        break;
                    case 12:
                        return '<span class="badge badge-light-primary f-w-400">' . __('In progress') . '</span>';
                        break;
                    case 3:
                        return '<span class="badge badge-light-primary f-w-400">' . __('Potential appointment') . '</span>';
                        break;
                    case 4:
                        return '<span class="badge badge-light-primary f-w-400">' . __('Appointment set') . '</span>';
                        break;
                    case 10:
                        return '<span class="badge badge-light-primary f-w-400">' . __('Appointment follow up') . '</span>';
                        break;
                    case 5:
                        return '<span class="badge badge-light-success f-w-400">' . __('Sold') . '</span>';
                        break;
                    case 13:
                        return '<span class="badge badge-light-primary f-w-400">' . __('Unreachable') . '</span>';
                        break;
                    case 7:
                        return '<span class="badge badge-light-danger f-w-400">' . __('Not interested') . '</span>';
                        break;
                    case 11:
                        return '<span class="badge badge-light-danger f-w-400">' . __('Low budget') . '</span>';
                        break;
                    case 9:
                        return '<span class="badge badge-light-danger f-w-400">' . __('Wrong Number') . '</span>';
                        break;
                    case 14:
                        return '<span class="badge badge-light-danger f-w-400">' . __('Unqualified') . '</span>';
                        break;
                    case 15:
                        return '<span class="badge badge-light-danger f-w-400">' . __('Unqualified') . '</span>';
                        break;
                }
            })
            ->rawColumns(['full_name', 'status'])
            ->make(true);
    }


    public function listUser()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return response()->json($users);
    }

    public function fetch(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = User::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($data);
    }

    public function getContact()
    {
        $users = User::all();
        return \view('users.contact', compact('users'));
    }
}
