<?php

namespace App\Custom\Services;

use App\Models\LordCards;
use App\Models\EventCards;
use App\Custom\Helpers\GameCurrent;

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
                        'game_id' => GameCurrent::id(),
                    ]);
                elseif($card['type'] === 'event' || $card['type'] === 'disaster'){
                    EventCards::create([
                        'name' => $card['name'],
                        'instant' => $card['instant'],
                        'type' => $card['type'],
                        'img_src' => $card['img_src'],
                        'game_id' => GameCurrent::id(),
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
        $cards = $deck::
        where([
            'game_id' => GameCurrent::id(),
            'player_id' => null
        ])
        ->inRandomOrder()
        ->get();

        for($i=0; $i<$cards->count(); $i++){
            $cards[$i]->update(['order'=>$i]);
        }
    }
            
    public static function nextCards(string $deck)
    {
        $deck = $deck === 'lord' ? LordCards::class : EventCards::class;
        $card = $deck::where([
            ['game_id', GameCurrent::id()],
            ['player_id', null],
            ['on_board', false]
            ])
            ->orderBy('order')
            ->get();
            return $card;
    }
    
}