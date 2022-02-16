<?php

namespace App\Events;

use App\Models\Card;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class drawFirstLordEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cardName;
    public $player;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Card $card, Player $player)
    {
        $this->cardName = $card->name;
        $this->player = $player->turn_order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('starter-phase');
    }

    public function broadcastAs()
    {
        return 'draw-first-lord-event';
    }
}
