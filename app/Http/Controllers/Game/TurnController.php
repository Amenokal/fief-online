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
        if(!Game::current()){
            return response(['phase' => -1]);
        }
        else{
            $turn = TurnServices::giveTurn();
            // $message = TurnServices::phaseNames()[$turn['phase']];

            return response()->json(['turn'=>$turn, 'phase'=>$turn['phase']]);
        }
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
