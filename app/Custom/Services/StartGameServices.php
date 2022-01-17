<?php

namespace App\Custom\Services;

class StartGameServices {

    public static function drawFirstLord()
    {
        $card = DeckServices::nextCards('lord')->first();
        if($card->type === 'O'){
            DeckServices::shuffle('lord');
            self::drawFirstLord();
        }else{
            PlayerServices::drawCard('lord');
        }

        return $card;
    }
}