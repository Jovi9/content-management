<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class UserActivityController extends Controller
{
    public function index()
    {
        $logs = '';
        $user = User::find(Auth::user()->id);
        $users = User::get();
        if ($user->hasRole('administrator')) {
            $logs = UserActivity::orderBy('created_at', 'desc')->get();
        } else {
            $logs = UserActivity::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        }
        return view('user.user-activities', compact('logs', 'users'));
    }

    public static function store(array $activity)
    {
        $log = [];
        $log['user_id'] = Auth::user()->id;
        $log['action'] = $activity['action'];
        $log['content'] = $activity['content'];
        $log['changes'] = $activity['changes'];
        UserActivity::create($log);
    }

    public function getActivity_ByID(Request $request)
    {
        $activity = UserActivity::where('id', Crypt::decrypt($request->id))->first();
        $user = User::where('id', $activity->user_id)->first();

        $response = [
            'user' => $user->firstName . ' ' . $user->lastName,
            'action' => $activity->action,
            'content' => $activity->content,
            'changes' => $activity->changes,
            'date' => date('M-d-Y h:i A', strtotime($activity->created_at))
        ];

        return response()->json($response);
    }
}
