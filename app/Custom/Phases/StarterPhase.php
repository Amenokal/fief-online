<?php

namespace App\Custom\Phases;

use App\Models\Card;
use App\Models\Game;
use App\Models\Player;
use App\Models\Village;
use App\Models\Building;
use Illuminate\Http\Request;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Realm;
use App\Custom\Entities\Lord;
use App\Events\UpdateGameEvent;
use App\Custom\Helpers\Marechal;
use App\Custom\Helpers\Architect;
use App\Events\drawFirstLordEvent;
use App\Custom\Services\DeckServices;
use App\Custom\Services\TurnServices;

class StarterPhase {

    public static function getFirstLordsData(Request $request)
    {
        $players = Player::orderBy('turn_order')->get()->pluck('turn_order');
        $cards = Card::whereNotNull('player_id')->get();
        $isItMyCard = [];
        foreach($cards as $card){
            $isItMyCard[] = $card->player->id === $request->user()->player->id;
        }
        return response()->json(['cards'=>[$cards->pluck('name'), $players, $isItMyCard]]);
    }

    public static function isItMyTurnToChooseVillage(Request $request) : bool
    {
        Game::current()->update(['current_phase'=>1]);
        return $request->user()->id === Game::current()->current_player;
    }

    public static function chooseVillage(Request $request, Village $village)
    {
        $player = $request->user()->player;

        if($player->villages->isEmpty() && $village->player_id === null){

            $starter_army = ['sergeant',3,'knight',1];
            $lordName = $player->inHandCards()->first()->name;

            Lord::asCard($lordName)->update(['on_board'=>true]);
            Lord::asSoldier($lordName)->update([
                'village_id'=>$village->id,
                'player_id'=>$player->id
            ]);

            Building::get('castle')->buildAt($village);
            Marechal::recruit($starter_army, $village);
            Mayor::administrate();

            TurnServices::passTurn();

            event(new UpdateGameEvent());
        }
    }

}
