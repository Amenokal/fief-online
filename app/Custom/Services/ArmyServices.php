<?php

namespace App\Custom\Services;

use App\Models\Card;
use App\Models\Game;
use App\Models\Soldier;
use App\Models\Village;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Realm;
use Illuminate\Support\Collection;

class ArmyServices {

    public static function moveAll(Collection $army, Village $to)
    {
        foreach($army as $soldier){
            $soldier->update(['village_id' => $to->id]);
        }
        Mayor::administrate();
    }

    public static function letOne(Card $lord)
    {
        $lords = Card::where([
            'game_id' => Game::current()->id,
            'deck' => 'lord',
            'village_id' => $lord->village_id
        ])->get();

        $soldiers = Soldier::where([
            'game_id' => Game::current()->id,
            'village_id' => $lord->village_id
        ])
        ->orderBy('type', 'desc')
        ->get();
        $one = $soldiers[0];
        $soldiers = $soldiers->skip(1)->all();

        Mayor::administrate();


        return ['army'=>collect($lords)->merge(collect($soldiers)), 'one'=>$one];
    }

}
