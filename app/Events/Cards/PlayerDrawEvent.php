<?php

namespace App\Events\Cards;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PlayerDrawEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $playerOrder;
    public $pile;
    public $nextCardType;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Request $request, Card $card, Card $nextCard)
    {
        $this->playerOrder = $request->user()->player->turn_order;
        $this->pile = $card->deck;
        $this->nextCardType = $nextCard->disaster ? 'disaster' : $nextCard->deck;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('game');
    }

    public function broadcastAs()
    {
        return 'draw';
    }
}
