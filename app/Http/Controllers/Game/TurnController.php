<?php

namespace App\Http\Controllers\Game;

use App\Models\Games;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Custom\Services\TurnServices;
use App\Models\Game;

class TurnController extends Controller
{
    public static function giveTurn()
    {
        $turn = TurnServices::giveTurn();
        $message = $turn['phase'] >= 0 ?
            TurnServices::phaseNames()[$turn['phase']] :
            "La partie n'a pas encore commencée";

        return response()->json(['turn'=>$turn, 'message'=>$message]);
    }

    public static function changeTurn(Request $request)
    {
        TurnServices::changeTurn($request->phase);
    }

    public static function endTurn()
    {
        return TurnServices::passTurn();
    }

}
