<?php

namespace App\Custom\Services;

use App\Custom\Helpers\Realm;
use App\Custom\Helpers\Librarian;
use App\Custom\Helpers\GameCurrent;

class TurnServices {

    public static function phaseNames()
    {
        $phases = Librarian::decipherJson('meta/turn.json');
        dd($phases);
    }

    public static function passTurn()
    {        
        $turn = Realm::year();
        $phases = json_decode(file_get_contents(storage_path('data/meta/turn.json')), true);

        if($turn->player < Realm::families()->count()){
            $turn::increment('player');
        }else{
            $turn->update(['player'=>1]);
        }

        if($turn->phase < count($phases)){
            $turn::increment('phase');
        }else{
            $turn->update(['phase'=>1]);
        }
        
        if($turn->phase === count($phases)-1){
            $turn::increment('turn');
        }
        
        $message = $phases[$turn->phase]; // message = ? displayed with axios response;
        return response()->json($message);
    }

}