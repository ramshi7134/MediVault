<?php

namespace App\Repositories;

use App\Models\SharedRecord;

class SharedRecordRepository
{
    public function create(array $data): SharedRecord
    {
        return SharedRecord::create($data);
    }

    public function findByToken(string $token): ?SharedRecord
    {
        return SharedRecord::with(['medicalRecord.prescriptions', 'medicalRecord.familyMember'])
            ->where('token', $token)
            ->first();
    }

    public function incrementAccessCount(SharedRecord $record): void
    {
        $record->increment('access_count');
    }
}
