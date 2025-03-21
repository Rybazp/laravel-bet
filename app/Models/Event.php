<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @method static where(string $string, $event_id)
 */
class Event extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'events';
    protected $fillable = [
        'title',
        'type_of_sports',
        'participants',
        'date',
        'type',
        'result'
    ];
}
