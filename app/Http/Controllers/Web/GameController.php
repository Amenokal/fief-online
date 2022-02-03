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
use App\Custom\Helpers\Architect;
use App\Custom\Helpers\Librarian;
use App\Http\Controllers\Controller;
use App\Custom\Services\ArmyServices;
use App\Custom\Services\BankServices;
use App\Custom\Services\BootServices;
use App\Custom\Services\DeckServices;
use App\Custom\Services\TurnServices;

class GameController extends Controller
{


    public function index()
    {
        // dd(
        //     Soldier::where([
        //         'game_id'=>Game::current()->id,
        //         'type'=>'sergeant',
        //         'player_id'=>Local::player()->id,
        //         'village_id'=>Mayor::find('tournus')->id,
        //     ])->first()
        // );

        BootServices::init('vanilla');

        return view('layouts.game', [
            'player' => Local::player(),
            'player_cards' => Local::cards(),

            'families' => Realm::families(),
            'turn' => Realm::year(),
            'phases' => TurnServices::phaseNames(),
            'current_player' => Realm::currentPlayer(),

            'remaining_lords' => Realm::remainingLords(),
            'remaining_buildings' => Realm::remainingBuildings(),
            'next_lord_card' => Gipsy::nextCard('lord'),
            'next_event_card' => Gipsy::nextCard('event'),
            'lord_discard_pile' => Gipsy::discardedCards('lord'),
            'event_discard_pile' => Gipsy::discardedCards('event'),
            'inc_disasters' => Realm::incommingDisasters(),

            'villages' => Realm::villages(),
            'lords' => Realm::lords(),
            'army' => Realm::activeArmies(),
            'buildings' => Realm::buildings()
        ]);
    }

    public function update()
    {
        return view('components.game-content', [
            'player' => Local::player(),
            'playercards' => Local::cards(),

            'families' => Realm::families(),
            'turn' => Realm::year(),
            'phases' => TurnServices::phaseNames(),
            'currentplayer' => Realm::currentPlayer(),

            'remnlords' => Realm::remainingLords(),
            'remnbuildings' => Realm::remainingBuildings(),
            'nextlord' => Gipsy::nextCard('lord'),
            'nextevent' => Gipsy::nextCard('event'),
            'lorddiscard' => Gipsy::discardedCards('lord'),
            'eventdiscard' => Gipsy::discardedCards('event'),
            'disasters' => Realm::incommingDisasters(),

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
