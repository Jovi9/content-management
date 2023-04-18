<?php

namespace App\Http\Livewire\Admin\Options;

use Livewire\Component;
use App\Models\Department;
use App\Http\Livewire\LiveForm;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\UserActivityController;

class DepartmentsOption extends LiveForm
{
    protected $departments;

    public $department_id, $departmentName, $departmentDescription;

    protected function rules()
    {
        return [
            'departmentName' => ['required', 'string', 'max:255', Rule::unique(Department::class)],
            'departmentDescription' => ['string', 'nullable'],
        ];
    }

    protected function getDepartments()
    {
        $departments = Department::all();
        foreach ($departments as $department) {
            $this->departments[] = [
                'id' => Crypt::encrypt($department->id),
                'departmentName' => $department->departmentName,
                'departmentDescription' => $department->departmentDescription,
            ];
        }
    }

    public function render()
    {
        $this->getDepartments();
        return view('livewire.admin.options.departments-option', [
            'departments' => $this->departments,
        ]);
    }

    public function store()
    {
        $this->validate();

        $departmentInfo = [
            'departmentName' => ucwords($this->departmentName),
            'departmentDescription' => $this->departmentDescription,
            'last_user_id' => Auth::user()->id,
        ];

        $log = [];
        $log['action'] = "Added New Department";
        $log['content'] = "Department Name: " . $this->departmentName . ', Department Description: ' . $this->departmentDescription;
        $log['changes'] = "";

        $query = Department::create($departmentInfo);

        if ($query) {
            UserActivityController::store($log);

            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'saved',
                'message' => 'New Department Added Successfully.',
            ]);
            $this->closeModal('#modalAddDepartment');
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
        }
    }

    public function edit($id)
    {
        $this->department_id = $id;
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }
        $department = Department::where('id', $id)->first();
        $this->departmentName = $department->departmentName;
        $this->departmentDescription = $department->departmentDescription;
    }

    public function update()
    {
        try {
            $deptID = Crypt::decrypt($this->department_id);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }

        $this->validate([
            'departmentName' => ['required', 'string', 'max:255', Rule::unique(Department::class)->ignore($deptID)],
            'departmentDescription' => ['string', 'nullable'],
        ]);

        $departmentInfo = [
            'departmentName' => ucwords($this->departmentName),
            'departmentDescription' => $this->departmentDescription,
            'last_user_id' => Auth::user()->id,
        ];

        $department = Department::where('id', $deptID)->first();

        $log = [];
        $log['action'] = "Updated Department Information";
        $log['content'] = "Department Name: " . $department->departmentName . ', Department Description: ' . $department->departmentDescription;
        $log['changes'] = "Department Name: " . $this->departmentName . ', Department Description: ' . $this->departmentDescription;

        $query = Department::where('id', $deptID)
            ->update($departmentInfo);

        if ($query) {
            UserActivityController::store($log);

            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'saved',
                'message' => 'Department Updated Successfully.',
            ]);
            $this->closeModal('#modalEditDepartment');
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
        }
    }
}
