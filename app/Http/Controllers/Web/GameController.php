<?php

namespace App\Http\Controllers\Web;

use App\Models\Card;
use App\Models\Game;
use App\Models\Soldier;
use App\Models\Village;
use App\Models\Soldiers;
use App\Models\Villages;
use Illuminate\Http\Request;
use App\Custom\Helpers\Gipsy;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Realm;
use App\Custom\Helpers\Marechal;
use App\Http\Controllers\Controller;
use App\Custom\Services\BootServices;
use App\Custom\Services\DeckServices;
use App\Custom\Services\TurnServices;

class GameController extends Controller
{


    public function index(){
        // dd(Mayor::find('st-médard')->lords()->exists(), Mayor::find('st-médard')->soldiers()->exists());
        // !$vilg->lords() && !$vilg->soldiers()

        // dd(Marechal::letOne(Realm::lord('Quentin'))['one']);

        // TODO: make middleware for game booting
        BootServices::init('vanilla');

        return view('layouts.game', [
            'player' => Local::player(),
            'player_cards' => Local::cards(),

            'families' => Realm::families(),
            'turn' => Realm::year(),
            'currentPlayer' => Realm::currentPlayer(),

            'phases' => TurnServices::phaseNames(),
            'inc_disasters' => Realm::incommingDisasters()->count(),
            'next_lord_card' => Gipsy::nextCard('lord'),
            'next_event_card' => Gipsy::nextCard('event'),
            'lord_discard_pile' => Gipsy::discardedCards('lord')->all(),
            'event_discard_pile' => Gipsy::discardedCards('event')->all(),

            'villages' => Realm::villages(),

            'army' => Realm::activeArmies(),
            'lords' => Realm::lords(),
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
