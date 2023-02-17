<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserLogActivity;
use Illuminate\Support\Facades\Auth;

class UserLogActivityController extends Controller
{
    public function index()
    {
        $logs = '';
        $user = User::find(Auth::user()->id);
        $users = User::get();
        if ($user->hasRole('administrator')) {
            $logs = UserLogActivity::orderBy('created_at', 'desc')->get();
        } else {
            $logs = UserLogActivity::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        }
        return view('log_activities', compact('logs', 'users'));
    }

    public static function store(array $activity)
    {
        $log = [];
        $log['user_id'] = Auth::user()->id;
        $log['action'] = $activity['action'];
        $log['content'] = $activity['content'];
        $log['changes'] = $activity['changes'];
        UserLogActivity::create($log);
    }
}
