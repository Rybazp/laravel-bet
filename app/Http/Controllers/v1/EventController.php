<?php

namespace App\Http\Controllers\v1;

use App\Services\EventService;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    /**
     * @param EventService $eventService
     */
    public function __construct(private readonly EventService $eventService)
    {
    }

    /**
     * @return JsonResponse
     */
    public function addFootballMatches(): JsonResponse
    {
        try {
            $createdEvents = $this->eventService->addFootballMatches();

            return response()->json(['events' => $createdEvents], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

//    public function getEventsResult(): JsonResponse
//    {
//        $results = $this->eventService->getResults();
//
//        if (empty($results)) {
//            return response()->json(['message' => 'No results'], 404);
//        }
//
//        return response()->json(['updated_results' => $results], 200);
//    }
}
