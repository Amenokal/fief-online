<?php

namespace App\Custom\Services;

use App\Models\Games;
use App\Models\Players;

class GameServices {

    public static function currentPlayer()
    {
        return Players::find(Games::current()->turn()->player);
    }
}