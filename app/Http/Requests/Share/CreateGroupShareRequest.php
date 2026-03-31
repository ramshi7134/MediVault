<?php

namespace App\Http\Requests\Share;

use Illuminate\Foundation\Http\FormRequest;

class CreateGroupShareRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'expires_in_hours' => ['nullable', 'integer', 'min:1', 'max:8760'],
        ];
    }
}
