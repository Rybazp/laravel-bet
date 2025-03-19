<?php

namespace App\Http\Controllers\v1;

use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

//    public function getRanking(): JsonResponse
//    {
//        $ranking = $this->userService->getRanking();

//        return response()->json([
//            'ranking' => $ranking
//        ]);
//    }
}
