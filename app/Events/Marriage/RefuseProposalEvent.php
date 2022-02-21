<?php

namespace App\Events\Marriage;

use App\Custom\Entities\Lord;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RefuseProposalEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $channel;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $askingLord, string $askedLord)
    {
        $this->channel = Lord::asCard($askingLord)->player->turn_order;
        $this->message = ucfirst($askedLord)." ne souhaite pas se marrier avec ".ucfirst($askingLord);
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
        return 'refuseMarriage';
    }
}
