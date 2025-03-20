<?php

namespace App\Repositories;

use App\Models\Bet;

class BetRepository
{
    /**
     * @param array $data
     * @return Bet
     */
    public function create(array $data): Bet
    {
        return Bet::create($data);
    }
}
