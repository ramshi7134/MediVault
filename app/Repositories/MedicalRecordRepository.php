<?php

namespace App\Repositories;

use App\Models\MedicalRecord;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class MedicalRecordRepository
{
    public function getForUser(int $userId, array $filters = []): LengthAwarePaginator
    {
        $query = MedicalRecord::with(['familyMember', 'prescriptions'])
            ->where('user_id', $userId)
            ->orderByDesc('visit_date');

        if (! empty($filters['document_type'])) {
            $query->where('document_type', $filters['document_type']);
        }
        if (! empty($filters['doctor_name'])) {
            $query->where('doctor_name', 'like', '%' . $filters['doctor_name'] . '%');
        }
        if (! empty($filters['hospital_name'])) {
            $query->where('hospital_name', 'like', '%' . $filters['hospital_name'] . '%');
        }
        if (! empty($filters['from_date'])) {
            $query->where('visit_date', '>=', $filters['from_date']);
        }
        if (! empty($filters['to_date'])) {
            $query->where('visit_date', '<=', $filters['to_date']);
        }
        if (! empty($filters['family_member_id'])) {
            $query->where('family_member_id', $filters['family_member_id']);
        }
        if (! empty($filters['group'])) {
            $query->where('group', $filters['group']);
        }

        return $query->paginate(15);
    }

    public function findForUser(int $id, int $userId): ?MedicalRecord
    {
        return MedicalRecord::with(['familyMember', 'prescriptions'])
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    public function create(array $data): MedicalRecord
    {
        return MedicalRecord::create($data);
    }

    public function delete(MedicalRecord $record): bool
    {
        return (bool) $record->delete();
    }

    public function getTimelineForUser(int $userId): Collection
    {
        return MedicalRecord::with(['familyMember', 'prescriptions'])
            ->where('user_id', $userId)
            ->orderByDesc('visit_date')
            ->get();
    }

    public function getGroupForUser(int $userId, string $group): Collection
    {
        return MedicalRecord::with(['familyMember', 'prescriptions'])
            ->where('user_id', $userId)
            ->where('group', $group)
            ->orderBy('visit_date')
            ->get();
    }
}
