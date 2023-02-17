<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
            'departmentName' => $request->departmentName
        ]);

        $log = [];
        $log['action'] = "Created Department";
        $log['content'] = "Department Name: " . $request->departmentName;
        $log['changes'] = '';

        if ($query) {
            UserLogActivityController::store($log);
            return Redirect::route('admin.departments.index')->with('status', 'department-created');
        } else {
            return back();
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
        $department = Department::where('id', $id)->first();
        $query = Department::where('id', $id)
            ->update([
                'departmentName' => $request->departmentName
            ]);

        $log = [];
        $log['action'] = "Updated Department";
        $log['content'] = "Department Name: " . $department->departmentName;
        $log['changes'] = "Department Name: " . $request->departmentName;

        if ($query) {
            UserLogActivityController::store($log);
            return Redirect::route('admin.departments.index')->with('status', 'department-updated');
        } else {
            return back();
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
