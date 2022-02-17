<?php

namespace App\Custom\Services;

use App\Models\Card;
use App\Models\Game;
use App\Models\User;
use App\Models\Title;
use App\Models\Player;
use App\Models\Soldier;
use App\Models\Village;
use App\Models\Building;
use Illuminate\Support\Arr;
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
        self::setPlayerIdentity();
        self::createTitles();
        self::createVillages();
        self::createBuildings();
        self::createSoldiers();
        self::setPlayerOrder();
        self::drawLords();

        return response('Game created', 201);
    }

    private static function createGame() : void
    {
        if(!Game::current()){
            Game::create([
                'mod'=>self::$mod,
                'current_phase'=> -1,
            ]);
        }
    }

    private static function createDecks() : void
    {
        if(Game::current()->cards->isEmpty()){
            DeckServices::setUpDecks(self::$mod);
        }
    }

    private static function createPlayers() : void
    {
        $users = User::where('in_game', true)->get();
        foreach($users as $user){
            Player::create([
                'game_id' => Game::current()->id,
                'user_id' => $user->id,
                // 'family_name' => self::setName(),
                // 'color' => self::setColor(),
                'gold' => 5
            ]);
        }
    }

    private static function setPlayerIdentity()
    {
        $i = 1;
        $colors = Librarian::decipherJson('meta/colors.json')->flatten()->shuffle();
        $names = Librarian::decipherJson('meta/family_names.json')->flatten()->shuffle();
        $players = Game::current()->players;
        foreach($players as $player){
            $player->update([
                'color' => $colors[$i],
                'family_name' => $names[$i]
            ]);
            $i++;
        }
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
                    'crown_zone' => $v['crown_zone'],
                    'cross_zone' => $v['cross_zone'],
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
                        'type' => $b['type'],
                        'price' => $b['price'],
                        'income' => $b['income'],
                        'defense' => $b['defense'],
                        'game_id' => Game::current()->id
                    ]);
                }
            }
        }
    }

    private static function createSoldiers()
    {
        if(Game::current()->soldiers->isEmpty()){

            foreach(Game::current()->players as $player){

                foreach(self::$armies as $a){

                    for($i=0; $i<$a['nb']; $i++){
                        Soldier::create([
                            'type' => $a['type'],
                            'gender' => null,
                            'price' => $a['price'],
                            'power' => $a['power'],
                            'pv' => $a['pv'],
                            'game_id' => Game::current()->id,
                            'player_id' => $player->id,
                        ]);
                    }
                }
            }

            $lords = Card::where([
                'game_id'=>Game::current()->id,
                'deck'=>'lord'
            ])
            ->where('gender', '!=', 'O')
            ->get();
            foreach($lords as $lord){
                Soldier::create([
                    'game_id' => Game::current()->id,
                    'type' => 'lord',
                    'power' => $lord->gender === 'M' ? 1 : 0,
                    'name' => $lord->name,
                    'gender' => $lord->gender
                ]);
            }
        }
    }

    private static function setPlayerOrder()
    {
        $i = 1;
        $players = Arr::shuffle(Game::current()->players->all());
        foreach($players as $player){
            $player->update(['turn_order'=>$i++]);
        }
    }

    private static function drawLords()
    {
        $players = Game::current()->players->sortBy('turn_order')->all();
        foreach($players as $player){
            if($player->inHandCards()->isEmpty()){
                Card::getNext('lord')->update(['is_next'=>false]); // needed to avoid messing with next card index.

                $card = Card::where([
                    'deck' => 'lord',
                    'player_id' => null,
                    'is_next' => false
                ])
                ->where('gender', '!=', 'O')
                ->inRandomOrder()
                ->first();

                $player->draw($card);
            }
        }
    }

}
