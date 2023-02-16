<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyProfileRequest extends FormRequest
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
            'companyName' => ['required', 'string', 'max:255'],
            'companyAddress' => ['required', 'string', 'max:255'],
            'companyHead' => ['required', 'string', 'max:255'],
            'companyHeadTitle' => ['required', 'string', 'max:255'],
            'companyType' => ['required', 'string', 'max:255'],
            'companyDescription' => ['required', 'string', 'max:255']
        ];
    }
}
