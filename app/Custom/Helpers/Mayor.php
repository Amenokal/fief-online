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

    public static $new_owner = null;
    public static $counter = 0;
    public static $power = 0;

    public static function administrate()
    {
        foreach(Realm::villages() as $vilg){
            if(!$vilg->lords()->exists() && !$vilg->soldiers()->exists()){
                $vilg->update(['player_id' => null]);
            }else{
                foreach(Realm::families() as $fam){
                    self::$power = Marechal::evaluate($vilg, $fam);
                    if(self::$power>self::$counter){
                        self::$counter = self::$power;
                        self::$new_owner = $fam;
                    }
                }
                $vilg->update(['player_id' => self::$new_owner->id]);
            }
        }
    }
}
