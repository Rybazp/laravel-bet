<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @method static create(array $betData)
 * @method static where(string $string, string $value)
 */
class Bet extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'bets';
    protected $fillable = [
        'user_id',
        'event_id',
        'prediction',
        'total_amount',
        'status',
        'total_win',
    ];
}
