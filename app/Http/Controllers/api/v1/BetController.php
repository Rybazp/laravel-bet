<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\BetRequest;
use App\Http\Resources\BetResource;
use App\Services\BetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class BetController extends Controller
{
    /**
     * @param BetService $betService
     */
    public function __construct(private readonly BetService $betService)
    {
    }

    /**
     * @param BetRequest $request
     * @return JsonResponse|BetResource
     */
    public function makeBet(BetRequest $request): JsonResponse|BetResource
    {
        $betData = $request->validated();

        try {
            $bet = $this->betService->createBet($betData);

            return BetResource::make($bet);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    /**
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function checkBets(): JsonResponse|AnonymousResourceCollection
    {
        try {
            $updatedBets = $this->betService->checkBet();

            return BetResource::collection($updatedBets);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
