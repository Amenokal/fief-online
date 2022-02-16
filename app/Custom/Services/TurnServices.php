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
            'turn' => Game::current()->current_turn,
            'phase' => Game::current()->current_phase,
            'player' => Game::current()->current_player
        ];
    }

    public static function phaseNames()
    {
        return Librarian::decipherJson('meta/turn.json');
    }

    public static function changeTurn(int $phase_index)
    {
        Game::current()->update(["current_phase" => $phase_index]);
    }

    public static function passTurn()
    {
        $phases = Librarian::decipherJson('meta/turn.json');

        Game::current()::increment('current_player');

        if(Game::current()->current_player > Realm::families()->count()){

            Game::current()->update(['current_player'=>1]);
            Game::current()::increment('current_phase');

            if(Game::current()->current_phase > count($phases)){

                Game::current()->update(['current_phase'=>2]);
                Game::current()::increment('current_turn');
            }

        }

        return response()->json(['color' => Realm::currentPlayer()->color]);
    }

}
