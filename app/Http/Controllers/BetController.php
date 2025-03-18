<?php

namespace App\Http\Controllers;

use App\Http\Requests\BetRequest;
use App\Services\BetService;
use Illuminate\Http\JsonResponse;

class BetController extends Controller
{
    public function __construct(protected BetService $betService)
    {
    }

    public function makeBet(BetRequest $request): JsonResponse
    {
        $betData = $request->validated();
        $bet = $this->betService->createBet($betData);

        if ($bet) {
            return response()->json([
                'bet' => $bet
            ], 201);
        }

        return response()->json(['message' => 'Failed bet'], 400);
    }
}
