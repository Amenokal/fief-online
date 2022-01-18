<?php

namespace App\Custom\Helpers;

use App\Models\Game;
class Realm {

    public static function self()
    {
        return Game::current();
    }

    public static function lords()
    {
        return self::self()->lordDeck()->where('on_board', true)->all();
    }

    public static function armies()
    {
        return Game::current()->soldiers->where('on_board', true)->all();
    }

    public static function villages()
    {
        return Game::current()->villages;
    }

    public static function buildings()
    {
        return Game::current()->buildings;
    }


    public static function incommingDisasters()
    {
        return self::self()->cards()
        ->where([
            'type'=>'disaster',
            'on_board'=>true
        ]);
    }
}