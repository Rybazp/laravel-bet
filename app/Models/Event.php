<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static where(string $string, $null)
 * @method static find($event_id)
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
        'result'
    ];
}
