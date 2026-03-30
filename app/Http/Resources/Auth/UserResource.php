<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'email'          => $this->email,
            'phone'          => $this->phone,
            'date_of_birth'  => $this->date_of_birth?->format('Y-m-d'),
            'blood_group'    => $this->blood_group,
            'gender'         => $this->gender,
            'address'        => $this->address,
            'avatar'         => $this->avatar ? asset('storage/' . $this->avatar) : null,
            'created_at'     => $this->created_at->toISOString(),
        ];
    }
}
