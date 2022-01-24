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

    public static $power = 0;
    public static $power_counter = 0;
    public static $sergeants = 0;
    public static $knights = 0;

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

    public static function armyOf(Card $lord)
    {
        $lords = Card::where([
            'game_id' => Game::current()->id,
            'deck' => 'lord',
            'village_id' => $lord->village_id
        ])->get();

        $soldiers = Soldier::where([
            'game_id' => Game::current()->id,
            'village_id' => $lord->village_id
        ])->get();

        return collect($lords)->merge(collect($soldiers));
    }



    public static function evaluate(Village $village, Player $player)
    {
        $lords = Card::where([
            'game_id' => Game::current()->id,
            'deck' => 'lord',
            'village_id' => $village->id,
            'player_id' => $player->id
        ])->get();


        $soldiers = Soldier::where([
            'game_id' => Game::current()->id,
            'village_id' => $village->id,
            'player_id' => $player->id
        ])->get();

        $power = 0;
        foreach($lords as $lord){
            if($lord->gender === 'M'){
                $power++;
            }
        }
        foreach($soldiers as $soldier){
            $power += $soldier->power;
        }
        return $power;
    }

}
