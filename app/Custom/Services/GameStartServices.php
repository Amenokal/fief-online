<?php

namespace App\Custom\Services;

use App\Models\Card;
use Illuminate\Http\Request;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Marechal;
use App\Custom\Helpers\Architect;
use App\Custom\Services\DeckServices;

class GameStartServices {

    public static function drawFirstLord()
    {
        if(Local::cards()->isEmpty()){

            $deck = DeckServices::nextCards('lord');
            $lord = $deck->skipUntil(function ($item) {
                return $item->gender === "M" || $item->gender === "F";
            });
            $card = $lord->first();
            Card::draw($card);
            DeckServices::shuffleDeck('lord');
            return $card->name;
        }
    }

    public static function chooseVillage(Request $request)
    {
        $village_name = $request->village;
        $village = Mayor::find($village_name);
        
        if(!$village->player_id && $request->village){
            $lord = Local::cards()->first();
            $lord->play();
            Architect::build('chateau', $village);
            Marechal::moveLord($lord, $village);
            Marechal::recruit(['sergeant',5,'knight',1], $village);
            return $village_name;
        }
    }

}