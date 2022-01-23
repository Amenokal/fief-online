<?php

namespace App\Custom\Services;

use App\Models\Card;
use App\Models\Game;
use App\Models\Village;
use Illuminate\Http\Request;
use App\Custom\Helpers\Gipsy;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Architect;
use App\Custom\Services\ArmyServices;

class GameStartServices {

    public static function drawFirstLord()
    {
        if(Local::cards()->isEmpty()){
            Game::current()->cards()
            ->where(['deck' => 'lord'])
            ->update(['is_next'=>false]);

            Card::where([
                'game_id' => Game::current()->id,
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

            Architect::build('chateau', $village);
            ArmyServices::newLord($lord, $village);
            ArmyServices::recruit($starter_army, $village);
            Mayor::administrate();
            return view('components.army', [
                'families' => Local::player(),
                'village' => $village,
            ]);
        }else{
            return response(['error' => 'ERROR: village already chosen']);
        }
    }

}
