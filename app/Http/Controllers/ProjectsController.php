<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Property;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ProjectsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     * @return Application|Factory|JsonResponse|View
     */
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return \view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');

        Project::create($data);

        return redirect()->route('projects.index')
            ->with('toast_success', __('Project created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        dd($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Project $project
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response
     */
    public function edit(Project $project)
    {
        return \view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->except('_token', '_method');

        $project->forceFill($data)->save();

        return redirect()->route('projects.index')
            ->with('toast_success', __('Project updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Project $project): \Illuminate\Http\RedirectResponse
    {
        if (!$project->invoices->isEmpty()) {
            return redirect()->route('projects.index')->with('toast_danger', __('Can\'t delete project with invoices, please remove invoices'));
        }
        $project->delete();
        return redirect()->route('projects.index')->with('toast_success', __('Project deleted with success'));
    }

    public function getProject($id)
    {
        $project = Project::findOrFail($id)->get('commission_rate');
        return response()->json($project);
        //return DataTables::of($this->projects)->make();
        //return json_encode($this->projects, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }

    /*public function getSingleProject($id)
    {

        $project = Http::get('https://hashimproperty.com/wp-json/wp/v2/properties/' . $id)
            ->json();
        $project = collect($project);
        //dd($project);
        $image = Http::get('https://hashimproperty.com/wp-json/wp/v2/media/' . $project['featured_media'])->json();
        $images = [];
        foreach ($project['property_meta']['fave_property_images'] as $key => $projMedia) {

            $i = Http::get('https://hashimproperty.com/wp-json/wp/v2/media/' . $projMedia)->json();

            $images[] = $i['source_url'];

        }

        return view('projects.show', compact('project', 'image', 'images'));
    }*/

    public function getProperties($id)
    {
        $properties = Property::where('project_id', $id)->pluck('unit_type', 'id');
        return json_encode($properties);
    }

    public function getSingleProject($id)
    {
        $properties = Project::where('id', $id)->pluck('location');
        return json_encode($properties);
    }
}
