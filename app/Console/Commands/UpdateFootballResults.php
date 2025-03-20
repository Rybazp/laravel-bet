<?php

namespace App\Console\Commands;

use App\Services\EventService;
use Illuminate\Console\Command;

class UpdateFootballResults extends Command
{
    protected $signature = 'update:football-results';
    protected $description = 'update football matches results';

    public function __construct(private readonly EventService $eventService)
    {
        parent::__construct();
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        try {
            $this->eventService->updateFootballMatchesResults();
            $this->info('update football matches results');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
