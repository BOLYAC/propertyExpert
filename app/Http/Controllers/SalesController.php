<?php

namespace App\Http\Controllers;

use App\Agency;
use App\Jobs\AssignedClientEmailJob;
use App\Jobs\MassAssignedClientEmailJob;
use App\Models\Client;
use App\Models\Country;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JsonException;
use Ramsey\Uuid\Uuid;

class SalesController extends Controller
{
    public function transfer(Request $request)
    {
        $client = Client::findOrFail($request->clientId);

        if ($client->status === 0 || $client->status === null || $client->status === '') {
            return redirect()->back()->with('toast_error', __('This lead must have a status'));
        }

        $l[] = json_encode($client->user_id);
        $n = $client->user->name;
        $s[] = $n;
        // Get status name
        $i = $client->status;
        switch ($i) {
            case 1:
                $status = __('New Lead');
                break;
            case 8:
                $status = __('No Answer');
                break;
            case 12:
                $status = __('In progress');
                break;
            case 3:
                $status = __('Potential appointment');
                break;
            case 4:
                $status = __('Appointment set');
                break;
            case 10:
                $status = __('Appointment follow up');
                break;
            case 5:
                $status = __('Sold');
                break;
            case 13:
                $status = __('Unreachable');
                break;
            case 7:
                $status = __('Not interested');
                break;
            case 11:
                $status = __('Low budget');
                break;
            case 9:
                $status = __('Wrong Number');
                break;
            case 14:
                $status = __('Unqualified');
                break;
            case 15:
                $status = __('Lost');
                break;
            case 16:
                $status = __('Unassigned');
                break;
            case 17:
                $status = __('One Month');
                break;
            case 18:
                $status = __('2-3 Months');
                break;
            case 19:
                $status = __('Over 3 Months');
                break;
            case 20:
                $status = __('In Istanbul');
                break;
            case 21:
                $status = __('Agent');
                break;
            case 22:
                $status = __('Transferred');
                break;
            case 23:
                $status = __('No Answering');
                break;
        }

        $lead['client_id'] = $request->clientId;
        $lead['external_id'] = Uuid::uuid4()->toString();
        $lead['created_by'] = $client->user_id;
        $lead['updated_by'] = $client->user_id;
        $lead['user_created_id'] = Auth::id();
        $lead['user_assigned_id'] = $client->user_id;
        $lead['owner_name'] = $client->user->name;
        $lead['user_id'] = $client->user_id;
        $lead['sell_rep'] = $client->user_id;
        $lead['deadline'] = now();
        $lead['sellers'] = $l;
        $lead['stage_id'] = 1;
        $lead['lead_name'] = $client->full_name ?? '';
        $lead['lead_email'] = $client->client_email ?? '';
        $lead['lead_phone'] = $client->client_number ?? '';
        $lead['sells_names'] = $s;
        $lead['description'] = $client->description ?? '';
        $lead['country'] = $client->country ?? '';
        $lead['nationality'] = $client->nationality ?? '';
        $lead['language'] = $client->lang ?? '';
        $lead['priority'] = $client->priority ?? '';
        $lead['status_id'] = $client->status ?? 99;
        $lead['status_name'] = $status ?? '';
        $lead['source_name'] = $client->source->name ?? '';
        $lead['source_id'] = $client->source_id ?? '';
        $lead['agency_name'] = $client->agency->name ?? '';
        $lead['lead_flags'] = $client->lead_flags ?? '';

        $lead['budget_request'] = $client->budget_request ?? '';
        $lead['rooms_request'] = $client->rooms_request ?? '';
        $lead['requirement_request'] = $client->requirements_request ?? '';

        $lead['companies_name'] = $client->campaigne_name ?? '';

        //$lead = Lead::create($lead);
        $lead = $client->Deals()->create($lead);
        //$client->update(['lead_id' => $lead->id]);
        $lead->ShareWithSelles()->attach($l, ['added_by' => Auth::id(), 'user_name' => Auth::user()->name]);
        return redirect()->route('leads.show', $lead)->with('toast_success', __('Deal created successfully for') . $client->full_name ?? '');
    }


