<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewNotificationEvent implements ShouldBroadcastNow

{
    use Dispatchable, SerializesModels;

    public Notification $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel(
             'user.' . $this->notification->user_id
            )
        ];
    }

    public function broadcastAs(): string
    {
        return 'new-notification';
    }

    public function broadcastWith(): array
    {
        return [

           'request_id' => $this->notification->request_id,

           'action_url' => $this->notification->action_url,
            'id' => $this->notification->id,

            'title' => $this->notification->title,

            'message' => $this->notification->message,

            'type' => $this->notification->type,

            'created_at' =>
                $this->notification
                     ->created_at
                     ->format('Y-m-d H:i:s')

        ];
    }
}