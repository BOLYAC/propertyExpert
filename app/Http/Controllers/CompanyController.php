<?php

namespace App\Http\Controllers;

use App\Agency;
use App\Models\company;
use App\Models\Department;
use App\Models\Lead;
use App\Models\Source;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    function __construct()
    {
        $this->middleware('permission:company-list|company-create|company-edit|company-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:company-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:company-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:company-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::all();
        $sources = Source::where('for_company', 1)->get();

        $companies = Company::query();

        if ($request->get('type')) {
            $companies->where('source_id', '=', $request->get('type'));
        }
        if ($request->get('user')) {
            $companies->where('user_id', '=', $request->get('user'));
        }

        $companies->OrderByDesc('created_at');

        if ($request->ajax()) {
            return DataTables::of($companies)
                ->setRowId('id')
                ->editColumn('user_id', function ($company) {
                    return '<span class="badge badge-light-success btn-xs">' . $company->user->name . '</span>';
                })
                ->editColumn('name', function ($company) {
                    return '<a href="' . route('companies.edit', $company) . '">' . $company->name . '</a>';
                })
                ->editColumn('company_type', function ($company) {
                    return $company->source->name;
                })
                ->editColumn('phone', function ($company) {
                    return $company->phone;
                })
                ->editColumn('person_name', function ($company) {
                    return $company->person_name;
                })
                ->editColumn('person_phone', function ($company) {
                    return $company->person_phone;
                })
                ->editColumn('person_email', function ($company) {
                    return $company->person_email;
                })
                ->addColumn('action',
                    '
                <div>
              @can(\'company-delete\')
                  <form
                      action="{{ route(\'companies.destroy\', $id) }}"
                      method="post" role="form">
                      @csrf
                      @method(\'DELETE\')
                      <button type="submit"
                              class="dropdown-item pl-2 ">
                          <i class="icon-trash"></i>  {{ __(\'Delete\') }}
                      </button>
                  </form>
              @endcan
          </div>')
                ->rawColumns(['name', 'action', 'user_id'])
                ->make(true);
        }
        return view('companies.index', compact('companies', 'users', 'sources'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sources = Source::where('for_company', 1)->get();
        return view('companies.create', compact('sources'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $data = $request->except('_token');

        Company::create($data);

        return redirect()->route('companies.index')
            ->with('toast_success', __('Company deleted successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\company $company
     * @return \Illuminate\Http\Response
     */
    public function show(company $company)
    {
        $sources = Source::where('for_company', 1)->get();
        return view('companies.show', compact('company', 'sources'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\company $company
     * @return \Illuminate\Http\Response
     */
    public function edit(company $company)
    {
        $sources = Source::where('for_company', 1)->get();
        return view('companies.edit', compact('company', 'sources'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\company $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, company $company)
    {
        $data = $request->except('_token', '_method');

//        $data['status'] = $request->has('status') ? 1 : 0;
        $company->forceFill($data)->save();

        return redirect()->route('companies.index')
            ->with('toast_success', __('Company updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\company $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')
            ->with('toast_success', __('Company deleted successfully'));
    }

    public function applyTitleDeed()
    {
        $lead = Lead::findOrFail(\request()->get('lead_id'));
        $lead->update([
            'title_deed' => \request()->input('titleCheck'),
        ]);

        try {
            return json_encode($lead, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return back()->withError($e->getMessage())->withInput();
        }

    }

    public function applyExpertiseReport()
    {
        $lead = Lead::findOrFail(\request()->get('lead_id'));
        $lead->update([
            'expertise_report' => \request()->input('reportCheck'),
        ]);

        try {
            return json_encode($lead, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return back()->withError($e->getMessage())->withInput();
        }

    }

    public function getFieldReport()
    {

        $sources = Source::where('for_company', true)->get();
        $agencies = Agency::all();

        $users = User::all();
        $teams = Team::all();
        $departments = Department::all();


        $company = new Company();
        $table = $company->getTable();
        $columns = DB::getSchemaBuilder()->getColumnListing($table);
//        dd($columns);
        $remove = [
            'id',
            'team_id',
            'department_id',
            'user_id',
            'created_by',
            'updated_by',
            'deleted_at',
            'created_at',
            'updated_at'
        ];
        $newArr = array_filter($columns, function ($value) use ($remove) {
            return !in_array($value, $remove);
        });

        return \view('companies.field-report', compact('newArr', 'sources', 'agencies', 'users', 'teams', 'departments'));
    }

    public function postFieldReport(Request $request)
    {
        $data = $request->validate([
            "fields" => "required|array|min:3",
            "fields.*" => "required|string|distinct",
        ]);


        $r = [
            'tasks',
            'notes',
        ];

        $newArr = array_filter($data['fields'], function ($value) use ($r) {
            return !in_array($value, $r);
        });

        $companies = Company::query();
        $company = $companies->with(['user', 'tasks', 'notes']);

        if ($request->get('user')) {
            $companies->whereIn('user_id', $request->get('user'));
        }
        if ($request->get('team')) {
            $companies->whereIn('team_id', $request->get('team'));
        }
        if ($request->get('department')) {
            $companies->whereIn('department_id', $request->get('department'));
        }
        if ($request->get('daysActif')) {
            $companies->where('updated_at', ' <= ', \Carbon\Carbon::today()->subDays($request->get('daysActif')));
        }

        if ($request->filterDateBase !== 'none') {
            $date = explode(' - ', $request->get('daterange'));
            $from = $date[0];
            $to = $date[1];

            $from = Carbon::parse($from)
                ->startOfDay()        // 2018-09-29 00:00:00.000000
                ->toDateTimeString(); // 2018-09-29 00:00:00

            $to = Carbon::parse($to)
                ->endOfDay()          // 2018-09-29 23:59:59.000000
                ->toDateTimeString(); // 2018-09-29 23:59:59

            $d = $request->get('filterDateBase');
            switch ($d) {
                case 'creation':
                    $companies->whereBetween('created_at', [$from, $to]);
                    break;
                case 'modification':
                    $companies->whereBetween('updated_at', [$from, $to]);
                    break;
                case 'arrival':
                    $companies->whereBetween('appointment_date', [$from, $to]);
                    break;
            }
        }

        if ($request->lastUpdate === 'true') {
            $companies->whereHas('tasks', function ($query) {
                $query->where('archive', ' = ', 0);
            }, ' = ', 0)
                ->WhereDoesntHave('tasks');
        }
        $companies = $companies->get();
        $fields = $request->fields;
        return \View::make('companies.partials._table-report', compact('fields', 'companies'));
    }
}
