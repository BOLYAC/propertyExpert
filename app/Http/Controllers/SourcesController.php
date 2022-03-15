<?php

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:source-list|source-create|source-edit|source-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:source-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:source-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:source-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sources = Source::all();
        return view('sources.index', compact('sources'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        $data['for_company'] = $request->has('for_company') ? 1 : 0;
        Source::create($data);

        return redirect()->route('sources.index')
            ->with('toast_success', __('Source created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Source $source
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Source $source)
    {
        $data = $request->all();
        $data['status'] = $request->has('status') ? 1 : 0;
        $data['for_company'] = $request->has('for_company') ? 1 : 0;
        $source->update($data);

        return redirect()->route('sources.index')
            ->with('toast_success', __('Source updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Source $source
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Source $source)
    {
        $source->delete();
        return redirect()->route('sources.index')
            ->with('toast_success', __('Source deleted successfully'));
    }


    public function listSource()
    {
        $sources = Source::orderBy('created_at', 'desc')->get();
        return response()->json($sources);
    }
}
