<?php

namespace App\Jobs;

use App\DTO\FootballMatchDTO;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessMatchResultJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected $apiResult,
        protected $event
    ) {
    }

    public function handle(): void
    {
        User::chunk(10, function ($users) {
            foreach ($users as $user) {
                Log::info('Match result: ' . $this->event->results['home'] . ' - ' . $this->event->results['away']);
            }
        });
    }
}
