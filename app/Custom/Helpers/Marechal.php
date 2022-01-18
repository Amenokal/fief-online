<?php

namespace App\Custom\Helpers;

use App\Models\Soldiers;
use App\Models\Villages;
use App\Models\LordCards;

class Marechal {

   /**  +----------------------------------------------------+
    *   |                     LORDS                          |
    *   +----------------------------------------------------+
    */

    public static function moveLord(LordCards $lord, Villages $to)
    {
        $update = !$lord->on_board  ?  ['village_id' => $to->id]  :  ['village_id' => $to->id, 'on_board' => true];
        $lord->update($update);
    }

    public static function removeLord(LordCards $lord)
    {
        $lord->update([
            'player_id' => null,
            'village_id' => null,
            'on_board' => false
        ]);
        $lord->delete();
    }


    
   /**  +----------------------------------------------------+
    *   |                     ARMIES                         |
    *   +----------------------------------------------------+
    *   @param $army is an simple array following the pattern
    *                [ 'type' , 'amount' , ... ]
    *
    *   available types registered in json file at :
    *                storage / data / *gamemod* / armies.json
    */


    public static function newArmy(array $army, Villages $village)
    {
        for($i=0; $i<count($army); $i+=2){
            Soldiers::where([
                'type' => $army[$i],
                'player_id' => Local::player()->id,
                'game_id' => GameCurrent::id(),
                'village_id' => null
            ])
            ->take($army[$i+1])
            ->update(['village_id' => $village->id]);
        }
    }

    public static function moveArmy(array $army, Villages $from, Villages $to)
    {
        for($i=0; $i<count($army); $i+=2){
            Soldiers::where([
                'type' => $army[$i],
                'player_id' => Local::player(),
                'game_id' => GameCurrent::id(),
                'village_id' => $from->id,
            ])
            ->take($army[$i+1])
            ->update(['village_id' => $to->id]);
        }
    }

    public static function removeArmy(array $army, Villages $village)
    {
        for($i=0; $i<count($army); $i+=2){
            Soldiers::where([
                'type' => $army[$i],
                'player_id' => Local::player(),
                'game_id' => GameCurrent::id(),
                'village_id' => $village->id,
            ])
            ->take($army[$i+1])
            ->update(['village_id' => null]);
        }
    }

}