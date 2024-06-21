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

class RaceCreate implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $time;
    public $creator;
    public $players;
    public function __construct($time, $creator, $players)
    {
        $this->time = $time;
        $this->creator = $creator;
        $this->players = $players;
    }

    public function broadcastOn()
    {
        return new Channel('race');
    }

    public function broadcastWith()
    {
        return [
            'time' => $this->time,
            'creator' => $this->creator,
            'players' => $this->players
        ];
    }
}
