<?php

namespace App\Repositories;

use App\DTO\FootballMatchDTO;
use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;

class EventRepository
{
    /**
     * @param array $data
     * @return Event
     */
    public function create(array $data): Event
    {
        return Event::create($data);
    }

    /**
     * @param string $today
     * @return Collection
     */
    public function getFootballMatchesForToday(string $today): Collection
    {
        return Event::where('date', 'like', $today . '%')
            ->orderBy('date')
            ->get();
    }

    /**
     * @param FootballMatchDTO $dto
     * @return Event
     */
    public function eventExists(FootballMatchDTO $dto): Event
    {
        return Event::where('title', $dto->title)
            ->where('date', $dto->date)
            ->first();
    }
}
