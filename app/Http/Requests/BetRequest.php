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

    public function messages()
    {
        return [
            'user_id.exists' => 'User not found',
            'event_id.exists' => 'Event with this ID does not found',
            'prediction.string' => 'Prediction must be a string',
            'total_amount.int' => 'Total amount must be an integer',
        ];
    }
}
