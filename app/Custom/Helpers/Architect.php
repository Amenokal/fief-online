<?php

namespace App\Custom\Helpers;

use App\Models\Village;
use App\Models\Building;
use App\Models\Villages;
use App\Models\Buildings;

class Architect {

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
