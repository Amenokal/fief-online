<?php

namespace App\Events\BishopElection;

use Illuminate\Http\Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Events\PlayerVotedForBishopEvent;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BishopElectionEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $votes;
    public $canVote = [];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Request $request, array $votes)
    {
        $this->votes = $votes[$request->user()->player->color] > 1;

        foreach($votes as $key => $vote){
            if($vote !== 0){
                $this->canVote[] = $key;
            }
        }
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
        return 'bishopElection';
    }
}
