<?php

namespace App\Custom\Helpers;

use App\Models\Soldiers;
use App\Models\Villages;
use App\Models\LordCards;

class Mayor {

    public static function craft(string $village_name)
    {
        return Villages::where([
            'game_id' => GameCurrent::id(),
            'name' => $village_name
        ])->first();
    }

    public static function inspect(string $village_name)
    {
        $conditions = ['game_id' => GameCurrent::id(),'village_id' => self::craft($village_name)->id];
        $lords = collect(LordCards::where($conditions)->get());
        $armies = collect(Soldiers::where($conditions)->get());
        return $lords->merge($armies);
    }



}