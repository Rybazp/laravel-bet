<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    protected int $limit = 10;

    /**
     * @return Collection
     */
    public function getRankingByTotalWin(): Collection
    {
        return User::orderBy('total_win', 'desc')->limit($this->limit)->get();
    }

    /**
     * @return Collection
     */
    public function getRankingByTotalQuantityPrediction(): Collection
    {
        return User::orderBy('total_quantity_prediction', 'desc')->limit($this->limit)->get();
    }
}
