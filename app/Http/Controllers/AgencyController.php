<?php

namespace App\Http\Controllers;

use App\Agency;
use App\Imports\AgenciesImport;
use App\Models\Country;
use App\Models\Department;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    function __construct()
    {
        $this->middleware('permission:agency-list|agency-create|agency-edit|agency-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:agency-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:agency-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:agency-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     * @throws Exception
     */
    public function index(Request $request)
    {
        $departments = Department::all();
        $users = User::all();
        $countries = Country::all();

        $agencies = Agency::with(['clients'])->select(['id', 'name', 'company_type', 'phone']);

        if ($request->get('type')) {
            $agencies->where('company_type', '=', $request->get('type'));
        }
        if ($request->get('user')) {
            $agencies->where('user_id', '=', $request->get('user'));
        }
        if ($request->get('department')) {
            $agencies->where('department_id', '=', $request->get('department'));
        }
        if ($request->get('country')) {
            $agencies->where('country', '=', $request->get('country'));
        }
        if ($request->get('city')) {
            $agencies->where('city', 'LIKE', '%' . $request->get('city') . '%');
        }

        $agencies->OrderByDesc('created_at');

        if ($request->ajax()) {
            return DataTables::of($agencies)
                ->editColumn('company_type', function ($agency) {
                    return $agency->company_type === 1 ? __('Company') : __('Freelance');
                })
                ->editColumn('name', function ($agency) {
                    return '<a href="' . route('agencies.show', $agency) . '">' . $agency->name . '</a>';
                })
                ->editColumn('phone', function ($agency) {
                    return $agency->phone;
                })
                ->addColumn('action',
                    '<a class="dropdown-toggle addon-btn" data-toggle="dropdown"
            aria-expanded="true">
              <i class="icofont icofont-ui-settings"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
              @can(\'agency-edit\')
                  <a class="dropdown-item pl-2" href="{{ route(\'agencies.edit\', $id) }}">
                  <i class="fa fa-edit"></i> {{ __(\'Edit agency\') }}</a>
              @endcan
              @can(\'agency-delete\')
                  <form
                      action="{{ route(\'agencies.destroy\', $id) }}"
                      method="post" role="form">
                      @csrf
                      @method(\'DELETE\')
                      <button type="submit"
                              class="dropdown-item pl-2">
                          <i class="icon-trash"></i>  {{ __(\'Delete agency\') }}
                      </button>
                  </form>
              @endcan
          </div>')
                ->addColumn('details_url', function ($agency) {
                    return route('api.agency_single_details', $agency->id);
                })
                ->rawColumns(['name', 'action'])
                ->make(true);
        }
        return view('agencies.index', compact('users', 'departments', 'countries'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        $countries = Country::all();
        return view('agencies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {

        $data = $request->except('_token');

        $data['status'] = $request->has('status') ? 1 : 0;
        Agency::create($data);

        return redirect()->route('agencies.index')
            ->with('toast_success', __('Agency created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param Agency $agency
     * @return Application|Factory|\Illuminate\Contracts\View\View|void
     */
    public function show(Agency $agency)
    {
        $countries = Country::all();
        $agency->with('clients')->get();
        return view('agencies.show', compact('agency', 'countries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Agency $agency
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     */
    public function edit(Agency $agency)
    {
        if (auth()->user()->hasPermissionTo('department-agencies-sell')) {
            $countries = Country::all();
            $agency->with('clients')->get();
            return view('agencies.sells-office-edit', compact('agency', 'countries'));
        } else {
            $countries = Country::all();
            $agency->with('clients')->get();
            return view('agencies.edit', compact('agency', 'countries'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Agency $agency
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Agency $agency): \Illuminate\Http\RedirectResponse
    {
        $data = $request->except('_token', '_method', 'rep', 'rep_phone');

        $data['status'] = $request->has('status') ? 1 : 0;
        $agency->forceFill($data)->save();

        return redirect()->route('agencies.index')
            ->with('toast_success', __('Agency updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Agency $agency
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Agency $agency): \Illuminate\Http\RedirectResponse
    {
        $agency->delete();
        return redirect()->route('agencies.index')
            ->with('toast_success', __('Agency deleted successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Agency $agency
     * @param $id
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     */
    public function getAgencySellsOffice(Agency $agency, $id)
    {

        $agency = Agency::findOrFail($id);
        $countries = Country::all();

        $agency->with('clients')->get();

        /*$tasks = Task::whereHasMorph(
            'Taskable',
            ['App\Agency'],
            function ($query) use ($agency) {
                $query->where('agency_id', $agency->id);
            }
        )->get()->sortByDesc('created_at');

        $notes = Note::whereHasMorph(
            'Noteable',
            [Agency::class],
            function ($query) use ($agency) {
                $query->where('agency_id', $agency->id);
            }
        )->get()->sortByDesc('date')->sortByDesc('favorite');*/

        return view('agencies.sells-office-edit', compact('agency', 'countries'));
    }

    public function importAgency(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $import = new AgenciesImport();

            $import->import($file);
        }

        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }

        return redirect()->route('clients.index')->with('toast_success', __('File upload successfully'));
    }
}
