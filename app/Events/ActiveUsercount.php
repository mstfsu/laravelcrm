<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActiveUsercount implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function broadcastAs () {
        return 'counter';
    }

    public function broadcastQueue () {
        return 'broadcastable';
    }

    public function broadcastWith () {
        return [
            'active_count' => active_user_count(),
        ];
    }

    public function broadcastOn () {
        return new Channel('active-count');
    }
}
