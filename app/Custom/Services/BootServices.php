<?php

namespace App\Custom\Services;

use App\Models\Game;
use App\Models\Title;
use App\Models\Player;
use App\Models\Soldier;
use App\Models\Village;
use App\Models\Building;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Librarian;

class BootServices {

    public static $mod;
    public static $family_names;
    public static $colors;
    public static $titles;
    public static $villages;
    public static $buildings;
    public static $armies;

    public static function init(string $mod)
    {
        self::$mod = $mod;
        self::$family_names = Librarian::decipherJson('meta/family_names.json')->flatten();
        self::$colors = Librarian::decipherJson('meta/colors.json')->flatten();
        self::$titles = Librarian::decipherJson(self::$mod.'/titles.json');
        self::$villages = Librarian::decipherJson(self::$mod.'/villages.json');
        self::$buildings = Librarian::decipherJson(self::$mod.'/buildings.json');
        self::$armies = Librarian::decipherJson(self::$mod.'/armies.json');

        self::createGame();
        self::createDecks();
        self::createPlayers();
        self::createTitles();
        self::createVillages();
        self::createBuildings();
        self::createArmies();
    }

    private static function createGame()
    {
        if(!Game::current() || Game::current()->is_over){
            Game::create(['mod'=>self::$mod]);
        }
    }

    private static function createDecks()
    {
        if(Game::current()->cards->isEmpty()){
            DeckServices::setUpDecks(self::$mod);
        }
    }

    private static function createPlayers()
    {
        if(!Local::player()){

            Player::create([
                'game_id' => Game::current()->id,
                'user_id' => Local::user()->id,
                'familyname' => self::setName(),
                'color' => self::setColor(),
                'gold' => 5
            ]);

        }
    }
        private static function setName()
        {
            foreach(Game::current()->players as $player){
                self::$family_names->flip()->forget($player->familyname);
            }
            return self::$family_names->random();
        }
        private static function setColor()
        {
            foreach(Game::current()->players as $player){
                self::$colors->flip()->forget($player->color);
            }
            return self::$colors->random();
        }

    private static function createTitles()
    {
        if(Game::current()->titles->isEmpty()){

            foreach(self::$titles as $t){

                Title::create([
                    'type' => $t['type'],
                    'zone' => $t['zone'] ?? null,
                    'title_m' => $t['title_m'] ?? null,
                    'title_f' => $t['title_f'] ?? null,
                    'game_id' => Game::current()->id
                ]);
            }

        }
    }

    private static function createVillages()
    {
        if(Game::current()->villages->isEmpty()){

            foreach(self::$villages as $v){
                Village::create([
                    'name' => $v['name'],
                    'lord_territory' => $v['lord_territory'],
                    'religious_territory' => $v['religious_territory'],
                    'capital' => $v['capital'],
                    'game_id' => Game::current()->id
                ]);
            }
        }

    }

    private static function createBuildings()
    {
        if(Game::current()->buildings->isEmpty()){

            foreach(self::$buildings as $b){

                for($i=0; $i<$b['nb']; $i++){
                Building::create([
                    'name' => $b['name'],
                    'price' => $b['price'],
                    'income' => $b['income'],
                    'defense' => $b['defense'],
                    'game_id' => Game::current()->id
                ]);
                }
            }
        }
    }

    private static function createArmies()
    {
        if(Game::current()->soldiers->isEmpty()){

            foreach(self::$armies as $a){

                for($i=0; $i<$a['nb']; $i++){
                    Soldier::create([
                        'type' => $a['type'],
                        'price' => $a['price'],
                        'power' => $a['power'],
                        'pv' => $a['pv'],
                        'game_id' => Game::current()->id,
                        'player_id' => Local::player()->id,
                    ]);
                }
            }
        }
    }


}
