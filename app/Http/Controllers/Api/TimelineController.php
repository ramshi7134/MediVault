<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicalRecord\MedicalRecordResource;
use App\Repositories\MedicalRecordRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Timeline", description="Chronological record timeline")
 */
class TimelineController extends Controller
{
    public function __construct(
        private readonly MedicalRecordRepository $repository,
    ) {}

    /**
     * @OA\Get(
     *   path="/api/timeline",
     *   tags={"Timeline"},
     *   summary="Get chronological timeline of medical records",
     *   security={{"sanctum":{}}},
     *   @OA\Response(response=200, description="Timeline grouped by year-month")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $records = $this->repository->getTimelineForUser($request->user()->id);

        $grouped = $records->groupBy(function ($record) {
            return $record->visit_date
                ? $record->visit_date->format('Y-m')
                : $record->created_at->format('Y-m');
        });

        $timeline = $grouped->map(function ($items, $period) {
            return [
                'period'  => $period,
                'records' => MedicalRecordResource::collection($items),
            ];
        })->values();

        return response()->json(['data' => $timeline]);
    }
}
