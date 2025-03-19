<?php

namespace App\Enums;

enum BetStatus: string
{
    case Pending = 'pending';
    case Win = 'win';
    case Lose = 'lose';
}
