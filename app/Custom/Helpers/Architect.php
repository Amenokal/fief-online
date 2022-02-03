<?php

namespace App\Custom\Helpers;

use App\Models\Player;
use App\Models\Village;
use App\Models\Building;
use App\Models\Buildings;

class Architect {

    public static function building(string $type){
        if($type === 'moulin'){
            return Realm::remainingBuildings()->where('name', 'moulin')->first();
        }
        elseif($type === 'chateau'){
            return Realm::remainingBuildings()->where('name', 'chateau')->first();
        }
        elseif($type === 'cite'){
            return Realm::remainingBuildings()->where('name', 'cite')->first();
        }
    }

    public static function build(Building $building, Village $village)
    {
        $building->update(['village_id' => $village->id]);
    }

    public static function destroy(string $type, Village $village)
    {
        if($village->hasBuilding($type)){

            $village->update(['village_id' => null]);
        }
    }
}
