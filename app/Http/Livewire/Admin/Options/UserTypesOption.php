<?php

namespace App\Http\Livewire\Admin\Options;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\UserActivityController;
use App\Http\Livewire\LiveForm;
use Spatie\Permission\Models\Role;

class UserTypesOption extends LiveForm
{
    protected $roles;

    public $role_id, $roleName;

    protected function rules()
    {
        return [
            'roleName' => ['required', 'string', 'max:255', Rule::unique(Role::class, 'name')],
        ];
    }

    protected function getRoles()
    {
        $roles = Role::all();
        foreach ($roles as $role) {
            $this->roles[] = [
                'id' => Crypt::encrypt($role->id),
                'roleName' => $role->name,
            ];
        }
    }

    public function render()
    {
        $this->getRoles();
        return view('livewire.admin.options.user-types-option', [
            'roles' => $this->roles,
        ]);
    }

    public function store()
    {
        $this->validate();

        $userTypeInfo = [
            'name' => strtolower($this->roleName),
        ];

        $log = [];
        $log['action'] = "Added New User Type";
        $log['content'] = "User Type: " . $this->roleName;
        $log['changes'] = "";

        $query = Role::create($userTypeInfo);

        if ($query) {
            UserActivityController::store($log);

            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'saved',
                'message' => 'New User Type Added Successfully.',
            ]);
            $this->closeModal('#modalAddUserType');
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
        }
    }

    public function edit($id)
    {
        $this->role_id = $id;
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }
        $role = Role::where('id', $id)->first();
        $this->roleName = $role->name;
    }

    public function update()
    {
        try {
            $roleID = Crypt::decrypt($this->role_id);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
            return;
        }

        $this->validate([
            'roleName' => ['required', 'string', 'max:255', Rule::unique(Role::class, 'name')->ignore($roleID)],
        ]);

        $userTypeInfo = [
            'name' => strtolower($this->roleName),
        ];

        $role = Role::where('id', $roleID)->first();

        $log = [];
        $log['action'] = "Updated User Type Information";
        $log['content'] = "User Type: " . $role->name;
        $log['changes'] = "User Type: " . $this->roleName;

        $query = Role::where('id', $roleID)
            ->update($userTypeInfo);

        if ($query) {
            UserActivityController::store($log);

            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'saved',
                'message' => 'User Type Updated Successfully.',
            ]);
            $this->closeModal('#modalEditUserType');
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
        }
    }
}
