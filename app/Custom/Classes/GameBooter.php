<?php 

namespace App\Custom\Classes;

use App\Models\User;
use App\Models\Games;
use App\Models\Players;
use App\Models\GameTurns;
use App\Models\LordCards;
use App\Models\EventCards;
use App\Custom\Helpers\LordDeck;
use App\Custom\Helpers\EventDeck;
use App\Custom\Helpers\CurrentGame;
use Illuminate\Support\Facades\Auth;
use App\Custom\Helpers\CurrentPlayer;

class GameBooter
{
    public static function init(string $mod)
    {
        self::createGame($mod);
        self::setUpDecks($mod);
        self::createPlayers($mod);
        self::setUpVillages($mod);
    }

    protected static function createGame(string $mod)
    {
        if(!Games::latest()->exists() || Games::latest()->first()->is_over){

            Games::create(['mod'=>$mod]);
            GameTurns::create(['game_id' => CurrentGame::id()]);

        }
    }

    protected static function setUpDecks(string $mod)
    {
        if(!LordCards::where('game_id', CurrentGame::id())->exists() && !EventCards::where('game_id', CurrentGame::id())->exists() ){

            LordDeck::setUp($mod);
            EventDeck::setUp($mod);

        }
    }

    protected static function createPlayers(string $mod)
    {

        // TODO : change function to create only player for CurrentUser
        // make middleware for it
        // -> check for other players in same game for familyname/color


        $connecting_users = User::where('in_game', true)->get();

        $family_names = json_decode(file_get_contents(storage_path('data/meta/family_names.json')), true);
        $colors = json_decode(file_get_contents(storage_path('data/meta/colors.json')), true);
        $starting_gold = json_decode(file_get_contents(storage_path('data/'.$mod.'/gold.json')), true)[0]['gold'];

        foreach($connecting_users as $user){
            
            shuffle($colors);
            $color = array_shift($colors)['color'];
            
            shuffle($family_names);
            $fname = array_shift($family_names)['name'];

            if(!Players::where([['game_id', CurrentGame::id()],['user_id', Auth::user()->id]])->exists()){
                
                Players::create([
                    'game_id' => CurrentGame::id(),
                    'user_id' => $user->id,
                    'familyname' => $fname,
                    'color' => $color,
                    'gold' => $starting_gold
                ]);
                CurrentPlayer::drawLord();
            }
        }
    }

    protected static function setUpVillages(string $mod)
    {

    }
}