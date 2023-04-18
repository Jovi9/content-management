<?php

namespace App\Http\Livewire\User;

use App\Http\Controllers\UserActivityController;
use App\Http\Livewire\LiveForm;
use App\Models\User;
use Livewire\Component;
use App\Models\UserType;
use App\Models\Department;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateProfile extends LiveForm
{
    // public $userID;
    public $employeeID;
    public $firstName, $middleName, $lastName, $prefix;
    public $sex, $dateOfBirth, $placeOfBirth, $civilStatus;
    public $email, $contactNo;
    public $department_id;

    protected function rules()
    {
        return [
            'employeeID' => ['required', 'string', 'max:255'],
            'firstName' => ['required', 'string', 'max:255'],
            'middleName' => ['max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'prefix' => ['max:10'],
            'sex' => ['required', 'string', 'max:10'],
            'dateOfBirth' => ['required', 'date'],
            'placeOfBirth' => ['required', 'string', 'max:255'],
            'civilStatus' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class)->ignore(Auth::user()->id)],
            'contactNo' => ['max:11'],
            'department_id' => ['required', 'integer'],
        ];
    }

    protected $messages = [
        'employeeID.required' => 'Employee ID is required.',
        'department_id.required' => 'Department is required.',
    ];

    public function render()
    {
        $departments = Department::all();
        return view('livewire.user.update-profile', [
            'departments' => $departments
        ]);
    }

    public function editProfile()
    {
        $user = User::where('id', Auth::user()->id)->first();
        // $this->userID = $user->id;
        $this->employeeID = $user->employeeID;
        $this->firstName = $user->firstName;
        $this->middleName = $user->middleName;
        $this->lastName = $user->lastName;
        $this->prefix = $user->prefix;
        $this->sex = $user->sex;
        $this->dateOfBirth = $user->dateOfBirth;
        $this->placeOfBirth = $user->placeOfBirth;
        $this->civilStatus = $user->civilStatus;
        $this->email = $user->email;
        $this->contactNo = $user->contactNo;
        $this->department_id = $user->department_id;
    }

    public function store()
    {
        $this->validate();

        $today = date('Y-m-d');
        $age = date_diff(date_create($this->dateOfBirth), date_create($today));
        $age = $age->format('%y');

        $profile = [
            'employeeID' => $this->employeeID,
            'firstName' => ucwords($this->firstName),
            'middleName' => ucwords($this->middleName),
            'lastName' => ucwords($this->lastName),
            'prefix' => ucwords($this->prefix),
            'sex' => ucwords($this->sex),
            'dateOfBirth' => $this->dateOfBirth,
            'age' => $age,
            'placeOfBirth' => ucwords($this->placeOfBirth),
            'civilStatus' => ucwords($this->civilStatus),
            'email' => $this->email,
            'contactNo' => $this->contactNo,
            'department_id' => $this->department_id,
        ];

        $department = Department::where('id', Auth::user()->department_id)->first();

        $newDepartment = Department::where('id', $this->department_id)->first();

        $log = [];
        $log['action'] = "Updated Personal Profile";
        $log['content'] = "Employee ID: " . Auth::user()->employeeID . ", First Name: " . Auth::user()->firstName . " Middle Name: " . Auth::user()->middleName . ", Last Name: " . Auth::user()->lastName . ', Prefix: ' . Auth::user()->prefix . ', Sex: ' . Auth::user()->sex . ', Date Of Birth: ' . Auth::user()->dateOfBirth . ', Age: ' . Auth::user()->age . ', Place Of Birth: ' . Auth::user()->placeOfBirth . ', Civil Status: ' . Auth::user()->civilStatus . ", Department: " . ucwords($department->departmentName) . ", Email: " . Auth::user()->email;
        $log['changes'] = "Employee ID: " . $this->employeeID . ", First Name: " . $this->firstName . " Middle Name: " . $this->middleName . ", Last Name: " . $this->lastName . ', Prefix: ' . $this->prefix . ', Sex: ' . $this->sex . ', Date Of Birth: ' . $this->dateOfBirth . ', Age: ' . $age . ', Place Of Birth: ' . $this->placeOfBirth . ', Civil Status: ' . $this->civilStatus . ", Department: " . ucwords($newDepartment->departmentName) . ", Email: " . $this->email;

        $query = User::where('id', Auth::user()->id)
            ->update($profile);

        if ($query) {
            UserActivityController::store($log);

            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'saved',
                'message' => 'Profile Successfully Updated',
            ]);
            $this->closeModal('#modalEditProfile');
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
        }
    }
}
