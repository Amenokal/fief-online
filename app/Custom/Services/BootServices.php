<?php

namespace App\Custom\Services;

use App\Models\Games;
use App\Models\Players;
use App\Models\Soldiers;
use App\Models\Villages;
use App\Models\Buildings;
use App\Models\GameTurns;
use App\Models\LordCards;
use App\Models\EventCards;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\GameCurrent;

class BootServices {

    public static $mod;
    public static $family_names;
    public static $colors;
    public static $villages;
    public static $buildings;
    public static $armies;

    public static function init(string $mod)
    {
        self::$mod = $mod;
        self::$family_names = collect(json_decode(file_get_contents(storage_path('data/meta/family_names.json')), true))->flatten();
        self::$colors = collect(json_decode(file_get_contents(storage_path('data/meta/colors.json')), true))->flatten();
        self::$villages = collect(json_decode(file_get_contents(storage_path('data/'.self::$mod.'/villages.json')), true));
        self::$buildings = collect(json_decode(file_get_contents(storage_path('data/'.self::$mod.'/buildings.json')), true));
        self::$armies = collect(json_decode(file_get_contents(storage_path('data/'.self::$mod.'/armies.json')), true));
        
        self::createGame();
        self::createDecks();
        self::createPlayers();
        self::createVillages();
        self::createBuildings();
        self::createArmies();
    }

    private static function createGame()
    {
        if(!Games::latest()->exists() || Games::latest()->first()->is_over){
            Games::create([
                'mod'=>self::$mod
            ]);
            GameTurns::create([
                'game_id' => GameCurrent::id()
            ]);
        }
    }
    
    private static function createDecks()
    {
        if(!LordCards::where('game_id', GameCurrent::id())->exists() && !EventCards::where('game_id', GameCurrent::id())->exists() ){
            DeckServices::setUp(self::$mod);
        }
    }
    
    private static function createPlayers()
    {   
        if(!Local::player()){
            
            Players::create([
                'game_id' => GameCurrent::id(),
                'user_id' => Local::user()->id,
                'familyname' => self::setName(),
                'color' => self::setColor(),
                'gold' => 5
            ]);
            
        }
    }
        private static function setName()
        {
            foreach(GameCurrent::players() as $player){
                self::$family_names->flip()->forget($player->familyname);
            }
            return self::$family_names->random();
        }
        private static function setColor()
        {
            foreach(GameCurrent::players() as $player){
                self::$colors->flip()->forget($player->color);
            }
            return self::$colors->random();
        }

    private static function createVillages()
    {
        if(!Villages::where('game_id', GameCurrent::id())->exists()){

            foreach(self::$villages as $v){
                Villages::create([
                    'name' => $v['name'],
                    'lord_territory' => $v['lord_territory'],
                    'religious_territory' => $v['religious_territory'],
                    'capital' => $v['capital'],
                    'game_id' => GameCurrent::id()
                ]);
            }
        }

    }

    private static function createBuildings()
    {
        if(!Buildings::where('game_id', GameCurrent::id())->exists()){

            foreach(self::$buildings as $b){

                for($i=0; $i<$b['nb']; $i++){
                Buildings::create([
                    'name' => $b['name'],
                    'price' => $b['price'],
                    'income' => $b['income'],
                    'defense' => $b['defense'],
                    'game_id' => GameCurrent::id()
                ]);
                }
            }
        }
    }

    private static function createArmies()
    {
        if(!Soldiers::where('game_id', GameCurrent::id())->exists()){

            foreach(self::$armies as $a){
                
                for($i=0; $i<$a['nb']; $i++){
                    Soldiers::create([
                        'name' => $a['name'],
                        'price' => $a['price'],
                        'power' => $a['power'],
                        'pv' => $a['pv'],
                        'game_id' => GameCurrent::id(),
                        'player_id' => Local::player()->id,
                    ]);
                }
            }
        }
    }


}