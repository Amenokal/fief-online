<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use App\Custom\Services\TurnServices;

class TurnController extends Controller
{
    public static function endTurn()
    {
        TurnServices::passTurn();
    }

}
