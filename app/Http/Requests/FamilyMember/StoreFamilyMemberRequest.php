<?php

namespace App\Http\Requests\FamilyMember;

use Illuminate\Foundation\Http\FormRequest;

class StoreFamilyMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'max:255'],
            'relationship'  => ['required', 'string', 'max:50'],
            'date_of_birth' => ['nullable', 'date'],
            'blood_group'   => ['nullable', 'string', 'max:5'],
            'gender'        => ['nullable', 'in:male,female,other'],
            'phone'         => ['nullable', 'string', 'max:15'],
        ];
    }
}
