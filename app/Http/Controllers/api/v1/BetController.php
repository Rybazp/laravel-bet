<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\BetRequest;
use App\Http\Resources\BetResource;
use App\Services\BetService;
use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse
     */
    public function makeBet(BetRequest $request): JsonResponse
    {
        $betData = $request->validated();

        try {
            $bet = $this->betService->createBet($betData);
            $betResource = BetResource::make($bet);

            return response()->json($betResource, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    /**
     * @return JsonResponse
     */
    public function checkBets(): JsonResponse
    {
        try {
            $updatedBets = $this->betService->checkBet();
            $betResource = BetResource::make($updatedBets);

            return response()->json($betResource, Response::HTTP_OK);
        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
