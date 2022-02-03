<?php

namespace App\Custom\Services;

use App\Models\Game;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Custom\Helpers\Realm;
use App\Custom\Helpers\Librarian;

class TurnServices {

    public static function giveTurn(){
        return [
            'turn' => Game::current()->turn,
            'phase' => Game::current()->phase,
            'player' => Game::current()->player
        ];
    }

    public static function phaseNames()
    {
        return Librarian::decipherJson('meta/turn.json');
    }

    public static function changeTurn(int $phase_index)
    {
        Game::current()->update(["phase" => $phase_index]);
    }

    public static function passTurn()
    {
        $phases = Librarian::decipherJson('meta/turn.json');

        if(Game::current()->player < Realm::families()->count()){
            Game::current()::increment('player');
            $data = ['player' => true];
        }else{
            Game::current()->update(['player'=>1]);
            $data = ['player' => true];
        }

        if(Game::current()->phase < count($phases)){
            Game::current()::increment('phase');
            $data = ['phase' => true];
        }else{
            Game::current()->update(['phase'=>2]);
            $data = ['turn' => true];
        }

        if(Game::current()->phase === count($phases)-1){
            Game::current()::increment('turn');
            ['turn' => true];
        }

        return Arr::add($data, 'color', Realm::currentPlayer()->color);
    }

}
