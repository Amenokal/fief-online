<?php

namespace App\Http\Controllers\Web;

use App\Models\User;

use App\Models\Games;
use App\Models\Players;
use App\Http\Controllers\Controller;
use App\Custom\Services\GameServices;
use App\Custom\Services\BootServices;
use App\Custom\Services\DeckServices;

class GameController extends Controller
{

    
    public function index(){
        
        // TODO: make middleware for game booting
        BootServices::init('vanilla');

        return view('layouts.game', [
            'player' => Players::auth(),
            'player_cards' => Players::auth()->cards(),
            'handsize' => Players::auth()->cards()->count(),
            
            'players' => Games::current()->players(),
            'currentPlayer' => GameServices::currentPlayer(),
            'inc_disasters' => GameServices::inc_disasters()->count(),
            'next_event_card' => DeckServices::nextCard('event')->first()->type,
        ]);

    }

}
