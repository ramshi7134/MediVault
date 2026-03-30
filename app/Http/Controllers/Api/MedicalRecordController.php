<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalRecord\StoreMedicalRecordRequest;
use App\Http\Resources\MedicalRecord\MedicalRecordResource;
use App\Repositories\MedicalRecordRepository;
use App\Services\MedicalRecordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="MedicalRecords", description="Medical records management")
 */
class MedicalRecordController extends Controller
{
    public function __construct(
        private readonly MedicalRecordRepository $repository,
        private readonly MedicalRecordService $service,
    ) {}

    /**
     * @OA\Get(
     *   path="/api/records",
     *   tags={"MedicalRecords"},
     *   summary="List medical records",
     *   security={{"sanctum":{}}},
     *   @OA\Parameter(name="document_type", in="query", @OA\Schema(type="string")),
     *   @OA\Parameter(name="doctor_name", in="query", @OA\Schema(type="string")),
     *   @OA\Parameter(name="hospital_name", in="query", @OA\Schema(type="string")),
     *   @OA\Parameter(name="from_date", in="query", @OA\Schema(type="string", format="date")),
     *   @OA\Parameter(name="to_date", in="query", @OA\Schema(type="string", format="date")),
     *   @OA\Parameter(name="family_member_id", in="query", @OA\Schema(type="integer")),
     *   @OA\Response(response=200, description="Paginated list of records")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'document_type', 'doctor_name', 'hospital_name',
            'from_date', 'to_date', 'family_member_id',
        ]);

        $records = $this->repository->getForUser($request->user()->id, $filters);

        return response()->json(MedicalRecordResource::collection($records)->response()->getData(true));
    }

    /**
     * @OA\Post(
     *   path="/api/records/upload",
     *   tags={"MedicalRecords"},
     *   summary="Upload a medical record",
     *   security={{"sanctum":{}}},
     *   @OA\RequestBody(required=true,
     *     @OA\MediaType(mediaType="multipart/form-data",
     *       @OA\Schema(
     *         required={"title","document_type","file"},
     *         @OA\Property(property="title", type="string"),
     *         @OA\Property(property="document_type", type="string", enum={"prescription","lab","invoice","report","other"}),
     *         @OA\Property(property="file", type="string", format="binary"),
     *         @OA\Property(property="hospital_name", type="string"),
     *         @OA\Property(property="doctor_name", type="string"),
     *         @OA\Property(property="visit_date", type="string", format="date"),
     *         @OA\Property(property="family_member_id", type="integer")
     *       )
     *     )
     *   ),
     *   @OA\Response(response=201, description="Record uploaded")
     * )
     */
    public function upload(StoreMedicalRecordRequest $request): JsonResponse
    {
        $data = $request->validated();
        $file = $request->file('file');

        unset($data['file']);

        $record = $this->service->store($request->user()->id, $file, $data);
        $record->load(['familyMember', 'prescriptions']);

        return response()->json(['data' => new MedicalRecordResource($record)], 201);
    }

    /**
     * @OA\Get(
     *   path="/api/records/{id}",
     *   tags={"MedicalRecords"},
     *   summary="Get a medical record",
     *   security={{"sanctum":{}}},
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=200, description="Record details"),
     *   @OA\Response(response=404, description="Not found")
     * )
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $record = $this->repository->findForUser($id, $request->user()->id);

        if (! $record) {
            return response()->json(['message' => 'Not found.'], 404);
        }

        return response()->json(['data' => new MedicalRecordResource($record)]);
    }

    /**
     * @OA\Delete(
     *   path="/api/records/{id}",
     *   tags={"MedicalRecords"},
     *   summary="Delete a medical record",
     *   security={{"sanctum":{}}},
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=200, description="Deleted"),
     *   @OA\Response(response=404, description="Not found")
     * )
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $record = $this->repository->findForUser($id, $request->user()->id);

        if (! $record) {
            return response()->json(['message' => 'Not found.'], 404);
        }

        $this->service->delete($record);

        return response()->json(['message' => 'Record deleted.']);
    }
}
