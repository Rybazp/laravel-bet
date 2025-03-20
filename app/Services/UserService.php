<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class UserService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }


    /**
     * @param string $filter
     * @return Collection
     */
    public function getUserRanking(string $filter): Collection
    {
        $cacheKey = 'user_ranking_' . $filter;
        $ranking = Cache::get($cacheKey);

        if (!$ranking) {
            if ($filter === 'total_win') {
                $ranking = $this->userRepository->getRankingByTotalWin();
            } elseif ($filter === 'total_quantity_prediction') {
                $ranking = $this->userRepository->getRankingByTotalQuantityPrediction();
            } else {
                return collect();
            }

            Cache::store('redis')->put($cacheKey, $ranking, 10);
        }

        return $ranking;
    }
}
