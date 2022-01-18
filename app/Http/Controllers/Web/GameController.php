<?php

namespace App\Http\Controllers\Web;

use App\Models\Game;
use App\Models\Soldier;
use App\Models\Village;
use App\Models\Soldiers;
use App\Models\Villages;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Realm;
use App\Custom\Helpers\GameCurrent;
use App\Http\Controllers\Controller;
use App\Custom\Services\BootServices;
use App\Custom\Services\DeckServices;

class GameController extends Controller
{
    public function index(){
        
        // dd(Mayor::find('sigy'));
        // dd(Realm::villages());
        
        // TODO: make middleware for game booting
        BootServices::init('vanilla');

        return view('layouts.game', [
            'player' => Local::player(),
            'player_cards' => Local::cards(),
            
            'players' => Game::current()->players,
            'currentPlayer' => Game::current()->turn->player,
            'inc_disasters' => Realm::incommingDisasters()->count(),
            'next_event_card' => DeckServices::nextCards('event')->first()->type,

            'villages' => Realm::villages(),
            'occupied' => Realm::villages()->whereNull('player_id')->all(),
            'army' => Realm::armies(),
            'lords' => Realm::lords(),
            'buildings' => Realm::buildings()
        ]);
    }
}
