<?php

namespace App\Custom\Services;

use App\Models\Card;
use App\Models\Game;
use App\Models\Village;
use App\Custom\Helpers\Gipsy;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Realm;
use App\Custom\Helpers\Librarian;

class DeckServices {

    public static function setUpDecks(string $mod)
    {
        $cards = Librarian::decipherJson($mod.'/cards.json');
        foreach($cards as $card){
            for($i=0; $i<$card['nb']; $i++){
                Card::create([
                    'game_id' => Game::current()->id,
                    'name' => $card['name'],
                    'deck' => $card['deck'],
                    'disaster' => $card['disaster'] ?? false,
                    'card_img' => $card['card_img'],
                    'verso_img' => $card['verso_img']
                ]);
            }
        }

        $lords = Librarian::decipherJson('meta/lords.json');
        foreach($lords as $lord){
            Card::create([
                'game_id' => Game::current()->id,
                'name' => $lord['name'],
                'deck' => 'lord',
                'gender' => $lord['gender'],
                'card_img' => $card['card_img'],
                'verso_img' => $card['verso_img']
            ]);
        }
        Gipsy::shuffleDeck('lord');
        Gipsy::shuffleDeck('event');
    }

    public static function draw(string $deck, bool $isDisaster) : array
    {
        // if drawn card is a disaster
        // either put on waiting line
        // or discard it
        // then return disaster data to client
        if($isDisaster){

            if(Realm::incommingDisasters()->count() < 3){
                Gipsy::nextCard('event')->update([
                    'is_next' => false,
                    'on_board' => true
                ]);
            }elseif(Realm::incommingDisasters()->count() >= 3){
                $disas = Gipsy::nextCard('event');
                $disas->update([
                    'is_next' => false,
                ]);
                $disas->delete();
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

    public static function showDisasters()
    {
        $disasters = Realm::incommingDisasters()->get();
        $data = [];

        foreach($disasters as $disas){
            $data [] = ['name'=>$disas->name, 'zone'=>rand(1,6)];
        }

        for($i=0; $i<count($data); $i++){

            for($j=0; $j<count($data); $j++){

                if($i != $j && $data[$i] == $data[$j]){

                    do{$data[$i]['zone'] = rand(1,6);}
                    while($data[$i]['zone'] == 6 || $data[$i]['zone'] == $data[$j]);
                }
            }
        }

        for($i=0; $i<count($data); $i++){

            $data[$i]['img'] = $disasters->skip($i)->first()->img_src;

            $villages = [];
            foreach($disasters->skip($i)->first()->inflictedVillages($data[$i]['zone']) as $vilg){
                $villages[] = $vilg->name;
            }
            $data[$i]['villages'] = $villages;

            if($data[$i]['zone'] === 6){
                $disasters->skip($i)->first()->delete();
            }
            $disasters->skip($i)->first()->update(['cross_id'=>$data[$i]['zone']]);
        }

        return $data;
    }

    public static function addWealth(string $card, Village $village)
    {
        $card = Local::card($card);
        $card->update([
            'cross_id'=>$village->religious_territory,
            'on_board'=>true,
            'player_id'=>null
        ]);
    }

    public static function removeDisaster(string $card, string $disaster, Village $village)
    {
        $card = Local::card($card);
        $disaster = Realm::incommingDisasters()
        ->where('cross_id', $village->religious_territory)
        ->first();

        $card->delete();
        $disaster->delete();
    }
}
