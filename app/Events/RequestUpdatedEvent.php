<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RequestUpdatedEvent implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function broadcastOn(): array
    {
        return [

            new PrivateChannel(
                'user.'.$this->userId
            )

        ];
    }

    public function broadcastAs(): string
    {
        return 'request-updated';
    }

    public function broadcastWith(): array
    {
        return [

            'refresh' => true,

            'time' => now()

        ];
    }
}