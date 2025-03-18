<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Services\SportsApiService;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    public function __construct(
        protected EventService     $eventService,
        protected SportsApiService $sportsApiService
    )
    {
    }

    public function addEvents(): JsonResponse
    {
        $date =Carbon::now()->addDay()->format('Y-m-d');
        $eventsData = $this->sportsApiService->getEvents($date);

        if (!empty($eventsData)) {
            $createdEvents = $this->eventService->createEvents($eventsData);

            return response()->json(['created_events' => $createdEvents, 201]);
        }

        return response()->json(['message' => 'No events found'], 404);
    }
}
