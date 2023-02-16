<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\UserCreateRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

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

        if ($query) {
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
        $query = User::where('id', $id)
            ->update([
                'employeeID' => $request->employeeID,
                'firstName' => $request->firstName,
                'middleInitial' => $request->middleInitial,
                'lastName' => $request->lastName,
                'department_id' => $request->department_id,
                'user_type_id' => $request->user_type,
            ]);

        if ($query) {
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
