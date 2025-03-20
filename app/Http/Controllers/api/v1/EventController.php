<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Resources\EventResource;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
            $resourceCollection = EventResource::collection($createdEvents);

            return response()->json($resourceCollection, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    /**
     * @return JsonResponse
     */
    public function getActualFootballMatches(): JsonResponse
    {
        try {
            $events = $this->eventService->getActualFootballMatches();
            $resourceCollection = EventResource::collection($events);

            return response()->json($resourceCollection, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function updateResults()
    {
        try {
            $result = $this->eventService->updateFootballMatchesResults();
            $resourceCollection = EventResource::collection($result);

            return response()->json($resourceCollection, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
