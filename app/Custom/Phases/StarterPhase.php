<?php

namespace App\Custom\Phases;

use App\Models\Card;
use App\Models\Game;
use App\Models\Village;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Realm;
use App\Custom\Helpers\Marechal;
use App\Custom\Helpers\Architect;
use App\Custom\Services\DeckServices;

class StarterPhase {

    public static function drawFirstLord()
    {
        if(Local::cards()->isEmpty()){
            Game::current()->cards()
            ->where(['deck' => 'lord'])
            ->update(['is_next'=>false]);

            Card::where([
                'deck' => 'lord',
                'player_id' => null,
                'village_id' => null,
                'on_board' => false
            ])
            ->where('gender', '!=', 'O')
            ->inRandomOrder()
            ->first()
            ->update(['is_next'=>true]);

            return DeckServices::draw('lord', false);
        }
        else{
            return response(['error' => 'ERROR: lord already drawn']);
        }
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
