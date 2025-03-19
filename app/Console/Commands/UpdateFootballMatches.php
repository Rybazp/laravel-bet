<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\EventService;

class UpdateFootballMatches extends Command
{
    protected $signature = 'football:update-matches';
    protected $description = 'Update football matches';


    public function handle()
    {
        $lastUpdatedAt = Cache::get('last_football_matches_update');

    }
}
