<?php

namespace App\Custom\Services;

use App\Models\Villages;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Marechal;
use App\Custom\Helpers\Architect;
use App\Custom\Helpers\GameCurrent;

class StartGameServices {

    public static function drawFirstLord()
    {
        $deck = DeckServices::nextCards('lord');
        foreach($deck as $card){
            if($card->gender !== 'O'){
                $card = PlayerServices::drawCard('lord');
                PlayerServices::play($card);
                return $card;
            }
        }
        DeckServices::shuffle('lord');
    }

    public static function chooseVillage($village_name)
    {
        $village = Mayor::craft($village_name);
        $lord = Local::cards()->first();

        if(!$village->village_id){
            $village->update(['player_id' => Local::player()->id]);

            Architect::build('chateau', $village_name);

            Marechal::moveLord($lord, $village);
            Marechal::newArmy(['sergeant',5,'knight',1], $village);
            return $village_name;
        }
    }

}