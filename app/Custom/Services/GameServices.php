<?php

namespace App\Custom\Services;

use App\Models\Games;
use App\Models\Players;
use App\Models\EventCards;

class GameServices {

    public static function currentPlayer()
    {
        return Players::find(Games::current()->turn()->player);
    }

    public static function inc_disasters()
    {
        return EventCards::where(['on_board' => true])->get();
    }
    
}