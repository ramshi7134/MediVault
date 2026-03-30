<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\MedicalRecordRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TimelineController extends Controller
{
    public function __construct(
        private readonly MedicalRecordRepository $repository,
    ) {}

    public function index(): View
    {
        $records = $this->repository->getTimelineForUser(Auth::id());

        // Group by YYYY-MM (use created_at for records without visit_date)
        $grouped = $records->groupBy(function ($record) {
            return $record->visit_date
                ? $record->visit_date->format('Y-m')
                : $record->created_at->format('Y-m');
        })->sortKeysDesc();

        return view('timeline', compact('grouped'));
    }
}
