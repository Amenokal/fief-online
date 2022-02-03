<?php

namespace App\Custom\Helpers;

use App\Models\Card;
use App\Models\Game;
use App\Models\Title;
use App\Models\Player;
use App\Models\Building;

class Realm {

    public static function self()
    {
        return Game::current();
    }

    public static function currentPlayer()
    {
        return Player::where([
            'game_id'=>Game::current()->id,
            'id'=>Game::current()->player
        ])->first();
    }

    public static function year()
    {
        return [
            'player'=>Game::current()->player,
            'phase'=>Game::current()->phase,
            'turn'=>Game::current()->turn
        ];
    }

    public static function families()
    {
        return Game::current()->players;
    }

    public static function lord(string $name) : Card
    {
        return Card::where([
            'game_id' => Game::current()->id,
            'deck' => 'lord',
            'name' => $name
        ])
        ->whereNotNull('village_id')
        ->first();
    }

    public static function inHandLord(string $name) : Card
    {
        return Card::where([
            'game_id' => Game::current()->id,
            'deck' => 'lord',
            'name' => $name,
            'on_board' => false
        ])
        ->whereNull('village_id')
        ->first();
    }

    public static function lords()
    {
        return Card::where([
            'game_id' => Game::current()->id,
            'deck' => 'lord'
        ])
        ->whereNotNull('village_id')
        ->get();
    }
    public static function remainingLords()
    {
        return Card::where([
            'game_id' => Game::current()->id,
            'deck' => 'lord',
            'village_id' => null
        ])
        ->get();
    }

    public static function activeArmies()
    {
        return Game::current()->soldiers->whereNotNull('village_id')->all();
    }
    public static function waitingArmies()
    {
        return Game::current()->soldiers->whereNull('village_id')->all();
    }

    public static function villages()
    {
        return Game::current()->villages;
    }

    public static function building(string $type)
    {
        return Game::current()->buildings()
        ->where([
            'name' => $type,
            'village_id' => null,
        ])
        ->first();
    }

    public static function buildings()
    {
        return Game::current()->buildings;
    }

    public static function remainingBuildings()
    {
        return Building::where([
            'game_id'=>Game::current()->id,
            'village_id' => null
        ])
        ->get();
    }

    public static function incommingDisasters()
    {
        return Game::current()->cards()
        ->where([
            'disaster' => true,
            'on_board' => true
        ]);
    }

    public static function blessedVillages()
    {
        $blessings = Card::where([
            'game_id'=>Game::current()->id,
            'on_board'=>true,
            'disaster'=>false
        ])
        ->whereNotNull('cross_id')
        ->get();

        $villages = [];
        foreach($blessings as $bless){
            foreach(Realm::villages() as $vilg){
                if($vilg->religious_territory === $bless->cross_id){
                    $villages[] = $vilg;
                }
            }
        }

        return collect($villages);
    }





    public static function canBuyCastle(Player $player){
        $gold = $player->gold;
        return round($gold/10, -1);
    }

    public static function canBuyTitle(Player $player)
    {
        $titles = [];
        $villages = $player->villages->pluck('name');

        if($villages->contains('beaujeu') && $villages->contains('la-salle') &&
        $villages->contains('blaye') && $villages->contains('charolles') ){
            $titles[]=1;
        }
        if($villages->contains('sennecy') && $villages->contains('l-épervier') &&
        $villages->contains('château-neuf') ){
            $titles[]=2;
        }
        if($villages->contains('mazilles') && $villages->contains('st-andromy') ){
            $titles[]=3;
        }
        if($villages->contains('tournus') && $villages->contains('belleville') &&
        $villages->contains('pugnac') ){
            $titles[]=4;
        }
        if($villages->contains('st-gérôme') && $villages->contains('st-médard') &&
        $villages->contains('st-andré')){
            $titles[]=5;
        }
        if($villages->contains('villeneuve') && $villages->contains('la-buissière') &&
        $villages->contains('bourg') && $villages->contains('st-vivien')){
            $titles[]=6;
        }
        if($villages->contains('les-essarts') && $villages->contains('st-paul') ){
            $titles[]=7;
        }
        if($villages->contains('marcamps') && $villages->contains('sigy') &&
        $villages->contains('st-ciers-d-abzac')){
            $titles[]=8;
        }

        $cardinal = Title::where([
            'game_id' => Game::current()->id,
            'type' => 'payed-cross',
            'lord_id' => null
        ]);
        if($cardinal->exists()){
            $titles[] = $cardinal->first()->type;
        }

        return $titles;
    }

}
