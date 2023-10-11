<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\LoggedIn;

class UpdateUserLastLoginAtNotification
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
        $user->update(['last_login_at' => $event->loginTime->format('Y-m-d H:i:s')]);
    }
}
