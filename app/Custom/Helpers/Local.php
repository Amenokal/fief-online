<?php

namespace App\Custom\Helpers;

use App\Models\EventCards;
use App\Models\User;
use App\Models\LordCards;
use App\Models\Players;
use Illuminate\Support\Facades\Auth;

class Local {

    public static function user()
    {
        return User::find(Auth::user()->id);
    }

    public static function player()
    {
        return Players::where([
            'user_id' => self::user()->id,
            'game_id' => GameCurrent::id()
        ])
        ->first();
    }

    public static function cards()
    {
        $conditions = ['game_id' => GameCurrent::id(), 'player_id' => self::player()];
        $lord_cards = LordCards::where($conditions)->get();
        $event_cards = EventCards::where($conditions)->get();
        return $lord_cards->merge($event_cards);
    }
    
}