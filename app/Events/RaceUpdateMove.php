<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RaceUpdateMove implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;



    public function __construct( )
    {
        
    }

    public function broadcastOn()
    {
        return new Channel('raceUpdate');
    }

}
