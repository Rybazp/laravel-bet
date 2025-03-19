<?php

namespace App\Services;

use App\DTO\FootballMatchDTO;
use App\Repositories\EventRepository;
use Carbon\Carbon;

class EventService
{
    public function __construct(
        private readonly SportApiClient $sportsApiClient,
        private readonly EventRepository $eventRepository
    ) {
    }

    /**
     * Add football matches to the database.
     *
     * This method gets the current football matches for the next day
     * from an external sportsAPIClient, mapping the raw data to a DTO, and saved the events to the database
     * If the required data is missing in the response, an exception is thrown.
     *
     * @return array An array of created events
     *
     * @throws \Exception
     */
    public function addFootballMatches(): array
    {
        $createdEvents = [];
        $date = Carbon::now()->addDay()->format('Y-m-d');
        $eventsData = $this->sportsApiClient->getCurrentFootballMatches($date);

        foreach ($eventsData as $event) {
            if (isset($event['teams']['home']['name'], $event['teams']['away']['name'], $event['fixture']['date'])) {
                $dto = FootballMatchDTO::fromArray($event);

                if ($this->eventRepository->eventExists($dto)) {
                    throw new \Exception('Event already exists in the database: ' . $dto->title, 409);
                }

                $eventData = $dto->toArray();
                $createdEvents[] = $this->eventRepository->create($eventData);
            } else {
                throw new \Exception('Not enough data for mapping', 422);
            }
        }

        return $createdEvents;
    }

//    public function getResults()
//    {
//        $eventsWithoutResults = Event::whereNull('result')->get();
//        $eventIds = $eventsWithoutResults->pluck('event_id')->toArray();
//        $results = $this->sportsApiClient->getResultsFootballMatches($eventIds);
//
//        if (empty($results)) {
//            return [];
//        }
//
//        foreach ($results as $result) {
//            $event = Event::where('event_id', $result['id'])->first();
//            if ($event) {
//                $event->update(['result' => $result]);
//            }
//        }
//
//        return $results;
//    }
}
