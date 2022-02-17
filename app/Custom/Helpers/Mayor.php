<?php

namespace App\Custom\Helpers;

use App\Models\Game;
use App\Models\Player;
use App\Models\Village;
use App\Models\Soldiers;
use App\Models\Villages;
use App\Models\LordCards;

class Mayor {

    public static function find(string $village_name)
    {
        return Realm::villages()->where('name', $village_name)->first();
    }

    public static function takeControl(Player $player, $village_name)
    {
        Mayor::find($village_name)->update(['player_id'=>$player->id]);
    }

    public static $new_owner = null;
    public static $counter = 0;
    public static $power = 0;

    /**
     * Handles changes of ownership after army move.
     * If a player enter an empty village, he'll get the ownership.
     * If he leaves a village without guarrison, village will
     * become without owner.
     */
    public static function administrate()
    {
        foreach(Village::all() as $vilg){
            if(!$vilg->hasArmy()){
                $vilg->update(['player_id' => null]);
            }else if($vilg->hasArmy() && !$vilg->hasOwner()){
                $vilg->update(['player_id' => $vilg->soldiers()->first()->player->id]);
            }
        }
    }
}
