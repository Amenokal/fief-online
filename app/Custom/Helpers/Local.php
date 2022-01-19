<?php

namespace App\Custom\Helpers;

use App\Models\Card;
use App\Models\Game;
use App\Models\User;
use App\Models\Player;
use Illuminate\Support\Facades\Auth;

class Local {

    public static function user()
    {
        return User::find(Auth::user()->id);
    }

    public static function player()
    {
        return Player::where([
            'user_id' => Local::user()->id,
            'game_id' => Game::current()->id
        ])
        ->first();
    }

    public static function cards()
    {
        return Local::player()->cards;
    }



    /////

    // GOLD
    public static function modifyGold(int $amount)
    {
        for($i=0; $i<$amount; $i++){
            if($amount>0){
                Local::player()->increment('gold');
            }else{
                Local::player()->decrement('gold');
            }
        }
    }

    public static function giveGold(int $amount, Player $to)
    {
        for($i=0; $i<$amount; $i++){
            Local::player()->decrement('gold');
            $to->increment('gold');
        }
    }
}