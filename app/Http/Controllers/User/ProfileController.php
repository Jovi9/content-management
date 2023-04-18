<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $department = Department::where('id', Auth::user()->department_id)->first();
        return view('user.profile', compact('department'));
    }
}
