<?php

namespace App\Services;

use App\Client\SportApiClient;
use App\DTO\FootballMatchDTO;
use App\Repositories\EventRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class EventService
{
    public function __construct(
        private readonly SportApiClient  $sportsApiClient,
        private readonly EventRepository $eventRepository
    )
    {
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

        $date = Carbon::now()->format('Y-m-d');

        $eventsData = $this->sportsApiClient->getCurrentFootballMatches($date);

        if (empty($eventsData)) {
            return [];
        }

        foreach ($eventsData as $event) {
            if (isset($event['teams']['home']['name'], $event['teams']['away']['name'], $event['fixture']['date'])) {
                $dto = FootballMatchDTO::fromArray($event);

                $existingEvent = $this->eventRepository->eventExists($dto);

                if ($existingEvent && $existingEvent->type !== $dto->type->value) {
                    $existingEvent->update([
                        'type' => $dto->type->value,
                        'result' => $dto->result
                    ]);

                    continue;
                }

                $eventData = $dto->toArray();
                $createdEvents[] = $this->eventRepository->create($eventData);
            } else {
                throw new \InvalidArgumentException('Not enough data for mapping', 422);
            }
        }

        return $createdEvents;
    }

    /**
     * @return Collection|\Illuminate\Support\Collection
     */
    public function getActualFootballMatches(): Collection|array
    {
        $today = Carbon::now()->addDay()->format('Y-m-d');

        $cacheKey = 'today_football_events_' . $today;
        $events = Cache::get($cacheKey);

        if ($events) {
            return $events;
        }

        $events = $this->eventRepository->getFootballMatchesForToday($today);

        if ($events->isEmpty()) {
            return collect();
        }

        $events = $events->take(100);

        Cache::store('redis')->put($cacheKey, $events, 10);

        return $events;
    }
}
