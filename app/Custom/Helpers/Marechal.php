<?php

namespace App\Custom\Helpers;

use App\Models\Card;
use App\Models\Game;
use App\Models\Player;
use App\Models\Soldier;
use App\Models\Village;
use App\Models\Soldiers;
use App\Models\Villages;

class Marechal {

/**  +----------------------------------------------------+
 *   |                     LORDS                          |
 *   +----------------------------------------------------+
 */

    public static function moveLord(Card $lord, Village $to)
    {
        $lord->update(['village_id' => $to->id, 'on_board' => true]);
        return $lord;
    }

    // public static function removeLord(Card $lord)
    // {
    //     $lord->update([
    //         'player_id' => null,
    //         'village_id' => null,
    //         'on_board' => false
    //     ]);
    //     $lord->delete();
    // }


    
/**  +----------------------------------------------------+
 *   |                     ARMIES                         |
 *   +----------------------------------------------------+
 *   @param $army is an simple array following the pattern
 *                [ 'type' , 'amount' , ... ]
 *
 *   available types registered in json file at :
 *                storage / data / *gamemod* / armies.json
 */


    public static function recruit(array $army, Village $village)
    {
        for($i=0; $i<count($army); $i+=2){
            Soldier::where([
                'type' => $army[$i],
                'player_id' => Local::player()->id,
                'game_id' => Game::current()->id
            ])
            ->whereNull('village_id')
            ->take($army[$i+1])
            ->update(['village_id' => $village->id]);
        }
    }

    // public static function march(array $army, Villages $from, Villages $to)
    // {
    //     for($i=0; $i<count($army); $i+=2){
    //         Soldiers::where([
    //             'type' => $army[$i],
    //             'player_id' => Local::player(),
    //             'game_id' => GameCurrent::id(),
    //             'village_id' => $from->id,
    //         ])
    //         ->take($army[$i+1])
    //         ->update(['village_id' => $to->id]);
    //     }
    // }

    // public static function retreat(array $army, Villages $village)
    // {
    //     for($i=0; $i<count($army); $i+=2){
    //         Soldiers::where([
    //             'type' => $army[$i],
    //             'player_id' => Local::player(),
    //             'game_id' => GameCurrent::id(),
    //             'village_id' => $village->id,
    //         ])
    //         ->take($army[$i+1])
    //         ->update(['village_id' => null]);
    //     }
    // }


    public function estimate(Player $player, Village $village)
    {
        $army = $village->soldiers()
        ->where('player_id', $player->id)
        ->get();

        $power = 0;
        foreach($army as $soldier){
            $power += $soldier->power;
        }

        if($power<7){
            return 1;
        }elseif($power<13){
            return 2;
        }else{
            return 3;
        }
    }
}