<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\SharedRecord;
use App\Repositories\FamilyMemberRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly FamilyMemberRepository $familyRepo,
    ) {}

    public function index(): View
    {
        $userId = Auth::id();

        $totalRecords = MedicalRecord::where('user_id', $userId)->count();
        $totalFamily  = $this->familyRepo->getForUser($userId)->count();
        $totalShared  = SharedRecord::where('user_id', $userId)->where('is_active', true)->count();

        $recentRecords = MedicalRecord::with(['familyMember'])
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Aggregate all tags and their counts
        $allTags = MedicalRecord::where('user_id', $userId)
            ->whereNotNull('tags')
            ->get()
            ->flatMap(fn ($r) => $r->tags ?? [])
            ->filter()
            ->countBy()
            ->sortByDesc(fn ($count) => $count);

        $totalTags = $allTags->count();

        return view('dashboard', compact(
            'totalRecords', 'totalFamily', 'totalShared',
            'totalTags', 'recentRecords', 'allTags'
        ));
    }
}
