<?php

namespace App\Custom\Helpers;

use App\Models\Game;
use App\Models\Player;
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

    public static function administrate()
    {
        $vilgs = Realm::villages();
        foreach($vilgs as $vilg){
            if($vilg->player_id && $vilg->soldiers()->get()->isEmpty()){
                $vilg->update(['player_id' => null]);
            }
            elseif($vilg->player_id === null && $vilg->soldiers()->get()->isNotEmpty()){
                $vilg->update(['player_id' => $vilg->soldiers()->first()->player->id]); 
            }
        }
    }

}