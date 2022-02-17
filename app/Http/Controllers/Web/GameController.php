<?php

namespace App\Http\Controllers\Web;

use App\Models\Card;
use App\Models\Game;
use App\Models\User;
use App\Config\Config;
use App\Models\Player;
use App\Models\Soldier;
use App\Models\Village;
use App\Models\Building;
use App\Models\Villages;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Config\Soldiers\Lord;
use App\Custom\Helpers\Gipsy;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Realm;
use App\Config\Soldiers\Lords;
use App\Events\GameStartEvent;
use App\Config\Soldiers\Knight;
use App\Events\CreateGameEvent;
use App\Events\NewUserJoinGame;
use App\Custom\GameObjects\Army;
use App\Custom\Helpers\Marechal;
use App\Config\Elements\Soldiers;
use App\Config\Soldiers\Sergeant;
use App\Custom\Helpers\Architect;
use App\Custom\Helpers\Librarian;
use App\Events\CurrentPlayerEvent;
use App\Custom\Phases\StarterPhase;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Custom\Services\ArmyServices;
use App\Custom\Services\BankServices;
use App\Custom\Services\BootServices;
use App\Custom\Services\DeckServices;
use App\Custom\Services\TurnServices;
use App\Custom\Services\GameStartServices;

class GameController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->user()->player->soldiersHere(Village::get('marcamps')));
        // dd(Mayor::administrate());

        if(!Game::current()){
            return view('partials.game.lobby', [
                'game' => Game::current(),
                'users' => User::where('in_game', true)->get(),
                'phases' => TurnServices::phaseNames(),
            ]);
        }
        else {
            return view('partials.game.main', [
                'game' => Game::current(),

                'users' => User::where('in_game', true)->get(),
                'families' => Realm::families(),

                'player' => Local::player(),
                'player_cards' => $request->user()->player->inHandCards(),

                'turn' => Game::turn(),
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

    }

    public function update()
    {
        if(!Game::current()){
            return view('partials.game.lobby', [
                'game' => Game::current(),
                'users' => User::where('in_game', true)->get(),
                'phases' => TurnServices::phaseNames(),
            ]);
        }else{
            return view('components.game-content', [

                'game' => Game::current(),
                'users' => User::where('in_game', true)->get(),

                'player' => Local::player(),
                'playercards' => Local::cards(),

                'families' => Realm::families(),
                'turn' => Game::turn(),
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
    }

    public function showBoard(Request $request)
    {
        $player = Realm::families()->where('familyname', $request->house)->first();
        return view('components.player-board', [
            'player' => $player
        ]);
    }

    public function playerReady(Request $request){
        $request->user()->update(['in_game'=>true]);
        event(new NewUserJoinGame($request->user()));
    }

    public function start()
    {
        BootServices::init('vanilla');
        Game::current()->update([
            'is_started'=>true,
            'current_phase'=>0
        ]);
        event(new CreateGameEvent());
    }
}
