<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Share\CreateGroupShareRequest;
use App\Http\Requests\Share\CreateShareRequest;
use App\Http\Resources\MedicalRecord\MedicalRecordResource;
use App\Http\Resources\Share\SharedRecordResource;
use App\Repositories\MedicalRecordRepository;
use App\Services\ShareService;
use Illuminate\Http\JsonResponse;

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
     * @OA\Post(
     *   path="/api/share/group/{group}",
     *   tags={"Share"},
     *   summary="Generate a shareable link for all records in a group",
     *   security={{"sanctum":{}}},
     *   @OA\Parameter(name="group", in="path", required=true, @OA\Schema(type="string")),
     *   @OA\RequestBody(
     *     @OA\JsonContent(@OA\Property(property="expires_in_hours", type="integer", example=24))
     *   ),
     *   @OA\Response(response=201, description="Group share link created"),
     *   @OA\Response(response=404, description="No records found for this group")
     * )
     */
    public function createGroup(CreateGroupShareRequest $request, string $group): JsonResponse
    {
        $records = $this->recordRepository->getGroupForUser($request->user()->id, $group);

        if ($records->isEmpty()) {
            return response()->json(['message' => 'No records found for this group.'], 404);
        }

        $shared = $this->shareService->createForGroup(
            $group,
            $request->user()->id,
            $request->validated()['expires_in_hours'] ?? null,
        );

        return response()->json(['data' => new SharedRecordResource($shared)], 201);
    }

    /**
     * @OA\Get(
     *   path="/api/shared/{token}",
     *   tags={"Share"},
     *   summary="Access a shared record or group via token (public)",
     *   @OA\Parameter(name="token", in="path", required=true, @OA\Schema(type="string")),
     *   @OA\Response(response=200, description="Shared record or group of records"),
     *   @OA\Response(response=404, description="Link invalid or expired")
     * )
     */
    public function access(string $token): JsonResponse
    {
        $shared = $this->shareService->getSharedByToken($token);

        if (! $shared) {
            return response()->json(['message' => 'This link is invalid or has expired.'], 404);
        }

        if ($shared->group) {
            $result = $this->shareService->accessGroup($shared);

            return response()->json([
                'data' => [
                    'type'    => 'group',
                    'group'   => $result['group'],
                    'records' => MedicalRecordResource::collection($result['records']),
                ],
            ]);
        }

        $record = $this->shareService->access($shared);
        $record->load(['familyMember', 'prescriptions']);

        return response()->json(['data' => new MedicalRecordResource($record)]);
    }
}
