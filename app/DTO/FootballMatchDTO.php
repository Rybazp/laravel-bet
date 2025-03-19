<?php

namespace App\DTO;

use Carbon\Carbon;

class FootballMatchDTO
{
    public string $title;
    public string $type_of_sports;
    public string $participants;
    public string $date;

    /**
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $dto = new self();
        $dto->title = sprintf('%s vs %s', $data['teams']['home']['name'], $data['teams']['away']['name']);
        $dto->type_of_sports = 'Football';
        $dto->participants = $dto->title;
        $dto->date = Carbon::parse($data['fixture']['date'])->format('Y-m-d H:i');

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
        ];
    }
}
