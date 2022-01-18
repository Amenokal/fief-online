<?php

namespace App\Custom\Helpers;

use App\Models\Villages;
use App\Models\Buildings;

class Architect {

    public static function build(string $type, string $village_name)
    {
        $village_id = Villages::where('name', $village_name)->first()->id;
        $target = Buildings::where(['name' => $type, 'village_id' => $village_id]);
        
        if(!$target->exists()){
            Buildings::where([
                'name' => $type,
                'game_id' => GameCurrent::id(),
                'village_id' => null
            ])
            ->first()
            ->update([
                'village_id' => $village_id,
            ]);
        }
    }

    public static function destroy(string $type, string $village_name)
    {
        $village_id = Villages::where('name', $village_name)->first()->id;
        $target = Buildings::where(['name' => $type, 'village_id' => $village_id]);

        if($target->exists()){
            $target->update([
                'village_id' => null,
            ]);
        }
    }

}