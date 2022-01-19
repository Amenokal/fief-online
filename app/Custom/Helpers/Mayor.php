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

    // public static function inspect(string $village_name)
    // {
    //     $conditions = ['game_id' => GameCurrent::id(),'village_id' => self::craft($village_name)->id];
    //     $lords = collect(LordCards::where($conditions)->get());
    //     $armies = collect(Soldiers::where($conditions)->get());
    //     return $lords->merge($armies);
    // }



}