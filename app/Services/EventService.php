<?php

namespace App\Services;

use App\Client\SportApiClient;
use App\DTO\FootballMatchDTO;
use App\Models\Event;
use App\Repositories\EventRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
//        $date = Carbon::now()->addDay()->format('Y-m-d');
        $eventsData = $this->sportsApiClient->getCurrentFootballMatches($date);

        if (empty($eventsData)) {
            return [];
        }

        foreach ($eventsData as $event) {
            if (isset($event['teams']['home']['name'], $event['teams']['away']['name'], $event['fixture']['date'])) {
                $dto = FootballMatchDTO::fromArray($event);

                if ($this->eventRepository->eventExists($dto)) {
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
     * @return array
     */
    public function updateFootballMatchesResults(): array
    {
        $events = Event::whereNull('results->home')
            ->whereNull('results->away')
            ->get();

        if ($events->isEmpty()) {
            throw new ModelNotFoundException('No events to update.');
        }

        $eventIds = $events->pluck('id')->toArray();
        $apiResults = $this->sportsApiClient->getResultsFootballMatches($eventIds);
        $apiResults = collect($apiResults);
        $updatedEvents = [];

        foreach ($events as $event) {
            $apiResult = $apiResults->firstWhere('event_id', $event->id);

            if ($apiResult && isset($apiResult['home_result']) && isset($apiResult['away_result'])) {
                $footballMatchDTO = FootballMatchDTO::fromArray($apiResult);

                $event->update([
                    'results' => [
                        'home' => $footballMatchDTO->result['home'],
                        'away' => $footballMatchDTO->result['away'],
                    ]
                ]);

                $updatedEvents[] = $event;

//                ProcessMatchResultJob::dispatch($event, $apiResult);
            }
        }

        if (empty($updatedEvents)) {
            throw new \RuntimeException('No events updated with new results.');
        }

        return $updatedEvents;
    }

    /**
     * @return Collection
     */
    public function getActualFootballMatches(): Collection
    {
        $today = Carbon::tomorrow()->format('Y-m-d');
        $cacheKey = 'today_football_events_' . $today;
        $events = Cache::get($cacheKey);

        if ($events) {
            return $events;
        }

        $events = $this->eventRepository->getFootballMatchesForToday($today);

        if ($events->isEmpty()) {
            return collect();
        }

        Cache::store('redis')->put($cacheKey, $events, 10);

        return $events;
    }
}
