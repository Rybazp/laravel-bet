<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'event_id' => $this->event_id,
            'prediction' => $this->prediction,
            'total_amount' => $this->total_amount,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'total_win' => $this->total_win,
        ];
    }
}
