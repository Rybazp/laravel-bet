<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRankingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'filter' => 'required|in:total_win,total_quantity_prediction',
        ];
    }
}
