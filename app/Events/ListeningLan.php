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
use Auth;
class ListeningLan implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    private  $nas;
    private $admin_id;
    private $status;
    public function __construct($nas,$status,$admin_id)
    { 
      $this->nas=$nas;
      $this->status=$status;
      $this->admin_id=$admin_id;

    }


    public function broadcastWith () {

        return [
            'nas'       => $this->nas->shortname,
             'status'=> $this->status

        ];
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {

        return new Channel('LanChannel'.$this->admin_id.$this->nas->id);
    }
}
