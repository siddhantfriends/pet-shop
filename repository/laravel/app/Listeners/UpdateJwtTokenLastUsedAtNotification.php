<?php

namespace App\Listeners;

use App\Models\JwtToken;
use App\Events\TokenLastUsed;

class UpdateJwtTokenLastUsedAtNotification
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
    public function handle(TokenLastUsed $event): void
    {
        JwtToken::where('unique_id', $event->uuid)
            ->update(['last_used_at' => $event->lastUsedAt->format('Y-m-d H:i:s')]);
    }
}
