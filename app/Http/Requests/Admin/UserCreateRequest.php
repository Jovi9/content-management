<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'employeeID' => ['required', 'string', 'max:255'],
            'firstName' => ['required', 'string', 'max:255'],
            'middleInitial' => ['max:100'],
            'lastName' => ['required', 'string', 'max:255'],
            'department_id' => ['required', 'integer'],
            'user_type' => ['required', 'integer'],
            'email' => ['email', 'max:255', Rule::unique(User::class)],
            'password' => ['required', Password::defaults(), 'confirmed']
        ];
    }
}
