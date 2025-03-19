<?php

namespace App\Http\Controllers\v1;

use App\Http\Requests\BetRequest;
use App\Services\BetService;
use Illuminate\Http\JsonResponse;

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

            return response()->json([
                'bet' => $bet
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

//    public function checkBets(): JsonResponse
//    {
//        $updatedBets = $this->betService->checkBet((array)$events);
//
//        return response()->json([
//            'updated_bets' => $updatedBets
//        ]);
//    }
}
