<?php

namespace App\Repositories;

use App\Models\FamilyMember;
use Illuminate\Database\Eloquent\Collection;

class FamilyMemberRepository
{
    public function getForUser(int $userId): Collection
    {
        return FamilyMember::where('user_id', $userId)->get();
    }

    public function findForUser(int $id, int $userId): ?FamilyMember
    {
        return FamilyMember::where('id', $id)->where('user_id', $userId)->first();
    }

    public function create(int $userId, array $data): FamilyMember
    {
        return FamilyMember::create(array_merge($data, ['user_id' => $userId]));
    }

    public function update(FamilyMember $member, array $data): FamilyMember
    {
        $member->update($data);

        return $member->fresh();
    }

    public function delete(FamilyMember $member): bool
    {
        return (bool) $member->delete();
    }
}
