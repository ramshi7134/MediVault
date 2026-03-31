<?php

namespace App\Services;

use App\Models\MedicalRecord;
use App\Models\SharedRecord;
use App\Repositories\MedicalRecordRepository;
use App\Repositories\SharedRecordRepository;
use Carbon\Carbon;

class ShareService
{
    public function __construct(
        private readonly SharedRecordRepository $repository,
        private readonly MedicalRecordRepository $recordRepository,
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

    public function createForGroup(string $group, int $userId, ?int $expiresInHours = null): SharedRecord
    {
        $expiresAt = $expiresInHours
            ? Carbon::now()->addHours($expiresInHours)
            : null;

        return $this->repository->create([
            'medical_record_id' => null,
            'group'             => $group,
            'user_id'           => $userId,
            'expires_at'        => $expiresAt,
            'is_active'         => true,
        ]);
    }

    public function access(SharedRecord $shared): MedicalRecord
    {
        $this->repository->incrementAccessCount($shared);

        return $shared->medicalRecord;
    }

    public function accessGroup(SharedRecord $shared): array
    {
        $this->repository->incrementAccessCount($shared);

        $records = $this->recordRepository->getGroupForUser($shared->user_id, $shared->group);

        return [
            'group'   => $shared->group,
            'records' => $records,
        ];
    }

    public function getSharedByToken(string $token): ?SharedRecord
    {
        $shared = $this->repository->findByToken($token);

        if (! $shared || ! $shared->isAccessible()) {
            return null;
        }

        return $shared;
    }

}
