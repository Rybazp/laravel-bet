<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type_of_sports' => $this->type_of_sports,
            'participants' => $this->participants,
            'date' => $this->date,
            'type' => $this->type,
            'result' => $this->result,
        ];
    }
}
