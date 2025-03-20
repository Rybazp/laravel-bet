<?php

namespace App\Console;

use App\Console\Commands\UpdateFootballMatches;
use App\Console\Commands\UpdateFootballResults;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        UpdateFootballMatches::class,
        UpdateFootballResults::class,
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
