<?php

namespace App\DTO;

use Carbon\Carbon;

class FootballMatchDTO
{
    public function __construct(
        public string $title,
        public string $type_of_sports,
        public string $participants,
        public string $date,
        public array $result
    ) {
    }

    public static function fromArray(array $data): self
    {
        $dto = new self(
            '',
            '',
            '',
            '',
            []
        );
        $dto->title = sprintf('%s vs %s', $data['teams']['home']['name'], $data['teams']['away']['name']);
        $dto->type_of_sports = 'Football';
        $dto->participants = $dto->title;
        $dto->date = Carbon::parse($data['fixture']['date'])->format('Y-m-d H:i');
        $dto->result = [
            'home' => $data['score']['home'] ?? null,
            'away' => $data['score']['away'] ?? null
        ];

        return $dto;
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
            'result' => $this->result,
        ];
    }
}
