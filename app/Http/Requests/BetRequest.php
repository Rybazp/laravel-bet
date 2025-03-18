<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|string|exists:users,_id',
            'event_id' => 'required|string|exists:events,_id',
            'prediction' => 'required|string',
            'total_amount' => 'required|int',
        ];
    }
}
