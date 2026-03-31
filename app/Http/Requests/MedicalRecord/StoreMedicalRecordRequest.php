<?php

namespace App\Http\Requests\MedicalRecord;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicalRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'            => ['required', 'string', 'max:255'],
            'hospital_name'    => ['nullable', 'string', 'max:255'],
            'doctor_name'      => ['nullable', 'string', 'max:255'],
            'visit_date'       => ['nullable', 'date'],
            'document_type'    => ['required', 'in:prescription,lab,invoice,report,other'],
            'family_member_id' => ['nullable', 'integer', 'exists:family_members,id'],
            'file'             => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:20480'],
            'tags'             => ['nullable', 'array'],
            'tags.*'           => ['string', 'max:50'],
            'group'            => ['nullable', 'string', 'max:255'],
        ];
    }
}
