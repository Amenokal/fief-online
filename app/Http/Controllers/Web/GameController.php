<?php

namespace App\Http\Controllers\Web;

use App\Custom\Helpers\Local;
use App\Custom\Helpers\GameCurrent;
use App\Http\Controllers\Controller;
use App\Custom\Services\BootServices;
use App\Custom\Services\DeckServices;
use App\Models\Soldiers;
use App\Models\Villages;

class GameController extends Controller
{
    public function index(){
        
        // TODO: make middleware for game booting
        BootServices::init('vanilla');

        $occupied_villages = Villages::where('game_id', GameCurrent::id())
        ->whereNull('player_id')
        ->get();
        // dd($occupied_villages);

        $villages = Villages::all();
        $army = Soldiers::all();

        return view('layouts.game', [
            'player' => Local::player(),
            'player_cards' => Local::cards(),
            
            'players' => GameCurrent::players(),
            'currentPlayer' => GameCurrent::player(),
            'inc_disasters' => GameCurrent::inc_disasters()->count(),
            'next_event_card' => DeckServices::nextCards('event')->first()->type,

            'villages' => $villages,
            'occupied' => $occupied_villages,
            'army' => $army
        ]);
    }
}
