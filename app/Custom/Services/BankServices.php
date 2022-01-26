<?php

namespace App\Custom\Services;

use App\Models\Village;
use App\Models\Building;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Realm;

class BankServices {

    public static function income()
    {
        $gold = Local::player()->gold;
        $villages = Local::player()->villages();

        $income = $gold + $villages->count();

        foreach($villages as $vilg){
            if($vilg->hasMill()){
                $income += 2;
            }
        }

        // CARDS INCOME HERE ...

        Local::player()->update(['gold'=>$income]);
        return ['income'=>$income-$gold, 'newTotal'=>$income];
    }

    public static function buyBuilding(Building $building)
    {
        Local::player()->update(['gold'=>Local::player()->gold -= $building->price]);

        return [
            'price' => $building->price,
            "newTotal" => Local::player()->gold + $building->price,
            "building" => $building
        ];
    }
}
