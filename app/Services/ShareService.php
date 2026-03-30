<?php

namespace App\Services;

use App\Models\MedicalRecord;
use App\Models\SharedRecord;
use App\Repositories\SharedRecordRepository;
use Carbon\Carbon;

class ShareService
{
    public function __construct(
        private readonly SharedRecordRepository $repository,
    ) {}

    public function create(MedicalRecord $record, int $userId, ?int $expiresInHours = null): SharedRecord
    {
        $expiresAt = $expiresInHours
            ? Carbon::now()->addHours($expiresInHours)
            : null;

        return $this->repository->create([
            'medical_record_id' => $record->id,
            'user_id'           => $userId,
            'expires_at'        => $expiresAt,
            'is_active'         => true,
        ]);
    }

    public function access(string $token): ?MedicalRecord
    {
        $shared = $this->repository->findByToken($token);

        if (! $shared || ! $shared->isAccessible()) {
            return null;
        }

        $this->repository->incrementAccessCount($shared);

        return $shared->medicalRecord;
    }
}
