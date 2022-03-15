<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;
use App\Http\Requests;
use App\Models\Department;
use App\Http\Requests\Department\StoreDepartmentRequest;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:department-list|department-create|department-edit|department-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:department-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:department-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:department-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     */
    public function index()
    {
        $departments = Department::all();
        return view('departments.index', compact('departments'));
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function indexData()
    {
        $departments = Department::select(['external_id', 'name', 'description']);
        return Datatables::of($departments)
            ->editColumn('name', function ($departments) {
                return $departments->name;
            })
            ->editColumn('description', function ($departments) {
                return $departments->description;
            })
            ->addColumn('delete', '
                <a href="#!"
                class="m-r-15 text-muted f-18 edit"><i
                class="icofont icofont-eye-alt"></i></a>
                <a href="#!"
                class="m-r-15 text-muted f-18 delete"><i
                class="icofont icofont-trash"></i></a>')
            ->rawColumns(['delete'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDepartmentRequest $request)
    {
        Department::create([
            'external_id' => Uuid::uuid4(),
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone
        ]);
        return redirect()->route('departments.index')->with('toast_danger', __('Department created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Void
     */
    public function show($id): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Department $department
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Department $department): \Illuminate\Http\RedirectResponse
    {
        $department->update([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone
        ]);
        return redirect()->route('departments.index')->with('toast_success', __('Department successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Department $department
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Department $department)
    {

        if (!$department->users->isEmpty()) {
            return redirect()->route('departments.index')->with('toast_danger', __('Can\'t delete department with users, please remove users'));
        }
        $department->delete();
        return redirect()->route('departments.index')->with('toast_success', __('Department deleted with success'));
    }
}