    public function agencyToDealStep(Request $request)
    {
        $agency = Agency::findOrFail($request->agencyId);

        $l[] = json_encode($agency->user_id);
        $n = $agency->user->name;
        $s[] = $n;
        $users = User::all();
        $lead = [
            'agency_id' => $agency->id,
            'external_id' => Uuid::uuid4()->toString(),
            'created_by' => \auth()->id(),
            'updated_by' => $agency->user_id,
            'user_created_id' => \auth()->id(),
            'user_assigned_id' => $agency->user_id,
            'owner_name' => $agency->user->name,
            'user_id' => $agency->user_id,
            'sell_rep' => $agency->user_id,
            'deadline' => now(),
            'sellers' => $l,
            'stage_id' => 1,
            'sells_names' => $s,
            'agency_name' => $agency->name,
            'agency_phone' => $agency->phone,
            'agency_email' => $agency->email,
            'agency_country' => $agency->country,
            'agency_type' => $agency->company_type,
            'agency_tax_number' => $agency->tax_number,
            'agency_tax_branch' => $agency->tax_branch,
        ];

        $lead = $agency->Deals()->create($lead);

        $lead->ShareWithSelles()->attach($l, ['added_by' => Auth::id(), 'user_name' => Auth::user()->name]);

        return view('agencies.partials.before-transfer-to-deal', compact('lead', 'users'))->with('toast_success', __('Deal created successfully for') . $agency->agency_name ?? '');
    }

    public function agencyToDeal(Request $request)
    {
        $lead = Lead::findOrFail($request->leadId);
        // Form validation
        $this->validate($request, [
            "share_with" => "required|array|min:1",
            "share_with.*" => "required|string|distinct|min:1",
        ]);

        $users = $request->get('share_with');
        $u = User::whereIn('id', $users)->pluck('name');
        $user = User::find($users[0]);
        $team = $user->current_team_id ?? 1;

        $data = [
            'sell_rep' => $users[0],
            'team_id' => $team,
            'sellers' => $users,
            'sells_names' => $u,
            'department_id' => $user->department_id,
            'customer_name' => $request->customer_name,
            'lead_name' => $request->customer_name,
            'customer_passport_id' => $request->customer_passport_id,
            'customer_phone_number' => $request->customer_phone,
            'lead_phone' => $request->customer_phone,
            'budget_request' => $request->budget_request,
            'language' => $request->lang,
            'user_id' => $request->inCharge
        ];

        $lead->update($data);
        $lead->ShareWithSelles()->detach();
        $lead->ShareWithSelles()->attach($users, ['added_by' => Auth::id(), 'user_name' => Auth::user()->name]);

        return redirect()->route('leads.show', $request->leadId)->with('toast_success', __('Deal created successfully for') . $request->customer_name ?? $lead->agency_name ?? '');
    }

    public function transferToInvoice(Request $request)
    {
        $invoice = Invoice::create([
            'external_id' => Uuid::uuid4()->toString(),
            'client_id' => $request->get('clientId'),
            'user_id' => Auth::id(),
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
            'status' => 1,
        ]);
    }

