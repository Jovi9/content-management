<?php

namespace App\Http\Requests\Admin;

use App\Models\UserType;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class UserTypeUpdateRequest extends FormRequest
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
            'userTypeName' => ['required', 'string', 'max:255', Rule::unique(UserType::class)->ignore(Crypt::decrypt($this->user_type))]
        ];
    }
}
