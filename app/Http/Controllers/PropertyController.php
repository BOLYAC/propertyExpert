<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $project = Project::findOrFail($request->project_id);
        $project->properties()->create([
            'unit_type' => $request->unit_type,
            'flat_type' => $request->flat_type,
            'floor' => $request->floor,
            'gross_sqm' => $request->gross_sqm,
            'net_sqm' => $request->net_sqm
        ]);

        return redirect()->route('projects.edit', $project->id)
            ->with('toast_danger', __('Successfully created new apartment'));
    }

    /**
     * Display the specified resource.
     *
     * @param Property $property
     * @return Response
     */
    public function show(Property $property): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Property $property
     * @return Response
     */
    public function edit(Property $property): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Property $property
     * @return RedirectResponse
     */
    public function update(Request $request, Property $property): RedirectResponse
    {

        $project = Property::findOrFail($request->property_id);
        $property->update([
            'unit_type' => $request->unit_type,
            'flat_type' => $request->flat_type,
            'floor' => $request->floor,
            'gross_sqm' => $request->gross_sqm,
            'net_sqm' => $request->net_sqm
        ]);

        return redirect()->route('projects.edit', $property->project->id)
            ->with('toast_danger', __('Apartment updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Property $property
     * @return Response
     */
    public function destroy(Property $property): RedirectResponse
    {
        $project = $property->project_id;
        $property->delete();
        return redirect()->route('projects.edit', $project)->with('toast_success', __("Apartment deleted with success"));
    }

    public function getSingleProperty($id)
    {
        $properties = Property::where('id', $id)
            ->get();
        return json_encode($properties);
    }
}
