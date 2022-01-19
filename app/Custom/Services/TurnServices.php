<?php

namespace App\Custom\Services;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Custom\Helpers\Realm;
use App\Custom\Helpers\Librarian;

class TurnServices {

    public static function phaseNames()
    {
        return Librarian::decipherJson('meta/turn.json');
    }

    public static function passTurn()
    {        
        $turn = Realm::year();
        $phases = Librarian::decipherJson('meta/turn.json');

        if($turn->player_id < Realm::families()->count()){
            $turn::increment('player_id');
            $data = ['player' => true];
        }else{
            $turn->update(['player_id'=>1]);
            $data = ['player' => true];
        }

        if($turn->phase < count($phases)){
            $turn::increment('phase');
            $data = ['phase' => true];
        }else{
            $turn->update(['phase'=>1]);
            $data = ['turn' => true];
        }
        
        if($turn->phase === count($phases)-1){
            $turn::increment('turn');
            ['turn' => true];
        }
        
        return Arr::add($data, 'color', Realm::currentPlayer()->color);
    }

    public static function changeTurn(int $phase_index)
    {
        Realm::year()->update(["phase" => $phase_index]);
    }

}