<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\UserTypeCreateRequest;
use App\Http\Requests\Admin\UserTypeUpdateRequest;
use App\Http\Controllers\UserLogActivityController;

class UserTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userTypes = UserType::get();
        return view('admin.users.type.user_types', compact('userTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.type.user_type_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserTypeCreateRequest $request)
    {
        $query = UserType::create([
            'userTypeName' => Str::lower($request->userTypeName)
        ]);

        $log = [];
        $log['action'] = "Created User Type";
        $log['content'] = "User Type Name: " . Str::ucfirst($request->userTypeName);
        $log['changes'] = '';
        if ($query) {
            UserLogActivityController::store($log);
            return Redirect::route('admin.user_types.index')->with('saved', 'user-type-created');
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
        $count = UserType::count();
        if ($count == 1) {
            return back();
        } else {
            $userType = UserType::where('id', $id)->first();
            return view('admin.users.type.user_type_edit', [
                'userType' => $userType
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserTypeUpdateRequest $request, $id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            return back();
        }

        $type = UserType::where('id', $id)->first();

        $query = UserType::where('id', $id)
            ->update([
                'userTypeName' => Str::lower($request->userTypeName)
            ]);

        $log = [];
        $log['action'] = "Updated User Type";
        $log['content'] = "User Type Name: " . Str::ucfirst($type->userTypeName);
        $log['changes'] = "User Type Name: " . Str::ucfirst($request->userTypeName);
        if ($query) {
            UserLogActivityController::store($log);
            return Redirect::route('admin.user_types.index')->with('updated', 'user-type-updated');
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
