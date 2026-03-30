<?php

namespace App\Http\Resources\Share;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SharedRecordResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'token'      => $this->token,
            'share_url'  => url("/api/shared/{$this->token}"),
            'expires_at' => $this->expires_at?->toISOString(),
            'is_active'  => $this->is_active,
            'access_count' => $this->access_count,
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
