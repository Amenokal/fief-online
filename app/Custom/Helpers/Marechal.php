<?php

namespace App\Custom\Helpers;

use App\Models\Soldiers;
use App\Models\Villages;
use App\Models\LordCards;

class Marechal {

    // LORDS
    public static function moveLord(LordCards $lord, Villages $to)
    {
        $lord->update([
            'village_id' => $to->id
        ]);
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


    
    // ARMIES
    public function newArmy(int $amount, Villages $to)
    {
        Soldiers::where([
            'player_id' => Local::player(),
            'game_id' => GameCurrent::id(),
            'village_id' => null
        ])
        ->take($amount)
        ->update([
            'village_id' => $to->id,
        ]);
    }

    public static function moveArmy(int $amount, Villages $from, Villages $to)
    {
        Soldiers::where([
            'player_id' => Local::player(),
            'game_id' => GameCurrent::id(),
            'village_id' => $from->id,
        ])
        ->take($amount)
        ->update(['village_id' => $to->id]);
    }

    public static function removeArmy(int $amount, Villages $from)
    {
        Soldiers::where([
            'player_id' => Local::player(),
            'game_id' => GameCurrent::id(),
            'village_id' => $from->id,
        ])
        ->take($amount)
        ->update([
            'village_id' => null,
        ]);
    }

}