    public function share(Request $request)
    {
        $user = User::find($request->get('user_id'));

        $team = $user->current_team_id ?? 1;

        $client = Client::find($request->get('client_id'));

        $client->update([
            'user_id' => $request->get('user_id'),
            'team_id' => $team,
            'type' => '1',
            'department_id' => $user->department_id
        ]);

        $client->tasks()->update([
            'user_id' => $user->id,
            'team_id' => $team,
            'department_id' => $user->department_id
        ]);

        $link = route('clients.edit', $client);

        $data = [
            'full_name' => $client->full_name,
            'assigned_by' => Auth::user()->name,
            'email' => $client->user->email,
            'link' => $link
        ];

        //AssignedClientEmailJob::dispatch($data);
        try {
            return json_encode($data, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return back()->withError($e->getMessage())->withInput();
        }

    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function massShare(Request $request)
    {
        $user = User::find($request->get('user_id'));

        $team = $user->current_team_id ?? 1;

        Client::whereIn('id', $request->get('clients'))
            ->update([
                'user_id' => $request->get('user_id'),
                'team_id' => $team,
                'department_id' => $user->department_id,
                'type' => '1'
            ]);

        $result = Client::whereIn('id', $request->get('clients'))->get();

        foreach ($result as $d) {
            $d->tasks()->update([
                'user_id' => $user->id,
                'team_id' => $team,
                'department_id' => $user->department_id,
            ]);

            $link = route('clients.edit', $d->id);

            $data[] = array(
                'full_name' => $d->full_name,
                'assigned_by' => Auth::user()->name,
                'email' => $d->user->email,
                'link' => $link
            );
        }
        //MassAssignedClientEmailJob::dispatch($data);

        try {
            return json_encode($data, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function shareLead(Request $request)
    {
        // Form validation
        $this->validate($request, [
            "share_with" => "required|array|min:1",
            "share_with.*" => "required|string|distinct|min:1",
        ]);

        $users = $request->get('share_with');
        $u = User::whereIn('id', $users)->pluck('name');
        $user = User::find($users[0]);
        $team = $user->current_team_id ?? 1;

        $lead = Lead::find($request->get('lead_id'));
        $lead->update([
            'sell_rep' => $users[0],
            'team_id' => $team,
            'sellers' => $users,
            'sells_names' => $u,
            'department_id' => $user->department_id,
        ]);

        $lead->ShareWithSelles()->detach();
        $lead->ShareWithSelles()->attach($users, ['added_by' => Auth::id(), 'user_name' => Auth::user()->name]);

        $link = route('leads.show', $lead);

        $data = [
            'full_name' => $lead->full_name,
            'assigned_by' => Auth::user()->name,
            'email' => $lead->user->email,
            'link' => $link
        ];

        //AssignedClientEmailJob::dispatch($data);

        return redirect()->back()->with('toast_success', __('Sellers updated successfully'));

    }

    public function shareClient(Request $request)
    {
        // Form validation
        $this->validate($request, [
            "share_with" => "required|array|min:1",
            "share_with.*" => "required|string|distinct|min:1",
        ]);

        $users = $request->get('share_with');
        $u = User::whereIn('id', $users)->pluck('name');
        $lead = Client::find($request->get('lead_id'));
        $lead->update([
            'sellers' => $users,
            'sells_names' => $u,
        ]);

        $lead->shareClientWith()->detach();
        $lead->shareClientWith()->attach($users, ['added_by' => Auth::id(), 'user_name' => Auth::user()->name]);

        $link = route('clients.show', $lead);

        $data = [
            'full_name' => $lead->full_name,
            'assigned_by' => Auth::user()->name,
            'email' => $lead->user->email,
            'link' => $link
        ];

        //AssignedClientEmailJob::dispatch($data);

        return redirect()->back()->with('toast_success', __('Client shared successfully'));
    }

    public function massShareClient(Request $request)
    {
        // Form validation
        $this->validate($request, [
            "users_ids" => "required|array|min:1",
            "users_ids.*" => "required|string|distinct|min:1",
        ]);

        $users = $request->get('users_ids');
        $u = User::whereIn('id', $users)->pluck('name');
        $leads = Client::whereIn('id', $request->get('clients'))->get();

        foreach ($leads as $lead) {
            $lead->update([
                'sellers' => $users,
                'sells_names' => $u,
            ]);
            $lead->shareClientWith()->detach();
            $lead->shareClientWith()->attach($users, ['added_by' => Auth::id(), 'user_name' => Auth::user()->name]);
        }

        //AssignedClientEmailJob::dispatch($data);

        return redirect()->back()->with('toast_success', __('Client shared successfully'));
    }


    public function convertToAgency(Request $request)
    {
        $client = Client::findOrFail($request->clientId);
        $agency = Agency::create([
            'name' => $client->Complete_name ?? $client->full_name,
            'in_charge' => $client->last_name . ' ' . $client->first_name,
            'email' => $client->client_email,
            'phone' => $client->client_number,
            'user_id' => $client->user_id,
            'team_id' => $client->team_id,
            'department_id' => $client->department_id,
            'created_by' => $client->created_by,
        ]);
        $client->delete();
        $countries = Country::all();

        return redirect()->route('agencies.show', compact('agency', 'countries'));
    }
}
