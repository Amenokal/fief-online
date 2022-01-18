<?php

namespace App\Custom\Services;

use App\Models\Villages;
use App\Custom\Helpers\Local;
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
            }
        }
        DeckServices::shuffle('lord');
    }

    public static function chooseVillage(string $village_name)
    {
        $target = Villages::where(['name' => $village_name, 'player_id' => null]);
        if(!$target->exists()){
            Villages::where([
                'name' => $village_name,
                'game_id' => GameCurrent::self()->id
            ])
            ->first()
            ->update(['player_id' => Local::player()->id]);

            Architect::build('chateau', $village_name);
            
        }
    }

}