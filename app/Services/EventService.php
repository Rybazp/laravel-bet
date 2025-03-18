<?php

namespace App\Services;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EventService
{
    public function __construct(
        protected SportsApiService $sportsApiService)
    {
    }

    public function createEvents(array $eventsData)
    {
        $createdEvents = [];

        foreach ($eventsData as $event) {
            if (isset($event['teams']['home']['name'], $event['teams']['away']['name'], $event['fixture']['date'])) {
                $eventDate = Carbon::parse($event['fixture']['date']);
                $eventData = [
                    'title' => $event['teams']['home']['name'] . ' vs ' . $event['teams']['away']['name'],
                    'type_of_sports' => 'Football',
                    'participants' => $event['teams']['home']['name'] . ' vs ' . $event['teams']['away']['name'],
                    'date' => $eventDate->format('Y-m-d H:i'),
                ];

                $createdEvents[] = Event::create($eventData);
            }
        }

        return $createdEvents;
    }
}
