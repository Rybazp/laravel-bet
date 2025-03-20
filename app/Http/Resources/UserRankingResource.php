<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRankingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'balance' => $this->balance,
            'true_prediction' => $this->true_prediction,
            'total_quantity_prediction' => $this->total_quantity_prediction,
            'total_win' => $this->total_win,
        ];
    }
}
