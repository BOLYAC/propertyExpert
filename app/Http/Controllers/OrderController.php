<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|Response|\Illuminate\View\View
     */
    public function index()
    {
        $projects = Project::all();
        if (\auth()->user()->hasRole('Admin')) {
            $users = User::all();
            $teams = Team::all();
            $departments = Department::all();
            return view('invoices.index', compact('users', 'departments', 'teams', 'projects'));
        } elseif (\auth()->user()->hasPermissionTo('team-manager')) {
            if (auth()->user()->ownedTeams()->count() > 0) {
                $users = auth()->user()->currentTeam->allUsers();
                $teams = auth()->user()->allTeams();
            }
            return view('invoices.index', compact('users', 'teams', 'projects'));
        } else {
            return view('invoices.index', compact('projects'));
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
        $invoices = Invoice::with(['client', 'user', 'project']);

        if ($request->get('user')) {
            $invoices->where('user_id', '=', $request->get('user'));
        }

        if ($request->get('department')) {
            $invoices->where('department_id', '=', $request->get('department'));
        }

        if ($request->get('team')) {
            $invoices->where('team_id', '=', $request->get('team'));
        }

        if ($request->get('project')) {
            $invoices->where('project_id', '=', $request->get('project'));
        }

        $invoices->OrderByDesc('created_at');


        return Datatables::of($invoices)
            ->setRowId('id')
            ->editColumn('lead_name', function ($invoices) {
                return '<a href="/invoices/' . $invoices->external_id . '" class="f-w-600">' . $invoices->client_name ?? $invoices->client->full_name ?? '' . '</a>';
            })
            ->addColumn('project_name', function ($invoices) {
                return '<span class="f-w-600">' . $invoices->project_name . '</span>';
            })
            ->addColumn(
                'user',
                function ($invoices) {
                    return '<span class="badge badge-success">' . optional($invoices->user)->name . '</span>';
                }
            )
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
            ->addColumn(
                'action',
                '<a href="{{ route(\'invoices.show\', $external_id) }}"
                                               class="m-r-15 text-muted f-18"><i
                                                    class="icofont icofont-eye-alt"></i></a>
                                            <a href="#!"
                                               class="m-r-15 text-muted f-18 delete"><i
                                                    class="icofont icofont-trash"></i></a>')
            ->rawColumns(['lead_name', 'project_name', 'user', 'action', 'sells_name'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        dd($data);
    }

    /**
     * Display the specified resource.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|Response|\Illuminate\View\View
     */
    public function show(Invoice $invoice)
    {
        //$amount = $invoice->price - $invoice->installment - $invoice->payments()->sum('amount');
        $amount = $invoice->commission_total - $invoice->payments()->sum('amount');
        return view('invoices.show', compact('invoice', 'amount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|Response|\Illuminate\View\View
     */
    public function edit(Invoice $invoice)
    {
        $projects = Project::all();
        return view('invoices.edit', compact('invoice', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Invoice $invoice
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|RedirectResponse|\Illuminate\View\View
     */
    public function update(Request $request, Invoice $invoice)
    {

        $data = $request->except('_token', 'files');
        //$m = $request->get('price') - $request->get('installment') - $invoice->payments()->sum('amount');

        $invoice->update($data);
        //$amount = $invoice->price - $invoice->installment - $invoice->payments()->sum('amount');

        $amount = $invoice->commission_total - $invoice->payments()->sum('amount');
        return view('invoices.show', compact('invoice', 'amount'))
            ->with('toast_success', __('Invoice updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Invoice $invoice
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Invoice $invoice): RedirectResponse
    {
        try {
            $invoice->delete();
        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('invoices.index');
    }

    public function commissionStat(Request $request)
    {

        $invoice = Invoice::where('id', $request->get('invoice_id'));

        $invoice->update([
            'commission_stat' => $request->get('title')
        ]);

    }

    public function changeStatus(Request $request)
    {
        $lead = Invoice::findOrFail($request->get('invoice_id'));

        $lead->update([
            'status' => $request->get('status')
        ]);

        $i = $request->get('status');
        switch ($i) {
            case 1:
                $stage = 'Paid';
                break;
            case 2:
                $stage = 'Partially paid';
                break;
        }


        /*$lead->StatusLog()->create([
            'stage_name' => $stage,
            'update_by' => \auth()->id(),
            'user_name' => \auth()->user()->name,
            'stage_id' => $request->get('stage_id')
        ]);*/

        try {
            return json_encode($lead, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function printInvoice(Invoice $invoice)
    {
        return view('invoices.print', compact('invoice'));
    }
}
