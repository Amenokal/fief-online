<?php

namespace App\Custom\Services;

use App\Models\Card;
use App\Models\Game;
use App\Custom\Helpers\Gipsy;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Librarian;

class DeckServices {

    public static function setUpDecks(string $mod)
    {
        $cards = Librarian::decipherJson($mod.'/cards.json');
        foreach($cards as $card){
            for($i=0; $i<$card['nb']; $i++){
                Card::create([
                    'name' => $card['name'],
                    'deck' => $card['deck'],
                    'gender' => $card['gender'] ?? null,
                    'disaster' => $card['disaster'] ?? false,
                    'img_src' => $card['img_src'],
                    'game_id' => Game::current()->id,
                ]);
            }
        }    
        Gipsy::shuffleDeck('lord');
        Gipsy::shuffleDeck('event');
    }

    public static function draw(string $deck, bool $isDisaster)
    {

        // shuffle if empty pile
        if(!Gipsy::nextCard($deck)->exists()){
            Gipsy::shuffleDeck($deck);
        }

        // if drawn card is a disaster
        // either put on waiting line
        // or discard it
        // then return disaster data to client
        if($isDisaster){
            $inc_disasters = Card::where([
                'game_id' => Game::current()->id,
                'deck' => 'disaster',
                'on_board' => true
            ])->count();

            if($inc_disasters<3){
                Gipsy::nextCard('event')->update([
                    'on_board' => true,
                    'is_next' => false
                ]);
            }elseif($inc_disasters >= 3){
                Gipsy::nextCard('event')->update(['is_next' => false])->delete();
            }
            Gipsy::makeNewNextCard('event');
            return ['nextCardType' => Gipsy::getNextType($deck)];
        }
        
        // if not a disaster, get the next card
        // updates it
        // make new next card
        // send drawn card data & next card color to client
        $card = Gipsy::nextCard($deck);
        $card->update([
            'player_id' => Local::player()->id,
            'is_next' => false
        ]);
        Gipsy::makeNewNextCard($deck);
        return ['drawnCard' => $card, 'nextCardType' => Gipsy::getNextType($deck)];
    }

    public static function discard(string $deck, string $card_name)
    {
        $card = Card::where([
            'game_id' => Game::current()->id,
            'deck' => $deck,
            'name' => $card_name
        ]);
        $card->update([
            'on_board' => false,
            'village_id' => null,
            'player_id' => null
        ]);
        $card->delete();
    }
    
}