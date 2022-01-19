<?php

namespace App\Http\Controllers\Game;

use App\Models\Games;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Custom\Services\TurnServices;

class TurnController extends Controller
{
    public static function changeTurn(Request $request)
    {
        TurnServices::changeTurn($request->phase);
    }

    public static function endTurn()
    {
        return TurnServices::passTurn();
    }

}
