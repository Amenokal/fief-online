<?php

namespace App\Http\Controllers\Web;

use App\Models\User;

use App\Models\Games;
use App\Models\Players;
use App\Custom\Helpers\EventDeck;
use App\Custom\Helpers\CurrentUser;
use App\Http\Controllers\Controller;
use App\Custom\Services\GameServices;
use App\Custom\Services\BootServices;

class GameController extends Controller
{

    
    public function index(){

        
        // TODO: make middleware for this 2 ->
        CurrentUser::connect();
        BootServices::init('vanilla');

        return view('layouts.game', [
            'players' => Games::current()->players(),
            'handsize' => Players::auth()->cards()->count(),
            'player_cards' => Players::auth()->cards(),
            'next_event_card' => EventDeck::nextCard()->first()->type,
            'player' => Players::auth(),
            'color' => Players::auth()->color,
            'inc_disasters' => EventDeck::inc_disasters()->count(),
            'currentPlayer' => GameServices::currentPlayer()
        ]);

    }

}
