<?php

namespace App\Custom\Helpers;

use App\Models\Game;
class Realm {

    public static function self()
    {
        return Game::current();
    }

    public static function year()
    {
        return Game::current()->turn;
    }

    public static function families()
    {
        return Game::current()->players;
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

    public static function nextCards(string $type)
    {
    //     $deck = $type === 'lord' ? Game::current()->lordDeck() : Game::current()->eventDeck();
    //     $next = collect(
    //         Game::current()->lordDeck()->whereNull('player_id')
    //         ->sortBy('order')
    //         ->take(2)
    //         ->all()
    //     );
    //     $first = $next->first();
    //     $second = ['isNextDisaster' => $next->skip(1)->first()->disaster];
    //     $response = collect($first)->merge(collect($second));
    //     return $response;
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