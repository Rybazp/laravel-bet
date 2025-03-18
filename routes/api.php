<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\BetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/events', [EventController::class, 'addEvents']);
//Route::put('/events/results', [EventController::class, 'getEventsResult']);
Route::post('/bets', [BetController::class, 'makeBet']);
//Route::put('/bets/check', [BetController::class, 'checkBets']);
