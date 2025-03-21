<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Resources\UserRankingResource;
use App\Services\UserService;
use App\Http\Requests\UserRankingRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * @param UserRankingRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getUserRanking(UserRankingRequest $request): JsonResponse|AnonymousResourceCollection
    {
        try {
            $filter = $request->query('filter', 'total_win');
            $ranking = $this->userService->getUserRanking($filter);

            return UserRankingResource::collection($ranking);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
