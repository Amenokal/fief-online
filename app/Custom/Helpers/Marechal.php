<?php

namespace App\Custom\Helpers;

use App\Models\Card;
use App\Models\Game;
use App\Models\Player;
use App\Models\Soldier;
use App\Models\Village;
use App\Models\Soldiers;
use App\Models\Villages;

class Marechal {

    public static $power = 0;
    public static $power_counter = 0;
    public static $sergeants = 0;
    public static $knights = 0;

    public static function armyOf(Card $lord)
    {
        $lords = Card::where([
            'game_id' => Game::current()->id,
            'deck' => 'lord',
            'village_id' => $lord->village_id
        ])->get();

        $soldiers = Soldier::where([
            'game_id' => Game::current()->id,
            'village_id' => $lord->village_id
        ])->get();

        return collect($lords)->merge(collect($soldiers));
    }

    public static function evaluate(Card $lord, bool $only_banner)
    {
        $army = self::armyOf($lord);

        foreach($army as $men){
            if($men->gender === 'M'){
                self::$power += 1;
            }
            // titled women and d'Arc conditions here later ...
            // d'Arc will be a title btw

            elseif($men->power){
                self::$power += $men->power;
            }
        }

        if(self::$power<7){
            self::$power_counter = 1;
        }elseif(self::$power<13){
            self::$power_counter = 2;
        }else{
            self::$power_counter = 3;
        }

        // dd(self::$power);

        if($only_banner){
            return self::$power_counter;
        }else{
            self::$sergeants = count($army->where('type', 'sergeant')->all());
            self::$knights = count($army->where('type', 'knight')->all());
            $response = [
                'power' => self::$power_counter,
                'sergeants' => self::$sergeants,
                'knights' => self::$knights,
            ];
            return $response;
        }

    }

}