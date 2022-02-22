<?php

namespace App\Events\BannerInfo\NewTurn;

use Illuminate\Http\Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewTurnMessageForSelfEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $channel;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Request $request, string $message)
    {
        $this->channel = $request->user()->player->turn_order;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('special-'.$this->channel);
    }

    public function broadcastAs()
    {
        return 'newTurnBannerInfo';
    }
}
