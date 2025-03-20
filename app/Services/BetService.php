<?php

namespace App\Services;

use App\Enums\BetStatus;
use App\Models\Bet;
use App\Models\Event;
use App\Models\User;
use App\Repositories\BetRepository;
use MongoDB\Collection;

class BetService
{
    public function __construct(private readonly BetRepository $betRepository)
    {
    }

    /**
     * @param array $betData
     * @return Bet
     */
    public function createBet(array $betData): Bet
    {
        $user = User::find($betData['user_id']);

        if ($user->balance < $betData['total_amount']) {
            throw new \OutOfRangeException('Bet amount exceeds the maximum allowed', 403);
        }

        if (!in_array($betData['prediction'], ['home', 'away', 'draw'])) {
            throw new \InvalidArgumentException('Invalid prediction value. Allowed values are: home, away, draw.', 400);
        }

        $betData['status'] = BetStatus::Pending->value;
        $bet = $this->betRepository->create($betData);

        if (!$bet) {
            throw new \RuntimeException('Failed to create bet.', 500);
        }

        $user->balance = $user->balance - $betData['total_amount'];
        $user->save();

        return $bet;
    }

    /**
     * @return Collection
     */
    public function checkBet(): Collection
    {
        $updatedBets = Bet::where('status', BetStatus::Pending->value)->get();

        if ($updatedBets->isEmpty()) {
            throw new \RuntimeException('No bets with pending status.');
        }

        foreach ($updatedBets as $bet) {
            $event = Event::where('_id', $bet->event_id)->first();

            if ($event->result['home'] === null || $event->result['away'] === null) {
                continue;
            }

            $eventResult = $event->result;

            if (
                ($bet->prediction == 'home' && $eventResult == 'home') ||
                ($bet->prediction == 'away' && $eventResult == 'away') ||
                ($bet->prediction == 'draw' && $eventResult == 'draw')
            ) {
                $bet->status = BetStatus::Win->value;
                $bet->save();

                $user = $bet->user;
                $user->balance += $bet->amount * 2;
                $user->save();
            } else {
                $bet->status = BetStatus::Lose->value;
                $bet->save();
            }
        }

        return $updatedBets;
    }
}
