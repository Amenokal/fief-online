<?php

namespace App\Custom\Services;

use App\Models\Card;
use App\Models\Game;
use App\Models\Player;
use App\Models\Village;
use Illuminate\Http\Request;
use App\Custom\Helpers\Gipsy;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Realm;
use App\Events\Cards\PlayerDrawEvent;
use App\Custom\Helpers\Librarian;
use Illuminate\Http\JsonResponse;
use App\Events\Cards\PlayerDiscardEvent;
use App\Events\Cards\PlayerDrawDisasterEvent;

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
                'card_img' => $lord['card_img'],
                'verso_img' => $lord['verso_img']
            ]);
        }
        Gipsy::shuffleDeck('lord');
        Gipsy::shuffleDeck('event');
    }

    public static function discard(Request $request, string $cardName)
    {
        $card = Card::where([
            'game_id' => Game::current()->id,
            'player_id' => $request->user()->player->id,
            'name' => $cardName
        ])
        ->first();

        $card->delete();

        broadcast(new PlayerDiscardEvent($request, $card))->toOthers();
    }

    public static function draw(Request $request) : JsonResponse
    {
        $card = Card::getNext($request->deck);

        if($card->disaster){

            if(Card::where(['disaster'=>true, 'on_board'=>true])->get()->count() < 3){
                $card->update(['is_next'=>false, 'on_board'=>true]);
            }
            else {
                $card->delete();
            }
        }
        else {
            $card->update(['is_next'=>false, 'player_id'=>$request->user()->player->id]);
        }

        if(is_null($request->user()->player->drawn_card) && !$card->disaster){
            $request->user()->player->update(['drawn_card'=>$card->deck]);
        }
        elseif(!is_null($request->user()->player->drawn_card) && !$card->disaster){
            $request->user()->player->update(['drawn_card'=>'stop']);
        }

        Gipsy::makeNewNextCard($request->deck);

        if($card->disaster){
            broadcast(new PlayerDrawDisasterEvent(Card::getNext($request->deck)))->toOthers();
        }
        else {
            broadcast(new PlayerDrawEvent($request, $card, Card::getNext($request->deck)))->toOthers();
        }

        return response()->json([
            'wasDisaster' => $card->disaster,
            'nextCardType' => Card::getNext($request->deck)->deck,
            'drawnCard' => $card,
        ]);

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
