<?php

namespace App\Http\Controllers\Web;

use App\Models\Game;
use App\Models\User;
use App\Models\Title;
use App\Models\Player;
use App\Models\Soldier;
use Illuminate\Http\Request;
use App\Custom\Helpers\Gipsy;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Realm;
use App\Events\CreateGameEvent;
use App\Events\NewUserJoinGame;
use App\Http\Controllers\Controller;
use App\Custom\Services\BootServices;
use App\Custom\Services\TurnServices;

class GameController extends Controller
{
    public function index(Request $request)
    {
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
                'families' => Player::all(),

                'player' => $request->user()->player,
                'player_cards' => $request->user()->player->inHandCards(),

                'turn' => Game::turn(),
                'phases' => TurnServices::phaseNames(),
                'current_player' => Player::where('turn_order', Game::current()->current_player)->first(),

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
                'currentplayer' => Player::where('turn_order', Game::current()->current_player)->first(),

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

    public function showBoard(Request $request)
    {
        $player = Player::where('family_name', $request->house)->first();
        $sergLeft = Soldier::whereNull('village_id')
            ->where([
                'type' => 'sergeant',
                'player_id' => $player->id
            ])
            ->get();

        $knightLeft = Soldier::whereNull('village_id')
            ->where([
                'type' => 'knight',
                'player_id' => $player->id
            ])
            ->get();

        return view('components.player-board', [
            'player' => $player,
            'sergLeft' => $sergLeft,
            'knightLeft' => $knightLeft
        ]);
    }

    public function showModal(Request $request)
    {
        return view('components.modal', [
            'phase' => Game::current()->current_phase,
            'localPlayer' => $request->user()->player,
            'otherPlayer' => false,
            'players' => Player::all(),
            'bishopLords' => $request->user()->player->eligibleForBishopLords()
        ]);
    }


}
