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
use Illuminate\Support\Facades\Auth;

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
        self::setUpDecks();
        self::createPlayers();
        self::setUpVillages();
        self::setUpBuildings();
        self::setUpArmies();
    }

    private static function createGame()
    {
        if(!Games::latest()->exists() || Games::latest()->first()->is_over){
            Games::create(['mod'=>self::$mod]);
            GameTurns::create(['game_id' => Games::current()->id]);
        }
    }
    
    private static function setUpDecks()
    {
        if(!LordCards::where('game_id', Games::current()->id)->exists() && !EventCards::where('game_id', Games::current()->id)->exists() ){
            DeckServices::setUp(self::$mod);
        }
    }
    
    private static function createPlayers()
    {        
        $starting_gold = json_decode(file_get_contents(storage_path('data/'.self::$mod.'/gold.json')), true)[0]['gold'];
        
        if(!Players::auth()){
            
            Players::create([
                'game_id' => Games::current()->id,
                'user_id' => Auth::user()->id,
                'familyname' => self::setName(),
                'color' => self::setColor(),
                'gold' => $starting_gold
            ]);
            
        }
    }
    private static function setName()
    {
        foreach(Games::current()->players() as $player){
            self::$family_names->flip()->forget($player->familyname);
        }
        return self::$family_names->random();
    }
    private static function setColor()
    {
        foreach(Games::current()->players() as $player){
            self::$colors->flip()->forget($player->color)->flip();
        }
        return self::$colors->random();
    }

    private static function setUpVillages()
    {
        foreach(self::$villages as $v){
            Villages::create([
                'name' => $v['name'],
                'lord_territory' => $v['lord_territory'],
                'religious_territory' => $v['religious_territory'],
                'capital' => $v['capital'],
                'game_id' => Games::current()->id
            ]);
        }
    }

    private static function setUpBuildings()
    {
        foreach(self::$buildings as $b){

            for($i=0; $i<$b['nb']; $i++){
            Buildings::create([
                'name' => $b['name'],
                'price' => $b['price'],
                'income' => $b['income'],
                'defense' => $b['defense'],
                'game_id' => Games::current()->id
            ]);
            }
        }
    }

    private static function setUpArmies(){

        if(!Soldiers::where('player_id', Players::auth()->id)->exists()){

            foreach(self::$armies as $a){
                
                for($i=0; $i<$a['nb']; $i++){
                    Soldiers::create([
                        'name' => $a['name'],
                        'price' => $a['price'],
                        'power' => $a['power'],
                        'pv' => $a['pv'],
                        'game_id' => Games::current()->id,
                        'player_id' => Players::auth()->id,
                    ]);
                }
            }
        }
    }


}