<?php

namespace App\Custom\Services;

use App\Models\Game;
use App\Models\Title;
use App\Models\Player;
use App\Models\Village;
use App\Models\Building;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Realm;

class BankServices {

    public static $income;

    public static function income()
    {
        $gold = Local::player()->gold;
        $villages = Local::player()->villages()->get();
        self::$income = $gold + $villages->count();

        foreach($villages as $vilg){
            if($vilg->hasMill() && !$vilg->isModifiedBy('Impôts')){

                self::$income += 2;

                if($vilg->isModifiedBy('Beau Temps')){
                    self::$income++;
                }
                if($vilg->isModifiedBy('Bonne Récolte')){
                    self::$income++;
                }
            }
        }

        // TAX INCOME HERE
        // QUEEN INCOME HERE

        Local::player()->update(['gold'=>self::$income]);
        return ['income'=>self::$income-$gold];
    }

    public static function canBuyCardinal(Player $player){
        $title =  Title::where([
            'game_id' => Game::current()->id,
            'type' => 'payed-cross',
            'lord_id' => null
        ]);
        return $title->exists() && ($player->gold >= 5);
    }

    public static function canBuyMill(Village $village, Player $player){

        if(Realm::remainingBuildings()->where('name', 'moulin')->isNotEmpty() &&
        !$village->hasMill() && $player->gold>=3 && ($village->player_id === $player->id)){
            return true;
        }
        else{
            return false;
        }
    }

    public static function canBuyCastle(Village $village, Player $player){

        if(Realm::remainingBuildings()->where('name', 'chateau')->isNotEmpty() &&
        $village->buildingsHere()->where('name', 'chateau')->isEmpty() &&
        $player->gold>=10 && ($village->player_id === $player->id)){
            return true;
        }
        else{
            return false;
        }
    }

    public static function canBuyTitle(Village $village, Player $player){
        $title = $village->title();
        $villages = $title->villages();
        $price = $villages->count() * 2;

        if($player->gold>=$price && $village->hasBuilding('chateau')){

            foreach($villages as $vilg){
                if(!$vilg->owner() || (!$vilg->owner()->id === Local::player()->id)){
                    return false;
                }
            }

            return true;
        }
        else{
            return false;
        }
    }

    public static function canBuySergeant(Village $village, Player $player){
        return $player->remainingSergeants()->isNotEmpty() &&
            ($village->soldiers->where('just_arrived')->count() <= 4 ) &&
            ($player->gold >= 1);
    }
    public static function canBuyKnight(Village $village, Player $player){
        return $player->remainingKnights()->isNotEmpty() &&
            ($village->soldiers->where('just_arrived')->count() <= 4 ) &&
            ($player->gold >= 3);
    }
}
