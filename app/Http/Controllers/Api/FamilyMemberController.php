<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FamilyMember\StoreFamilyMemberRequest;
use App\Http\Requests\FamilyMember\UpdateFamilyMemberRequest;
use App\Http\Resources\FamilyMember\FamilyMemberResource;
use App\Repositories\FamilyMemberRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Family", description="Family members management")
 */
class FamilyMemberController extends Controller
{
    public function __construct(
        private readonly FamilyMemberRepository $repository,
    ) {}

    /**
     * @OA\Get(
     *   path="/api/family-members",
     *   tags={"Family"},
     *   summary="List family members",
     *   security={{"sanctum":{}}},
     *   @OA\Response(response=200, description="List of family members")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $members = $this->repository->getForUser($request->user()->id);

        return response()->json(['data' => FamilyMemberResource::collection($members)]);
    }

    /**
     * @OA\Post(
     *   path="/api/family-members",
     *   tags={"Family"},
     *   summary="Add a family member",
     *   security={{"sanctum":{}}},
     *   @OA\Response(response=201, description="Family member created")
     * )
     */
    public function store(StoreFamilyMemberRequest $request): JsonResponse
    {
        $member = $this->repository->create($request->user()->id, $request->validated());

        return response()->json(['data' => new FamilyMemberResource($member)], 201);
    }

    /**
     * @OA\Get(
     *   path="/api/family-members/{id}",
     *   tags={"Family"},
     *   summary="Show a family member",
     *   security={{"sanctum":{}}},
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=200, description="Family member details"),
     *   @OA\Response(response=404, description="Not found")
     * )
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $member = $this->repository->findForUser($id, $request->user()->id);

        if (! $member) {
            return response()->json(['message' => 'Not found.'], 404);
        }

        return response()->json(['data' => new FamilyMemberResource($member)]);
    }

    /**
     * @OA\Put(
     *   path="/api/family-members/{id}",
     *   tags={"Family"},
     *   summary="Update a family member",
     *   security={{"sanctum":{}}},
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=200, description="Updated successfully"),
     *   @OA\Response(response=404, description="Not found")
     * )
     */
    public function update(UpdateFamilyMemberRequest $request, int $id): JsonResponse
    {
        $member = $this->repository->findForUser($id, $request->user()->id);

        if (! $member) {
            return response()->json(['message' => 'Not found.'], 404);
        }

        $updated = $this->repository->update($member, $request->validated());

        return response()->json(['data' => new FamilyMemberResource($updated)]);
    }

    /**
     * @OA\Delete(
     *   path="/api/family-members/{id}",
     *   tags={"Family"},
     *   summary="Delete a family member",
     *   security={{"sanctum":{}}},
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=200, description="Deleted successfully"),
     *   @OA\Response(response=404, description="Not found")
     * )
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $member = $this->repository->findForUser($id, $request->user()->id);

        if (! $member) {
            return response()->json(['message' => 'Not found.'], 404);
        }

        $this->repository->delete($member);

        return response()->json(['message' => 'Family member deleted.']);
    }
}
