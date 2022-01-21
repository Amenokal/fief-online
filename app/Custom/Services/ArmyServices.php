<?php

namespace App\Custom\Services;

use App\Models\Card;
use App\Models\Game;
use App\Models\Soldier;
use App\Models\Village;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Realm;
use Illuminate\Support\Collection;

class ArmyServices {

    public static $moving;

    public static function newLord(Card $lord, Village $to)
    {
        $lord->update([
            'village_id' => $to->id,
            'on_board' => true
        ]);
        return $lord;
    }

    public static function moveLord(Card $lord, Village $to)
    {
        $lord->update([
            'village_id' => $to->id
        ]);
        return $lord;
    }

    public static function removeLord(Card $lord)
    {
        $lord->update([
            'player_id' => null,
            'village_id' => null,
            'on_board' => false
        ]);
        $lord->delete();
    }


    
/**
 *                    ::::: ARMIES :::::
 *   
 *  • $army is an simple array following the pattern
 *                [ 'type' , 'amount' , ... ]
 *
 *  • *available types registered in json file at :
 *                storage / data / *-mod-* / armies.json*
 */


    public static function recruit(array $army, Village $village)
    {
        for($i=0; $i<count($army); $i+=2){
            Soldier::where([
                'game_id' => Game::current()->id,
                'type' => $army[$i],
                'player_id' => Local::player()->id,
                'village_id' => null
            ])
            ->take($army[$i+1])
            ->update(['village_id' => $village->id]);
        }
    }

    public function disband(array $army)
    {
        for($i=0; $i<count($army); $i+=2){
            Soldier::where([
                'game_id' => Game::current()->id,
                'type' => $army[$i],
            ])
            ->take($army[$i+1])
            ->update(['village_id' => null]);
        }
    }

    public static function march(Collection $army, Village $to)
    {
        foreach($army as $soldier){
            $soldier->update(['village_id' => $to->id]);
        }
        Mayor::administrate();
    }

}
