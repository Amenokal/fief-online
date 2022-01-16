<?php

namespace App\Custom\Helpers;

use App\Models\LordCards;
use App\Models\EventCards;

class EventDeck {


    public static function setUp(string $mod)
    {
        $cards = json_decode(file_get_contents(storage_path('data/'.$mod.'/event_deck.json')), true);
        foreach($cards as $card){
            for($i=0; $i<$card['nb']; $i++){
                EventCards::create([
                    'name' => $card['name'],
                    'instant' => $card['instant'],
                    'type' => $card['type'],
                    'img_src' => $card['img_src'],
                    'game_id' => CurrentGame::id(),
                ]);
            }
        }

        self::shuffle();
    }

    public static function shuffle()
    {
        $cards = EventCards::where('game_id', CurrentGame::id())
        ->inRandomOrder()
        ->get();

        $order = 0;
        foreach($cards as $card){
            $card->update(['order'=>++$order]);
        }
    }

    public static function nextCard()
    {
        $card = EventCards::where([
            ['game_id', CurrentGame::id()],
            ['player_id', null],
            ['on_board', false]
        ])
        ->orderBy('order')
        ->take(2)
        ->get();
        return $card;
    }

    public static function inc_disasters()
    {
        return EventCards::where(['on_board' => true])->get();
    }

    public static function discarded()
    {
        return EventCards::onlyTrashed()
        ->orderBy('deleted_at', 'desc')
        ->get();
    }
}