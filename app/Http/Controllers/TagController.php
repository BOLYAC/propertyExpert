<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:tags-list|tags-create|tags-edit|tags-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:tags-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:tags-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tags-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();
        return view('tags.index', compact('tags'));
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
        Tag::create($data);

        return redirect()->route('tags.index')
            ->with('toast_success', __('Tag created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $data = $request->all();
        $data['status'] = $request->has('status') ? 1 : 0;
        $tag->update($data);

        return redirect()->route('tags.index')
            ->with('toast_success', __('Tag updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('tags.index')
            ->with('toast_success', __('Tag deleted successfully'));
    }

    public function getFlags(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = Tag::select("id", "name")
                ->where('status', true)
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($data);
    }
}
