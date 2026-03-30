<?php

namespace App\Http\Resources\Medicine;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrescriptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'medicine_name' => $this->medicine_name,
            'dosage'        => $this->dosage,
            'frequency'     => $this->frequency,
            'duration'      => $this->duration,
            'instructions'  => $this->instructions,
        ];
    }
}
