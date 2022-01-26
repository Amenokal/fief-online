<?php

namespace App\Http\Controllers\Web;

use App\Models\Card;
use App\Models\Game;
use App\Models\Soldier;
use App\Models\Village;
use App\Models\Building;
use App\Models\Soldiers;
use App\Models\Villages;
use Illuminate\Http\Request;
use App\Custom\Helpers\Gipsy;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Realm;
use App\Custom\Helpers\Marechal;
use App\Custom\Helpers\Librarian;
use App\Http\Controllers\Controller;
use App\Custom\Services\ArmyServices;
use App\Custom\Services\BankServices;
use App\Custom\Services\BootServices;
use App\Custom\Services\DeckServices;
use App\Custom\Services\TurnServices;

class GameController extends Controller
{


    public function index(){

        // dd(Local::player()->lords()->skip(0)->first()->name);

        // BankServices::income();

        // dd(ArmyServices::letOne(Marechal::armyOf(Realm::lord('Charles')),Realm::lord('Charles'))['moving']);

        // $filtered = $collection->filter(function ($value, $key) {
        //     return $value > 2;
        // });

        // TODO: make middleware for game booting
        BootServices::init('vanilla');

        return view('layouts.game', [
            'player' => Local::player(),
            'player_cards' => Local::cards(),

            'families' => Realm::families(),
            'turn' => Realm::year(),
            'phases' => TurnServices::phaseNames(),
            'currentPlayer' => Realm::currentPlayer(),

            'remaining_lords' => Realm::remainingLords(),
            'remaining_buildings' => Realm::remainingBuildings(),
            'next_lord_card' => Gipsy::nextCard('lord'),
            'next_event_card' => Gipsy::nextCard('event'),
            'lord_discard_pile' => Gipsy::discardedCards('lord'),
            'event_discard_pile' => Gipsy::discardedCards('event'),
            'inc_disasters' => Realm::incommingDisasters()->count(),

            'villages' => Realm::villages(),
            'lords' => Realm::lords(),
            'army' => Realm::activeArmies(),
            'buildings' => Realm::buildings()
        ]);
    }

    public function showBoard(Request $request)
    {
        $player = Realm::families()->where('familyname', $request->house)->first();
        return view('components.player-board', [
            'player' => $player
        ]);
    }
}
