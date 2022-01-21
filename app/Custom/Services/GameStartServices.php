<?php

namespace App\Custom\Services;

use App\Models\Card;
use App\Models\Village;
use Illuminate\Http\Request;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Marechal;
use App\Custom\Helpers\Architect;
use App\Custom\Services\ArmyServices;
use App\Custom\Services\DeckServices;

class GameStartServices {

    public static function drawFirstLord()
    {
        if(Local::cards()->isEmpty()){

            $deck = DeckServices::nextCards('lord');
            $lord = $deck->skipUntil(function ($item) {
                return $item->gender !== 'O';
            })->first();
            Card::draw($lord);
            return $lord;
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
            return $lord;
        }
    }

}