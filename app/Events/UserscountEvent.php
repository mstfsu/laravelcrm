<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use Log;
use App\Models\Subscriber;
class UserscountEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    private  $admin_id;
    public function __construct()
    {
log::info('cccccccccccccccccccccccccccccc');

        //
    }
    public function broadcastWith () {
        $online=Subscriber::getonlinecount();
        $active=Subscriber::getactivecount();
        log::info('AAAAAAAAAAAa'.$online);
        return [
            'online'       => $online,
            'active' =>$active

        ];
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('UserCount');
    }
}
