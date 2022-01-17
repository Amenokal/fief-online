<?php

namespace App\Custom\Services;

use App\Models\Games;
use App\Models\Players;
use App\Models\LordCards;
use App\Models\EventCards;

class DeckServices {

    public static function setUp(string $mod)
    {
        $cards = collect(json_decode(file_get_contents(storage_path('data/'.$mod.'/cards.json')), true));
        foreach($cards as $card){
            for($i=0; $i<$card['nb']; $i++){
                if($card['type'] === 'lord')
                    LordCards::create([
                        'name' => $card['name'],
                        'gender' => $card['gender'],
                        'img_src' => $card['img_src'],
                        'game_id' => Games::current()->id,
                    ]);
                elseif($card['type'] === 'event' || $card['type'] === 'disaster'){
                    EventCards::create([
                        'name' => $card['name'],
                        'instant' => $card['instant'],
                        'type' => $card['type'],
                        'img_src' => $card['img_src'],
                        'game_id' => Games::current()->id,
                    ]);
                }
            }
        }    
        self::shuffle('lord');
        self::shuffle('event');
    }
        
    public static function shuffle(string $deck)
    {
        $deck = $deck === 'lord' ? LordCards::class : EventCards::class;
        $cards = $deck::where([
            ['game_id', Games::current()->id],
            ['player_id', null]
        ])
        ->inRandomOrder()
        ->get();
            
        $order = 0;
        foreach($cards as $card){
            $card->update(['order'=>++$order]);
        }

    }
            
    public static function nextCard(string $deck)
    {
        $deck = $deck === 'lord' ? LordCards::class : EventCards::class;
        $card = $deck::where([
            ['game_id', Games::current()->id],
            ['player_id', null],
            ['on_board', false]
            ])
            ->orderBy('order')
            ->take(2)
            ->get();
            return $card;
    }
}