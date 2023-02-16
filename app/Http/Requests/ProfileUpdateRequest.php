<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'employeeID' => ['required', 'string', 'max:255'],
            'firstName' => ['required', 'string', 'max:255'],
            'middleInitial' => ['max:100'],
            'lastName' => ['required', 'string', 'max:255'],
            'department_id' => ['required', 'string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'password' => ['required', Password::defaults(), 'confirmed']
        ];
    }
}
