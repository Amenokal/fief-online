<?php

namespace App\Custom\Services;

use App\Models\GameTurns;
use App\Custom\Helpers\CurrentGame;

class TurnServices {

    public static function passTurn()
    {        
        $turn = CurrentGame::turn();
        $phases = json_decode(file_get_contents(storage_path('data/meta/turn.json')), true);

        if($turn->player < CurrentGame::players()->count()){
            $turn::increment('player');
        }else{
            $turn->update(['player'=>1]);
        }

        if($turn->phase <= count($phases)){
            $turn::increment('phase');
        }else{
            $turn->update(['phase'=>1]);
        }
        
        if($turn->phase === count($phases)){
            $turn::increment('turn');
        }

        $message = $phases[$turn->phase];
        return response()->json($message);
    }

}