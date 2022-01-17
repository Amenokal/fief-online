<?php

namespace App\Http\Controllers\Web;

use App\Models\Players;

use App\Custom\Helpers\EventDeck;
use App\Custom\Helpers\CurrentGame;
use App\Custom\Helpers\CurrentUser;
use App\Http\Controllers\Controller;
use App\Custom\Helpers\CurrentPlayer;
use App\Custom\Services\GameBootServices;

class GameController extends Controller
{

    
    public function index(){

        
        // TODO: make middleware for this 2 ->
        CurrentUser::connect();
        GameBootServices::init('vanilla');



        return view('layouts.game', [
            'players' => Players::where('game_id', CurrentGame::get()->id)->get(),
            'handsize' => count(CurrentPlayer::cards()),
            'player_cards' => CurrentPlayer::cards(),
            'next_event_card' => EventDeck::nextCard()->first()->type,
            'player' => CurrentPlayer::get(),
            'inc_disasters' => EventDeck::inc_disasters()->count()
        ]);

    }

}
