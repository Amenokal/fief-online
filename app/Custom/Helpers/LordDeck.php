<?php

namespace App\Custom\Helpers;

use App\Models\LordCards;

class LordDeck {


    public static function setUp(string $mod)
    {
        $cards = json_decode(file_get_contents(storage_path('data/'.$mod.'/lord_deck.json')), true);
        foreach($cards as $card){
            for($i=0; $i<$card['nb']; $i++){
                LordCards::create([
                    'name' => $card['name'],
                    'gender' => $card['gender'],
                    'img_src' => $card['img_src'],
                    'game_id' => CurrentGame::id(),
                ]);
            }
        }

        self::shuffle();
    }

    public static function shuffle()
    {
        $cards = LordCards::where([
            ['game_id', CurrentGame::id()],
            ['player_id', null]
        ])
        ->inRandomOrder()
        ->get();

        $order = 0;
        foreach($cards as $card){
            $card->update(['order'=>++$order]);
        }
    }

    public static function nextCard()
    {
        $card = LordCards::where([
            ['game_id', CurrentGame::id()],
            ['player_id', null],
            ['on_board', false]
        ])
        ->orderBy('order')
        ->take(2)
        ->get();
        return $card;
    }

    public static function discarded()
    {
        return LordCards::onlyTrashed()
        ->orderBy('deleted_at', 'desc')
        ->get();
    }

}