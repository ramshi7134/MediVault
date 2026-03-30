<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'name'          => ['sometimes', 'string', 'max:255'],
            'email'         => ['sometimes', 'email', 'max:255', "unique:users,email,{$userId}"],
            'phone'         => ['nullable', 'string', 'max:15', "unique:users,phone,{$userId}"],
            'date_of_birth' => ['nullable', 'date'],
            'blood_group'   => ['nullable', 'string', 'max:5'],
            'gender'        => ['nullable', 'in:male,female,other'],
            'address'       => ['nullable', 'string'],
            'avatar'        => ['nullable', 'image', 'max:2048'],
        ];
    }
}
