<?php

namespace App\Repositories;

use App\DTO\FootballMatchDTO;
use App\Models\Event;

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

    public function eventExists(FootballMatchDTO $dto): bool
    {
        return Event::where('title', $dto->title)
                ->where('date', $dto->date)
                ->first() !== null;
    }
}
