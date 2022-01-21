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
use App\Custom\Helpers\Marechal;
use App\Custom\Helpers\GameCurrent;
use App\Http\Controllers\Controller;
use App\Custom\Services\BootServices;
use App\Custom\Services\DeckServices;
use App\Custom\Services\TurnServices;

class GameController extends Controller
{
    public function index(){
        
        // dd(Mayor::administrate());

        // dd(Marechal::evaluate('Henri'));
        // dd(Realm::lords());
        
        // TODO: make middleware for game booting
        BootServices::init('vanilla');

        return view('layouts.game', [
            'player' => Local::player(),
            'player_cards' => Local::cards(),
            
            'players' => Realm::families(),
            'turn' => Realm::year(),
            'currentPlayer' => Realm::currentPlayer(),

            'phases' => TurnServices::phaseNames(),
            'inc_disasters' => Realm::incommingDisasters()->count(),
            'next_event_card' => DeckServices::nextCards('event')->first(),

            'villages' => Realm::villages(),
            'occupied' => Realm::villages()->whereNotNull('player_id')->all(),
            'army' => Realm::activeArmies(),
            'lords' => Realm::lords(),
            'buildings' => Realm::buildings()
        ]);
    }
}
