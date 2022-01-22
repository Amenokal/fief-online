<?php

namespace App\Custom\Helpers;

use App\Models\Card;
use App\Models\Game;

class Gipsy {

    public static $deck;

    public static function nextCard(string $deck)
    {
        return Card::where([
            'game_id' => Game::current()->id,
            'village_id' => null,
            'player_id' => null,
            'on_board' => false,
            'is_next' => true,
            'deck' => $deck
        ])->first();
    }

    public static function getNextType(string $deck)
    {
        $next = self::nextCard($deck);
        return $next->disaster ? 'disaster' : $next->deck;
    }

    public static function makeNewNextCard(string $type)
    {
        $new = Card::where([
            'game_id'=>Game::current()->id,
            'deck'=>$type,
            'is_next'=>false,
            'player_id'=>null,
            'village_id'=>null,
            'on_board'=>false
        ])
        ->inRandomOrder()
        ->first();
        $new->update(['is_next' => true]);
        return $new;
    }

    public static function discardedCards(string $type)
    {
        return Card::onlyTrashed()
        ->where([
            'game_id' => Game::current()->id,
            'deck' => $type,
        ])
        ->orderBy('deleted_at', 'desc')
        ->get();
    }
    
    public static function shuffleDeck(string $type)
    {   
        self::$deck = Card::withTrashed()
        ->where([
            'game_id' => Game::current()->id,
            'deck' => $type
        ])
        ->whereNull('player_id');

        self::$deck->update([
            'is_next' => false,
            'player_id' => null,
            'village_id' => null,
        ]);
        self::$deck->restore(); 

        self::makeNewNextCard($type);

        return ['nextCardType' => Gipsy::getNextType($type)];
    }
}