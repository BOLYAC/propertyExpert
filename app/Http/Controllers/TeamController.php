<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TeamController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    function __construct()
    {
        $this->middleware('permission:team-list|team-create|team-edit|team-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:team-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:team-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:team-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|Response|View
     */
    public function index(Request $request)
    {
        $users = User::all();
        $teams = Team::orderBy('id', 'DESC')->get();
        return view('teams.index', compact('teams', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $request_data = $request->except('_token');


        Validator::make($request_data, [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('createTeam');


        $user->ownedTeams()->save(Team::forceCreate([
            'user_id'       => $request_data['user_id'],
            'name'          => $request_data['name'],
            'personal_team' => true,
            'department_id' => $user->department_id
        ]));

        $user->currentTeam();
        return redirect()
            ->route('teams.edit', $user->currentTeam)
            ->with('toast_success', __('Team created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param Team $team
     * @return Response
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Team $team
     * @return Application|Factory|Response|View
     */
    public function edit(Team $team)
    {
        $users = User::all();
        return view('teams.edit', compact('team', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Team $team
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Team $team)
    {
        $user = $team->owner;
        $input = $request->all();


        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('updateTeamName');

        $team->forceFill([
            'name'          => $input['name'],
            'user_id'       => $input['user_id'],
            'department_id' => $user->department_id
        ])->save();

        $team->users()->sync($request->input('users'));
        $user->switchTeam($team);
        $users = User::whereIn('id', $request->input('users'))->get();
        foreach ($users as $u) {
            $u->switchTeam($team);
        }
        return redirect()
            ->route('teams.index')
            ->with('toast_success', __('Team updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Team $team
     * @return RedirectResponse
     */
    public function destroy(Team $team)
    {
        $team->purge();

        return redirect()->route('teams.index')
            ->with('toast_success', __('Team deleted successfully'));
    }
}
