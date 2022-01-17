<?php

namespace App\Custom\Services;

use App\Models\Games;
use App\Models\Players;

class PlayerServices {

    // CARDS
    public static function drawCard(string $type)
    {
        $card =  DeckServices::nextCards($type)->first();
        $card->update(['player_id' => Games::current()->player()->id]);
    }

    public static function discard(string $name)
    {
        $discarded = Players::auth()->cards()->where('name', $name)->first();
        $discarded->update(['player_id' => null])->delete();
    }

    // ------------------------------------------------------------------------- //

    // GOLD
    public static function addGold(int $amount)
    {
        for($i=0; $i<$amount; $i++){
            if($amount>0){
                Games::current()->player()->increment('gold');
            }else{
                Games::current()->player()->decrement('gold');
            }
        }
    }

    public static function giveGold(int $amount, Players $to)
    {
        for($i=0; $i<$amount; $i++){
            Games::current()->player()->decrement('gold');
            $to->increment('gold');
        }
    }


}