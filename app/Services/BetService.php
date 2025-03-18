<?php

namespace App\Services;

use App\Models\Bet;
use App\Models\User;

class BetService
{
    public function createBet(array $betData)
    {
        $user = User::find($betData['user_id']);

        if ($user && $user->balance >= $betData['total_amount']) {
            $bet = new Bet($betData);
            $bet->status = 'pending';

            if (!$bet->save()) {
                return null;
            }

            $user->balance = $user->balance - $betData['total_amount'];
            $user->save();

            return $bet;
        }

        return null;
    }
}
