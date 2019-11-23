<?php

namespace App\Listeners;

use App\Notifications\ApiTokenGenerationNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class VerifiedUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        // Verified user will automatically get a generated API token via mail.
        $token = $event->user->updateApiToken(false);
        $event->user->notify(new ApiTokenGenerationNotification($token));
    }
}
