<?php

namespace App\Custom\Phases;

use App\Models\Card;
use App\Models\Game;
use App\Models\Player;
use App\Models\Village;
use Illuminate\Http\Request;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Realm;
use App\Custom\Helpers\Marechal;
use App\Custom\Helpers\Architect;
use App\Events\drawFirstLordEvent;
use App\Custom\Services\DeckServices;
use App\Custom\Services\TurnServices;

class StarterPhase {

    public static function drawFirstLord(Player $player)
    {
        Card::getNext('lord')->update(['is_next'=>false]); // needed to avoid messing with next card index.

        $card = Card::where([
            'deck' => 'lord',
            'player_id' => null,
        ])
        ->where('gender', '!=', 'O')
        ->inRandomOrder()
        ->first();

        $player->draw($card);

        broadcast(new drawFirstLordEvent($card, $player))->toOthers();

        TurnServices::passTurn();
    }

    public static function chooseVillage(Village $village)
    {
        if(Local::player()->villages->isEmpty() && $village->player_id === null){
            $starter_army = ['sergeant',3,'knight',1];
            $lord = Local::cards()->first()->play();

            Architect::build(Realm::building('chateau'), $village, Local::player());
            Marechal::newLord($lord, $village);
            Marechal::recruit($starter_army, $village);
            Mayor::administrate();
            return response()->view('components.army', [
                    'families' => Realm::families(),
                    'village' => $village,
                ])
                ->withHeaders([
                    'playercolor' => Local::player()->color
                ]);
        }else{
            return response(['playercolor' => Local::player()->color, 'error' => 'ERROR: village already chosen']);
        }
    }

}
