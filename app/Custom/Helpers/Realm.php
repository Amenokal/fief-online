<?php

namespace App\Custom\Helpers;

use App\Models\Card;
use App\Models\Game;
use App\Models\Player;

class Realm {

    public static function self()
    {
        return Game::current();
    }

    public static function currentPlayer()
    {
        return Player::where([
            'game_id'=>Game::current()->id,
            'id'=>Game::current()->player
        ])->first();
    }

    public static function year()
    {
        return [
            'player'=>Game::current()->player,
            'phase'=>Game::current()->phase,
            'turn'=>Game::current()->turn
        ];
    }

    public static function families()
    {
        return Game::current()->players;
    }

    public static function lord(string $name)
    {
        return Card::where([
            'game_id' => Game::current()->id,
            'deck' => 'lord',
            'name' => $name
        ])
        ->whereNotNull('village_id')
        ->get();
    }

    public static function lords()
    {
        return Card::where([
            'game_id' => Game::current()->id,
            'deck' => 'lord'
        ])
        ->whereNotNull('village_id')
        ->get();
    }

    public static function activeArmies()
    {
        return Game::current()->soldiers->whereNotNull('village_id')->all();
    }
    public static function waitingArmies()
    {
        return Game::current()->soldiers->whereNull('village_id')->all();
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
            'disaster' => true,
            'on_board' => true
        ]);
    }
}