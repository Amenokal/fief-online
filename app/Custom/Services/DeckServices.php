<?php

namespace App\Custom\Services;

use App\Models\Card;
use App\Models\Game;
use App\Custom\Helpers\Librarian;

class DeckServices {

    public static function setUpDecks(string $mod)
    {
        $cards = Librarian::decipherJson($mod.'/cards.json');
        foreach($cards as $card){
            for($i=0; $i<$card['nb']; $i++){
                Card::create([
                    'name' => $card['name'],
                    'type' => $card['type'],
                    'gender' => $card['gender'] ?? null,
                    'img_src' => $card['img_src'],
                    'game_id' => Game::current()->id,
                ]);
            }
        }    
        self::shuffleDeck('lord');
        self::shuffleDeck('event');
    }
        
    public static function shuffleDeck(string $type)
    {
        $deck = $type === 'lord' ? Game::current()->lordCards : Game::current()->eventCards ;
        $cards = $deck::withTrashed()
        ->whereNull('player_id')
        ->inRandomOrder()
        ->get();

        foreach($cards as $card){
            $i=0;
            $card->update(['order'=>$i++]);
            $card->restore();
        }
    }

    public static function nextCards(string $type)
    {
        $deck = $type === 'lord' ? Game::current()->lordDeck() : Game::current()->eventDeck() ;
        $next = $deck->whereNull('player_id')
        ->sortBy('order')
        ->all();
        return collect($next);
    }
    
}