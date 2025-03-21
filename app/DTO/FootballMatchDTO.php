<?php

namespace App\DTO;

use App\Enums\EventType;
use Carbon\Carbon;

class FootballMatchDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $type_of_sports,
        public readonly string $participants,
        public readonly string $date,
        public readonly EventType $type,
        public readonly array $result
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            sprintf('%s vs %s', $data['teams']['home']['name'], $data['teams']['away']['name']),
            'Football',
            sprintf('%s vs %s', $data['teams']['home']['name'], $data['teams']['away']['name']),
            Carbon::parse($data['fixture']['date'])->format('Y-m-d H:i'),
            EventType::getTypeFromStatus($data['fixture']['status']['long']),
            [
                'home' => $data['goals']['home'] ?? null,
                'away' => $data['goals']['away'] ?? null
            ]
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'type_of_sports' => $this->type_of_sports,
            'participants' => $this->participants,
            'date' => $this->date,
            'type' => $this->type->value,
            'result' => $this->result,
        ];
    }
}
