<?php

namespace App\Http\Resources\MedicalRecord;

use App\Http\Resources\FamilyMember\FamilyMemberResource;
use App\Http\Resources\Medicine\PrescriptionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicalRecordResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'hospital_name'  => $this->hospital_name,
            'doctor_name'    => $this->doctor_name,
            'visit_date'     => $this->visit_date?->format('Y-m-d'),
            'document_type'  => $this->document_type,
            'file_url'       => asset('storage/' . $this->file_path),
            'file_mime'      => $this->file_mime,
            'file_size'      => $this->file_size,
            'ocr_status'     => $this->ocr_status,
            'extracted_text' => $this->whenNotNull($this->extracted_text),
            'tags'           => $this->tags ?? [],
            'group'          => $this->group,
            'family_member'  => new FamilyMemberResource($this->whenLoaded('familyMember')),
            'prescriptions'  => PrescriptionResource::collection($this->whenLoaded('prescriptions')),
            'created_at'     => $this->created_at->toISOString(),
        ];
    }
}
