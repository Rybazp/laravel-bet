<?php

namespace App\Enums;

enum EventType: string
{
    case Scheduled = 'scheduled';
    case In_play = 'in_play';
    case Finished = 'finished';
    case Postponed = 'postponed';
    case Cancelled = 'cancelled';
    case Not_played = 'not_played';
    case Abandoned = 'abandoned';

    public static function getTypeFromStatus(string $status): self
    {
        $status = strtolower(trim($status));

        return match ($status) {
            'match cancelled', 'cancelled' => self::Cancelled,
            'match in play', 'in_play' => self::In_play,
            'finished', 'match finished' => self::Finished,
            'postponed' => self::Postponed,
            'not played', 'not_played' => self::Not_played,
            'abandoned' => self::Abandoned,
            default => self::Scheduled,
        };
    }
}
