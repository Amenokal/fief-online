<?php

namespace App\Custom\Services;

use App\Models\Games;
use App\Models\Players;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\GameCurrent;

class PlayerServices {

    // CARDS
    public static function drawCard(string $type)
    {
        $card = DeckServices::nextCards($type)->first();
        $card->update(['player_id' => Local::player()->id]);
        return $card;
    }

    public static function play($card)
    {
        $card->update(['on_board' => true]);
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
                Local::player()->increment('gold');
            }else{
                Local::player()->decrement('gold');
            }
        }
    }

    public static function giveGold(int $amount, Players $to)
    {
        for($i=0; $i<$amount; $i++){
            Local::player()->decrement('gold');
            $to->increment('gold');
        }
    }


}