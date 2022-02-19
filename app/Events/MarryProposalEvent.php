<?php

namespace App\Events;

use App\Models\Player;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MarryProposalEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $channel;
    public $askingFamily;
    public $askingLord;
    public $askedFamily;
    public $askedLord;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Player $askingFamily, string $askingLordName, Player $askedFamily, string $askedLordName)
    {
        $this->channel = $askedFamily->turn_order;

        $this->askingFamily = $askingFamily->family_name;
        $this->askingLord = $askingLordName;
        $this->askedFamily = $askedFamily->family_name;
        $this->askedLord = $askedLordName;
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
        return 'marryProposal';
    }
}
