<?php

namespace App\Http\Controllers\Web;

use App\Custom\Helpers\Local;
use App\Custom\Helpers\GameCurrent;
use App\Http\Controllers\Controller;
use App\Custom\Services\BootServices;
use App\Custom\Services\DeckServices;

class GameController extends Controller
{
    public function index(){
        
        // TODO: make middleware for game booting
        BootServices::init('vanilla');

        return view('layouts.game', [
            'player' => Local::player(),
            'player_cards' => Local::cards(),
            'handsize' => Local::cards()->count(),
            
            'players' => GameCurrent::players(),
            'currentPlayer' => GameCurrent::player(),
            'inc_disasters' => GameCurrent::inc_disasters()->count(),
            'next_event_card' => DeckServices::nextCards('event')->first()->type,
        ]);
    }
}
