<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserType;
use Illuminate\View\View;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Controllers\UserLogActivityController;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $types = UserType::get();
        $departments = Department::get();
        return view('profile.edit', [
            'user' => $request->user(),
            'types' => $types,
            'departments' => $departments
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // $request->user()->fill($request->validated());
        $department = Department::where('id', Auth::user()->department_id)->first();
        $userType = UserType::where('id', Auth::user()->user_type_id)->first();

        $newDepartment = Department::where('id', $request->department_id)->first();

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $query = User::where('id', Auth::user()->id)
            ->update([
                'employeeID' => $request->employeeID,
                'firstName' => $request->firstName,
                'middleInitial' => $request->middleInitial,
                'lastName' => $request->lastName,
                'department_id' => $request->department_id,
                'email' => $request->email
            ]);
        // $request->user()->save();
        $log = [];
        $log['action'] = "Updated Personal Profile";
        $log['content'] = "Employee ID: " . Auth::user()->employeeID . ", First Name: " . Auth::user()->firstName . " Middle Initial: " . Auth::user()->middleInitial . ", Last Name: " . Auth::user()->lastName . ", Department: " . $department->departmentName . ", User Type: " . $userType->userTypeName . ", Email: " . Auth::user()->email;
        $log['changes'] = "Employee ID: " . $request->employeeID . ", First Name: " . $request->firstName . " Middle Initial: " . $request->middleInitial . ", Last Name: " . $request->lastName . ", Department: " . $newDepartment->departmentName . ", User Type: " . $request->user_type . ", Email: " . $request->email;

        if ($query) {
            UserLogActivityController::store($log);
            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        } else {
            return back();
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
