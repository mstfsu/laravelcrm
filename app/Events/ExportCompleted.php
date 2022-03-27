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
class ExportCompleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    protected $file;
    protected $user;
    public function __construct($user,$file)
    {
        log::info($this->user ."EVVVVVVVVVVVVVVVVVVVVVVVvvv");
        $this->user=$user;
        $this->file=$file;
        //
    }
    public function broadcastWith () {

        return [
            'user'       => $this->user,
            'file'       => $this->file,


        ];
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {log::info($this->user."heeeeeeeeeeeeeeeeeeeeeee");
        return new Channel('ExportChannel'.$this->user->id);
    }
}
