<?php

namespace App\Custom\Helpers;

use App\Models\Games;
use App\Models\Players;
use App\Models\GameTurns;
use Illuminate\Support\Facades\Auth;

class CurrentGame {

    public static function id()
    {
        return Games::latest()->first()->id;
    }

    public static function get()
    {
        return Games::latest()->first();
    }

    public static function turn()
    {
        return GameTurns::where('id', self::get()->id)->first();
    }

    public static function players()
    {
        return Players::where('id', self::get()->id)->get();
    }

    public static function hasPlayers(array $users = [])
    {
        foreach($users as $user){
            if(!Players::where([['game_id', self::id()],['user_id', $user['id']]])->exists()){
                return false;
            }
        }
    }
}