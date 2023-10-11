<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\LoggedIn;
use App\Models\JwtToken;

class UpdateOrStoreJwtTokenNotification
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
    public function handle(LoggedIn $event): void
    {
        $user = User::find($event->user_id);
        $loginTimes = [
            'last_used_at' => $event->loginTime->format('Y-m-d H:i:s'),
            'refreshed_at' => $event->loginTime->format('Y-m-d H:i:s'),
        ];

        $jwtToken = JwtToken::firstOrCreate([
            'user_id' => $user->id,
            'unique_id' => $user->uuid,
        ], $event->token);

        $jwtToken->update($loginTimes);
    }
}
