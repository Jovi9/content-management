<?php

namespace App\Http\Livewire\User;

use App\Http\Controllers\UserActivityController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Validation\Rules\Password;

class ChangePassword extends Component
{
    public $current_password, $password, $password_confirmation;

    protected function rules()
    {
        return [
            'current_password' => ['required', 'current_password', 'min:8'],
            'password' => ['required', Password::defaults(), 'confirmed', 'min:8'],
            'password_confirmation' => ['required', 'min:8'],
        ];
    }

    protected $messages = [
        'password.confirmed' => 'New password and confirmation field do not match.',
    ];

    public function render()
    {
        return view('livewire.user.change-password');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatePassword()
    {
        $this->validate();

        $query = User::where('id', Auth::user()->id)
            ->update([
                'password' => Hash::make($this->password),
            ]);

        $log = [];
        $log['action'] = "Changed Password";
        $log['content'] = '';
        $log['changes'] = '';

        if ($query) {
            UserActivityController::store($log);

            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'saved',
                'message' => 'Password Updated Successfully.',
            ]);
        } else {
            $this->dispatchBrowserEvent('swal-modal', [
                'title' => 'error'
            ]);
        }
    }
}
