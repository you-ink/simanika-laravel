<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContentNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $message;

    public function __construct($message, $user_id = "")
    {
        $this->user_id = $user_id;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('simanika-channel');
    }

    public function broadcastAs()
    {
        return 'simanika-event';
    }
}
