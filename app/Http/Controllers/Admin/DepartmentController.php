<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\UserLogActivityController;
use App\Http\Requests\Admin\DepartmentCreateRequest;
use App\Http\Requests\Admin\DepartmentUpdateRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::get();
        return view('admin.users.department.departments', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.department.departments_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentCreateRequest $request)
    {
        $query = Department::create([
            'departmentName' => ucwords($request->departmentName)
        ]);

        $log = [];
        $log['action'] = "Created Department";
        $log['content'] = "Department Name: " . ucwords($request->departmentName);
        $log['changes'] = '';

        if ($query) {
            UserLogActivityController::store($log);
            return Redirect::route('admin.departments.index')->with('saved', 'department-created');
        } else {
            return back()->withErrors(['error' => 'Failed to process request.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            return back();
        }
        $department = Department::where('id', $id)->first();
        return view('admin.users.department.departments_edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentUpdateRequest $request, $id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            return back();
        }
        $department = Department::where('id', $id)->first();
        $query = Department::where('id', $id)
            ->update([
                'departmentName' => ucwords($request->departmentName)
            ]);

        $log = [];
        $log['action'] = "Updated Department";
        $log['content'] = "Department Name: " . ucwords($department->departmentName);
        $log['changes'] = "Department Name: " . ucwords($request->departmentName);

        if ($query) {
            UserLogActivityController::store($log);
            return Redirect::route('admin.departments.index')->with('updated', 'department-updated');
        } else {
            return back()->withErrors(['error' => 'Failed to process request.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
