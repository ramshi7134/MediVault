<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Share\CreateShareRequest;
use App\Http\Resources\MedicalRecord\MedicalRecordResource;
use App\Http\Resources\Share\SharedRecordResource;
use App\Repositories\MedicalRecordRepository;
use App\Services\ShareService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Share", description="Secure record sharing")
 */
class ShareController extends Controller
{
    public function __construct(
        private readonly ShareService $shareService,
        private readonly MedicalRecordRepository $recordRepository,
    ) {}

    /**
     * @OA\Post(
     *   path="/api/share/{record_id}",
     *   tags={"Share"},
     *   summary="Generate a shareable link for a record",
     *   security={{"sanctum":{}}},
     *   @OA\Parameter(name="record_id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\RequestBody(
     *     @OA\JsonContent(@OA\Property(property="expires_in_hours", type="integer", example=24))
     *   ),
     *   @OA\Response(response=201, description="Share link created"),
     *   @OA\Response(response=404, description="Record not found")
     * )
     */
    public function create(CreateShareRequest $request, int $recordId): JsonResponse
    {
        $record = $this->recordRepository->findForUser($recordId, $request->user()->id);

        if (! $record) {
            return response()->json(['message' => 'Record not found.'], 404);
        }

        $shared = $this->shareService->create(
            $record,
            $request->user()->id,
            $request->validated()['expires_in_hours'] ?? null,
        );

        return response()->json(['data' => new SharedRecordResource($shared)], 201);
    }

    /**
     * @OA\Get(
     *   path="/api/shared/{token}",
     *   tags={"Share"},
     *   summary="Access a shared record via token (public)",
     *   @OA\Parameter(name="token", in="path", required=true, @OA\Schema(type="string")),
     *   @OA\Response(response=200, description="Shared record"),
     *   @OA\Response(response=404, description="Link invalid or expired")
     * )
     */
    public function access(string $token): JsonResponse
    {
        $record = $this->shareService->access($token);

        if (! $record) {
            return response()->json(['message' => 'This link is invalid or has expired.'], 404);
        }

        $record->load(['familyMember', 'prescriptions']);

        return response()->json(['data' => new MedicalRecordResource($record)]);
    }
}
