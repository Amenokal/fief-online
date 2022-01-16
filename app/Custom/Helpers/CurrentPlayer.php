<?php

namespace App\Custom\Helpers;

use App\Models\Players;
use App\Models\LordCards;
use App\Models\EventCards;
use App\Custom\Helpers\CurrentUser;
use Illuminate\Support\Facades\Auth;

class CurrentPlayer {

    public static function get()
    {
        return Players::find(Auth::user()->id)->first();
    }

    public static function cards()
    {
        $conditions = ['player_id'=>self::get()->id, 'game_id'=>CurrentGame::get()->id];
        $lord_cards = LordCards::where($conditions)->get();
        $event_cards = EventCards::where($conditions)->get();
        return $lord_cards->merge($event_cards);
    }


    // CARDS ACTION
    public static function drawLord()
    {
        $card = LordDeck::nextCard();
        $card->first()->update(['player_id' => self::get()->id]);
        return $card;
    }
    public static function drawEvent()
    {
        $check = EventDeck::inc_disasters()->count() > 2;
        $card = EventDeck::nextCard();
        if($card->first()->type === 'event'){
            $card->first()->update(['player_id' => self::get()->id]);
        }elseif($card->first()->type === 'disaster'){
            if($check){
                $card->first()->delete();
            }else{
                $card->first()->update(['on_board' => true]);
            }
        }
        return $card;
    }

    public static function discard(string $name)
    {
        $card = self::cards()->where('name', $name)->first();
        $card->update(['player->id', null]);
        $card->delete();
    }


    // GOLD ACTIONS
    public static function getGold(int $amount)
    {
        self::get()->update(['gold' => self::get()->amount += $amount]);
    }

    public static function spendGold(int $amount)
    {
        self::get()->update(['gold' => self::get()->amount -= $amount]);
    }

}