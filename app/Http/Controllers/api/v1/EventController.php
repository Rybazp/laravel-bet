<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Resources\EventResource;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function addFootballMatches(): JsonResponse|AnonymousResourceCollection
    {
        try {
            $createdEvents = $this->eventService->addFootballMatches();

            return EventResource::collection($createdEvents);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    /**
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getActualFootballMatches(): JsonResponse|AnonymousResourceCollection
    {
        try {
            $events = $this->eventService->getActualFootballMatches();

            return EventResource::collection($events);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
