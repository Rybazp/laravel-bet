<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\EventService;

class UpdateFootballMatchesCommand extends Command
{
    protected $signature = 'update:football-matches';
    protected $description = 'Update football matches';

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
            $this->eventService->addFootballMatches();

            $this->info('Football matches updated successfully!');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
