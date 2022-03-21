<?php

namespace App\Http\Controllers;

use App\Imports\MarketingImport;
use App\Models\Client;
use App\Models\Marketing;
use App\Models\Source;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MarketingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    function __construct()
    {
        $this->middleware('permission:marketing-list|marketing-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:marketing-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $marketings = Marketing::all();
        $users = User::all();
        $sources = Source::all();
        return view('marketing.index', compact('marketings', 'users', 'sources'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Marketing $marketing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marketing $marketing)
    {
        //
    }

    public function import(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'file' => $request->file,
                'extension' => strtolower($request->file->getClientOriginalExtension()),
            ],
            [
                'file' => 'required',
                'extension' => 'required|in:xlsx,xls',
            ]
        );

        if ($request->hasFile('file')) {

            $file = $request->file('file');
            $source = $request->get('source');
            $import = new MarketingImport($source);

            $import->import($file);


            if ($import->failures()->isNotEmpty()) {
                return back()->withFailures($import->failures());
            }

            return redirect()->route('marketing.index')->with('toast_success', __('File upload successfully'));
        }
    }

    public function transferToLeads(Request $request)
    {
        $user = User::find($request->get('user_id'));

        $team = $user->current_team_id ?? 1;

        //$request->dd();
        $marketing = Marketing::whereIn('id', $request->get('clients'))->get();
        foreach ($marketing as $mark) {
            Client::create([
                'user_id' => $request->get('user_id'),
                'team_id' => $team,
                'department_id' => $user->department_id,
                'type' => '1',
                'status' => 1,
                'priority' => 3,
                'full_name' => $mark->lead_name,
                'client_email' => $mark->email,
                'client_number' => $mark->phone_number,
                'country' => $mark->country,
                'ad_name' => $mark->ad_name,
                'adset_name' => $mark->adset_name,
                'ad_campaign_name' => $mark->campaign_name,
                'form_name' => $mark->form_name,
                'ad_network' => $mark->platform,
                'description' => $mark->when_are_you_planning_to_buy,
                'source_id' => $mark->source,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]);
        }

                $data = [];
                foreach ($result as $d) {
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
}
