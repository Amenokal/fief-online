<?php

namespace App\Custom\Helpers;

use App\Models\Games;
use App\Models\Players;
use App\Models\GameTurns;
use App\Models\EventCards;

class Realm {

    public static function get()
    {
        return Games::current();
    }

    // public static function id()
    // {
    //     return self::get()->id;
    // }

    // public static function turn()
    // {
    //     return GameTurns::find(self::id());
    // }

    // public static function player()
    // {
    //     return Players::where(
    //         ['game_id' => self::id()],
    //         ['player_id' => self::turn()->player]
    //     )
    //     ->first();
    // }

    // public static function players()
    // {
    //     return Players::where('game_id', self::id())->get();
    // }

    // public static function inc_disasters()
    // {
    //     return EventCards::where([
    //         'game_id' => Games::current()->id,
    //         'type' => 'disaster',
    //         'on_board' => true
    //     ]);
    // }
}