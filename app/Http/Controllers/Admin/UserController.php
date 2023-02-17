<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\UserType;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\UserCreateRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Http\Controllers\UserLogActivityController;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::whereNot('user_type_id', 1)->get();
        $departments = Department::get();
        return view('admin.users.users', compact('users', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = UserType::whereNot('userTypeName', "administrator")->get();
        $departments = Department::get();
        return view('admin.users.user_create', compact('types', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $department = Department::where('id', $request->department_id)->first();
        $userType = UserType::where('id', $request->user_type)->first();

        $query = User::create([
            'employeeID' => $request->employeeID,
            'firstName' => $request->firstName,
            'middleInitial' => $request->middleInitial,
            'lastName' => $request->lastName,
            'department_id' => $request->department_id,
            'user_type_id' => $request->user_type,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ])->assignRole('staff');

        $log = [];
        $log['action'] = "Created User";
        $log['content'] = "Employee ID: " . $request->employeeID . ", First Name: " . $request->firstName . " Middle Initial: " . $request->middleInitial . ", Last Name: " . $request->lastName . ", Department: " . $department->departmentName . ", User Type: " . $userType->userTypeName . ", Email: " . $request->email;
        $log['changes'] = '';

        if ($query) {
            UserLogActivityController::store($log);
            return Redirect::route('admin.users.create')->with('status', 'user-created');
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
        $types = UserType::whereNot('userTypeName', "administrator")->get();
        $user = User::where('id', $id)->first();
        $departments = Department::get();
        return view('admin.users.user_edit', compact('types', 'user', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::where('id', $id)->first();
        $department = Department::where('id', $user->department_id)->first();
        $userType = UserType::where('id', $user->user_type)->first();

        $newDepartment = Department::where('id', $request->department_id)->first();
        $newUserType = UserType::where('id', $request->user_type)->first();

        $query = User::where('id', $id)
            ->update([
                'employeeID' => $request->employeeID,
                'firstName' => $request->firstName,
                'middleInitial' => $request->middleInitial,
                'lastName' => $request->lastName,
                'department_id' => $request->department_id,
                'user_type_id' => $request->user_type,
            ]);

        $log = [];
        $log['action'] = "Updated User";
        $log['content'] = "Employee ID: " . $user->employeeID . ", First Name: " . $user->firstName . " Middle Initial: " . $user->middleInitial . ", Last Name: " . $user->lastName . ", Department: " . $department->departmentName . ", User Type: " . $userType->userTypeName;
        $log['changes'] = "Employee ID: " . $request->employeeID . ", First Name: " . $request->firstName . " Middle Initial: " . $request->middleInitial . ", Last Name: " . $request->lastName . ", Department: " . $newDepartment->departmentName . ", User Type: " . $newUserType->userTypeName;

        if ($query) {
            UserLogActivityController::store($log);
            return Redirect::route('admin.users.index')->with('status', 'user-updated');
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
