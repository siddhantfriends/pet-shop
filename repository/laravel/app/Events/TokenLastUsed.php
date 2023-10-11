<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class TokenLastUsed
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public string $uuid;
    public Carbon $lastUsedAt;

    /**
     * Create a new event instance.
     */
    public function __construct(string $uuid, Carbon $lastUsedAt)
    {
        $this->uuid = $uuid;
        $this->lastUsedAt = $lastUsedAt;
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
