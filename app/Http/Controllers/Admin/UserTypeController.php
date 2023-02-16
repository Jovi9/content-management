<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\UserTypeCreateRequest;
use App\Http\Requests\Admin\UserTypeUpdateRequest;

class UserTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        if ($query) {
            return Redirect::route('admin.users.index')->with('status', 'user-type-created');
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
        $query = UserType::where('id', $id)
            ->update([
                'userTypeName' => Str::lower($request->userTypeName)
            ]);

        if ($query) {
            return Redirect::route('admin.users.index')->with('status', 'user-type-updated');
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
