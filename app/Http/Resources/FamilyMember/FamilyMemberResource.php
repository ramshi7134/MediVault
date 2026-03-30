<?php

namespace App\Http\Resources\FamilyMember;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilyMemberResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'relationship'  => $this->relationship,
            'date_of_birth' => $this->date_of_birth?->format('Y-m-d'),
            'blood_group'   => $this->blood_group,
            'gender'        => $this->gender,
            'phone'         => $this->phone,
            'created_at'    => $this->created_at->toISOString(),
        ];
    }
}
