<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class LoggedIn
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public int $user_id;
    /**
     * @var array<string, string|array<string, string>> $token
     */
    public array $token;
    public Carbon $loginTime;

    /**
     * Create a new event instance.
     *
     * @param array<string, string|array<string, string>> $token
     */
    public function __construct(int $user_id, array $token, Carbon $loginTime)
    {
        $this->user_id = $user_id;
        $this->token = $token;
        $this->loginTime = $loginTime;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
