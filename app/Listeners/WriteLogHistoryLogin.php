<?php

namespace App\Listeners;

use App\Events\LogHistoryLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class WriteLogHistoryLogin implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LogHistoryLogin $event): void
    {
        Log::debug('User Login', [
            'user' => $event->user,
            'token' => $event->token
        ]);
    }
}
