<?php

namespace App\Custom\Helpers;

use App\Models\Village;
use App\Models\Building;
use App\Models\Villages;
use App\Models\Buildings;

class Architect {

    public static function build(string $type, Village $village)
    {   
        if(!$village->hasBuilding($type)){
            Building::where('name', $type)
            ->whereNull('village_id')
            ->first()
            ->update(['village_id' => $village->id]);
            return $village;
        }
        return false;
    }

    public static function destroy(string $type, Village $village)
    {
        if($village->hasBuilding($type)){
            $village->update(['village_id' => null]);
            return $village;
        }
        return false;
    }

    // public static function inspect($type, Village $village)
    // {
    //     return; //
    // }

}