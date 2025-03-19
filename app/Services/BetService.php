<?php

namespace App\Services;

use App\Enums\BetStatus;
use App\Models\Bet;
use App\Models\User;

class BetService
{
    /**
     * @param array $betData
     * @return mixed
     * @throws \Exception
     */
    public function createBet(array $betData)
    {
        $user = User::find($betData['user_id']);

        if ($user->balance < $betData['total_amount']) {
            throw new \Exception("Not enough balance to bet", 402);
        }

        $betData['status'] = BetStatus::Pending;
        $bet = Bet::create($betData);

        if (!$bet->save()) {
            throw new \Exception("Failed to create bet.", 500);
        }

        $user->balance = $user->balance - $betData['total_amount'];
        $user->save();

        return $bet;
    }

//    public function checkBet(array $results)
//    {
//        $updatedBets = Bet::whereIn('event_id', array_column($results, 'id'))
//            ->where('status', 'pending')
//            ->get();
//
//        foreach ($updatedBets as $bet) {
//            $result = collect($results)->where('id', $bet->event_id);
//
//            if ($result) {
//                $user = $bet->user;
//                $isWin = false;
//                $totalWin = 0;
//
//                if (($bet->selected_team === 'home' && $result['home_score'] > $result['away_score']) ||
//                    ($bet->selected_team === 'away' && $result['away_score'] > $result['home_score'])) {
//
//                    $isWin = true;
//                    $totalWin = $bet->total_amount * $bet->odds;
//                }
//
//                $bet->status = $isWin ? 'won' : 'lost';
//                $bet->total_win = $totalWin;
//                $bet->save();
//
//                if ($isWin) {
//                    $user->balance += $totalWin;
//                }
//                $user->save();
//            }
//        }
//
//        return $updatedBets;
//    }
}
