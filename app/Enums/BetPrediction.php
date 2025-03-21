<?php

namespace App\Enums;

enum BetPrediction: string
{
    case Home = 'home';
    case Away = 'away';
    case Draw = 'draw';

    public static function isValid(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function isWinning(array $result): bool
    {
        return match ($this) {
            self::Home => $result['home'] > $result['away'],
            self::Away => $result['away'] > $result['home'],
            self::Draw => $result['home'] === $result['away'],
        };
    }

    public function evaluate(array $result): BetStatus
    {
        return $this->isWinning($result) ? BetStatus::Win : BetStatus::Lose;
    }
}
