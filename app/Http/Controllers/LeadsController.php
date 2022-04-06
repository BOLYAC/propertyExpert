<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\Project;
use App\Models\StageLog;
use App\Models\Team;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\Facades\DataTables;

class LeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index()
    {
        if (\auth()->user()->hasRole('Admin')) {
            $users = User::all();
            $teams = Team::all();
            return view('leads.index', compact('users', 'teams'));
        } elseif (\auth()->user()->hasPermissionTo('team-manager')) {
            if (auth()->user()->ownedTeams()->count() > 0) {
                $users = auth()->user()->currentTeam->allUsers();
                $teams = auth()->user()->allTeams();
            }
            return view('leads.index', compact('users', 'teams'));
        } elseif (\auth()->user()->hasRole('Call center HP')) {
            $teams = auth()->user()->ownedTeams->pluck('id');
            $users = User::with(['roles', 'teams'])->whereIn('current_team_id', $teams)->get();
            return view('leads.index', compact('users'));
        } else {
            return \view('leads.index');
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
        $leads = Lead::with(['client', 'user']);

        if ($request->get('stage')) {
            $leads->whereIn('stage_id', $request->get('stage'));
        }
        if ($request->get('user')) {
            $leads->whereIn('user_id', $request->get('user'))
                ->orWhereIn('sellers', $request->user);
        }
        if ($request->get('team')) {
            $leads->whereIn('team_id', $request->get('team'));
        }

        $leads->OrderByDesc('created_at');


        return Datatables::of($leads)
            ->setRowId('id')
            ->editColumn('lead_name', function ($leads) {
                return '<a href="leads/' . $leads->id . '">' . $leads->lead_name ?? $leads->client->full_name ?? '' . '</a>';
            })
            ->editColumn('stage', function ($leads) {
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
            ->editColumn(
                'user',
                function ($leads) {
                    return '<span class="badge badge-success">' . optional($leads->user)->name . '</span>';
                }
            )
            ->editColumn(
                'sells',
                function ($leads) {
                    $cou = '';
                    $sellRep = collect($leads->sells_names)->toArray();
                    foreach ($sellRep as $name) {
                        $cou .= '<span class="badge badge-dark">' . $name . '</span>';
                    }
                    return $cou;
                })
            ->addColumn(
                'stat', function ($leads) {
                if ($leads->invoice_id <> 0) {
                    return '<span class="badge badge-success">' . __('Deal Won') . '</span >';
                } else {
                    if (auth()->user()->hasPermissionTo('transfer-deal-to-invoice')) {
                        return '<form action="' . route('lead.convert.order', $leads->id) . '"
                                  onSubmit="return confirm(\'Are you sure?\');"
                                  method="post">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <button type="submit"
                                        class="btn btn-xs btn-success">'
                            . __('To the invoice') .
                            ' <i class="icon-arrow-right"></i>
                                </button>
                            </form>';
                    }
                }

            })->addColumn('action', '<a href="{{ route(\'leads.show\', $id) }}"
                                               class="m-r-15 text-muted f-18"><i
                                                    class="icofont icofont-eye-alt"></i></a>
                                            <a href="#!"
                                               class="m-r-15 text-muted f-18 delete"><i
                                                    class="icofont icofont-trash"></i></a>')
            ->rawColumns(['lead_name', 'user', 'stage', 'sells', 'stat', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $clients = Client::all();
        $users = User::all();
        return view('leads.create', compact('clients', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $client = Client::findOrFail($request->client_id);

        $lead = Lead::create(
            [
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => $request->user_assigned_id,
                'user_assigned_id' => $request->user_assigned_id,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'status_id' => $request->status,
                'user_created_id' => auth()->id(),
                'external_id' => Uuid::uuid1()->toString(),
                'client_id' => $request->client_id,
                'deadline' => now(),
                'lead_name' => $client->full_name,
                'lead_email' => $client->client_email,
                'lead_phone' => $client->client_number,
                'owner_name' => Auth::user()->name,
            ]
        );

        return redirect()->route('leads.show', $lead)->with('toast_success', __('Deal created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param Lead $lead
     * @return Application|Factory|View
     */
    public function show(Lead $lead)
    {
        $users = User::all();
        $projects = Project::all();
        return view('leads.show', compact('lead', 'users', 'projects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function edit($id): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Lead $lead
     * @return void
     */
    public function update(Request $request, Lead $lead): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->dd();
        $lead = Lead::findOrfail();

        $lead->delete();

        return redirect()->route('leads.index')->with('toast_danger', 'Deal deleted successfully.');
    }

    public function convertToOrder(Lead $lead)
    {
        if (is_null($lead->sellers) || empty($lead->sellers)) {
            return redirect()->back()->with('toast_danger', 'You must select Sales!');
        }

        $client = Client::findOrFail($lead->client_id);

        $sale = User::where('id', '=', $lead->sellers[0])->first();
        $data['client_name'] = $client->full_name;
        $data['client_id'] = $client->id;
        $data['sells_name'] = $lead->sells_names;
        $data['sells_ids'] = $lead->sellers;
        $data['owner_name'] = Auth::user()->name;
        $data['lead_name'] = $lead->owner_name;
        $data['lead_owner_id'] = $lead->user_id;
        $data['status'] = 2;
        $data['user_id'] = \auth()->id();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        $data['external_id'] = Uuid::uuid4()->toString();
        $data['lead_id'] = $lead->id;
        $data['user_commission_rate'] = \auth()->user()->commission_rate;
        $data['sale_commission_rate'] = $sale->commission_rate;


        $data['project_id'] = $lead->project_id;
        $data['property_id'] = $lead->property_id;
        $data['project_name'] = $lead->project_name;
        $data['country_province'] = $lead->country_province;
        $data['section_plot'] = $lead->section_plot;
        $data['block_num'] = $lead->block_num;
        $data['room_number'] = $lead->room_number;
        $data['floor_number'] = $lead->floor_number;
        $data['gross_square'] = $lead->gross_square;
        $data['flat_num'] = $lead->flat_num;
        $data['price'] = $lead->sale_price;

        $data['down_payment'] = $lead->down_payment;
        $data['payment_type'] = $lead->payment_type;
        $data['payment_discount'] = $lead->payment_discount;
        $data['note'] = $lead->excerpt;

        $invoice = Invoice::create($data);
        $lead->stage_id = 8;
        $lead->invoice_id = $invoice->id;
        $lead->save();
        return redirect()->route('invoices.edit', $invoice->external_id)->with('success', 'transferred to invoice');
    }

    public function changeStage(Request $request)
    {
        $d = $request->all();
        $lead = Lead::findOrFail($request->get('lead_id'));

        $lead->update([
            'stage_id' => $request->get('stage_id')
        ]);


        $i = $request->get('stage_id');
        switch ($i) {
            case 1:
                $stage = 'In contact';
                break;
            case 2:
                $stage = 'Appointment Set';
                break;
            case 3:
                $stage = 'Follow up';
                break;
            case 4:
                $stage = 'Reservation';
                break;
            case 5:
                $stage = 'Contract signed';
                break;
            case 6:
                $stage = 'Down payment';
                break;
            case 7:
                $stage = 'Developer invoice';
                break;
            case 8:
                $stage = 'Won Deal';
                break;
            case 9:
                $stage = 'Lost';
                break;
        }

        $lead->StageLog()->create([
            'stage_name' => $stage,
            'update_by' => \auth()->id(),
            'user_name' => \auth()->user()->name,
            'stage_id' => $request->get('stage_id')
        ]);

        try {
            return json_encode($lead, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function dealChangeOwner(Request $request)
    {
        $user = User::find($request->get('user_id'));

        $team = $user->current_team_id ?? 1;

        $lead = Lead::find($request->get('lead_id'));

        $lead->update(['user_id' => $request->get('user_id'), 'team_id' => $team]);

        $link = route('leads.show', $lead);
        $data = [
            'full_name' => $lead->lead_name,
            'assigned_by' => Auth::user()->name,
            'email' => $lead->user->email,
            'link' => $link
        ];
        //AssignedClientEmailJob::dispatch($data);
        try {
            return json_encode($data, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function reservationForm()
    {

        $data = \request()->except('_token', 'lead_id');

        $lead = Lead::findOrFail(\request()->lead_id);

        if (\request()->hasFile('file_path')) {
            $imagePath = $data['file_path']->store('clients/' . $lead->client_name . '/', 'public');
            $data['file_path'] = $imagePath;
        }

        $data['stage_id'] = 4;

        $lead->update($data);

        try {
            $lead->StageLog()->create([
                'stage_name' => 'Reservation',
                'update_by' => \auth()->id(),
                'user_name' => \auth()->user()->name,
                'stage_id' => 4
            ]);
            return json_encode($lead, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function dealReport(Request $request)
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

        $deals = Lead::whereBetween('created_at', [$from, $to])
            ->get();

        if ($deals->isEmpty()) {
            return back()->with('toast_error', __('There is no reservation on this date(s)'))->withInput();
        }

        $val = [$from, $to];

        return view('leads.report', compact('deals', 'val'));

    }

    public function generateReportDeal(Request $request, $val = array())
    {

        $d = $request->all();
        $t = array_keys($d);
        $p = explode("_", $t[0]);
        $to = $p[0] . ' ' . $p[1];
        $from = $val;
        $deals = Lead::whereBetween('created_at', [$from, $to])->get();


        if ($deals->isEmpty()) {
            return back()->with('toast_error', __('There is no deals in this date'))->withInput();
        }

        //return view('events.preview',compact('events'));
        $pdf = PDF::loadView('leads.preview', compact('deals', 'val'));
        $pdf->setPaper('Tabloid', 'landscape');
        return $pdf->stream('crm_hashim_group_crm.pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public
    function singleDelete($id): \Illuminate\Http\JsonResponse
    {
        Lead::find($id)->delete($id);
        return response()->json("ok");
    }
}
