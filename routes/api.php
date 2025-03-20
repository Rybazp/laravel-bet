<?php

use App\Http\Controllers\api\v1\BetController;
use App\Http\Controllers\api\v1\EventController;
use App\Http\Controllers\api\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/v1')->group(function () {
    Route::get('/events', [EventController::class, 'addFootballMatches']);
    Route::get('/events/actual', [EventController::class, 'getActualFootballMatches']);
//    Route::get('/events/results', [EventController::class, 'updateResults']);
    Route::post('/bets', [BetController::class, 'makeBet']);
    Route::get('/bets/check', [BetController::class, 'checkBets']);
    Route::get('/user/ranking', [UserController::class, 'getUserRanking']);
});
