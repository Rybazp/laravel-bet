<?php

namespace App\Console;

use App\Console\Commands\UpdateFootballMatchesCommand;
use App\Console\Commands\UpdateFootballResultsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        UpdateFootballMatchesCommand::class,
        UpdateFootballResultsCommand::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('update:football-matches')->daily();
        $schedule->command('update:football-results')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
