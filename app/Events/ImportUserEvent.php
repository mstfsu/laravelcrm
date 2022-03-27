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
class ImportUserEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    protected $number;
    protected $type;
    protected $total;
    private $message;
    public function __construct($number,$total,$type,$message)
    {

        $this->number=$number;
        $this->type=$type;
        $this->total=$total;
        $this->message=$message;

    }
    public function broadcastWith () {

        return [
            'number'       => $this->number,
            'type' =>$this->type,
            'total'=>$this->total,
            'message'=>$this->message

        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('Import');
    }
}
