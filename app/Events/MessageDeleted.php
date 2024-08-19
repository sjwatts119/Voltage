<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageDeleted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public $message_id, public $conversation_id)
    {
        // Constructor requires the message_id and conversation_id of the message to be sent
    }


    public function broadcastAs()
    {
        return 'MessageDeleted';
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('Voltage-Conversation'),
        ];
    }
}
