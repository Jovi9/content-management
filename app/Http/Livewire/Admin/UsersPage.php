<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Models\Department;
use App\Http\Livewire\LiveForm;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\UserActivityController;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersPage extends LiveForm
{
    protected $users;
    public $user_id;
    public $employeeID;
    public $firstName, $middleName, $lastName, $prefix;
    public $sex, $dateOfBirth, $placeOfBirth, $civilStatus;
    public $email, $contactNo;
    public $department_id, $user_type;

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
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class)],
            'contactNo' => ['max:11'],
            'department_id' => ['required', 'integer'],
            'user_type' => ['required', 'string'],
        ];
    }

    protected $messages = [
        'employeeID.required' => 'Employee ID is required.',
        'department_id.required' => 'Department is required.',
        'user_type.required' => 'User Type is required.',
    ];

    protected function getUsers()
    {
        $users = User::all();
        foreach ($users as $user) {
            if (!($user->hasRole('administrator'))) {
                $department = Department::select('departmentName')->where('id', $user->department_id)->first();
                $this->users[] = [
                    'id' => Crypt::encrypt($user->id),
                    'employeeID' => $user->employeeID,
                    'name' => $user->firstName . ' ' . $user->middleName . ' ' . $user->lastName . ' ' . $user->prefix,
                    'department' => ucwords($department->departmentName),
                    'email' => $user->email,
                    'status' => $user->isEnabled,
                ];
            }
        }
    }

    public function render()
    {
        $this->getUsers();
        $departments = Department::all();
        $userTypes = Role::whereNot('id', 1)->get();
        return view('livewire.admin.users-page', [
            'users' => $this->users,
            'departments' => $departments,
            'userTypes' => $userTypes,
        ]);
    }

    public function store()
    {
        $this->validate();

        $today = date('Y-m-d');
        $age = date_diff(date_create($this->dateOfBirth), date_create($today));
        $age = $age->format('%y');

        $userInfo = [
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
            'password' => Hash::make($this->dateOfBirth),
        ];

        $department = Department::where('id', $this->department_id)->first();
        $userType = Role::where('name', $this->user_type)->first();

        $log = [];
        $log['action'] = "Added New User";
        $log['content'] = "Employee ID: " . $this->employeeID . ", First Name: " . $this->firstName . " Middle Name: " . $this->middleName . ", Last Name: " . $this->lastName . ', Prefix: ' . $this->prefix . ', Sex: ' . $this->sex . ', Date Of Birth: ' . $this->dateOfBirth . ', Age: ' . $age . ', Place Of Birth: ' . $this->placeOfBirth . ', Civil Status: ' . $this->civilStatus . ", Department: " . ucwords($department->departmentName) . ", Email: " . $this->email . ', User Type: ' . ucwords($userType->name);
        $log['changes'] = "";

        $query = User::create($userInfo)
            ->assignRole($this->user_type);

        if ($query) {
            UserActivityController::store($log);

            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'saved',
                'message' => 'New User Added Successfully.',
            ]);
            $this->closeModal('#modalAddUser');
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
        }
    }

    public function edit($id)
    {
        $this->user_id = $id;
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }
        $user = User::where('id', $id)->first();
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
        $roles = $user->getRoleNames();
        $this->user_type = $roles[0];
    }

    public function update()
    {
        try {
            $userID = Crypt::decrypt($this->user_id);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }
        $this->validate([
            'employeeID' => ['required', 'string', 'max:255'],
            'firstName' => ['required', 'string', 'max:255'],
            'middleName' => ['max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'prefix' => ['max:10'],
            'sex' => ['required', 'string', 'max:10'],
            'dateOfBirth' => ['required', 'date'],
            'placeOfBirth' => ['required', 'string', 'max:255'],
            'civilStatus' => ['required', 'string', 'max:255'],
            'department_id' => ['required', 'integer'],
            'user_type' => ['required', 'string'],
        ]);

        $today = date('Y-m-d');
        $age = date_diff(date_create($this->dateOfBirth), date_create($today));
        $age = $age->format('%y');

        $userInfo = [
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
            'department_id' => $this->department_id,
        ];

        $user = User::where('id', $userID)->first();
        $userRole = $user->getRoleNames();

        $department = Department::where('id', $user->department_id)->first();
        $newDepartment = Department::where('id', $this->department_id)->first();

        $log = [];
        $log['action'] = "Updated User Information";
        $log['content'] = "Employee ID: " . $user->employeeID . ", First Name: " . $user->firstName . " Middle Name: " . $user->middleName . ", Last Name: " . $user->lastName . ', Prefix: ' . $user->prefix . ', Sex: ' . $user->sex . ', Date Of Birth: ' . $user->dateOfBirth . ', Age: ' . $user->age . ', Place Of Birth: ' . $user->placeOfBirth . ', Civil Status: ' . $user->civilStatus . ", Department: " . ucwords($department->departmentName) . ', User Type: ' . ucwords($userRole[0]);
        $log['changes'] = "Employee ID: " . $this->employeeID . ", First Name: " . $this->firstName . " Middle Name: " . $this->middleName . ", Last Name: " . $this->lastName . ', Prefix: ' . $this->prefix . ', Sex: ' . $this->sex . ', Date Of Birth: ' . $this->dateOfBirth . ', Age: ' . $age . ', Place Of Birth: ' . $this->placeOfBirth . ', Civil Status: ' . $this->civilStatus . ", Department: " . ucwords($newDepartment->departmentName) . ', User Type: ' . ucwords($this->user_type);

        $query = User::where('id', $userID)
            ->update($userInfo);

        if ($query) {
            $user->syncRoles($this->user_type);

            UserActivityController::store($log);

            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'saved',
                'message' => 'User updated successfully.',
            ]);
            $this->closeModal('#modalEditUser');
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
        }
    }
}
