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

    public static function move(Collection $army, Village $to)
    {
        foreach($army as $soldier){
            $soldier->update(['village_id' => $to->id]);
        }
        Mayor::administrate();
    }

    public static function letOne(Collection $army, Card $moving_lord)
    {

        $sergeants = $army->filter(function ($value, $key) {
            return $value->type === 'sergeant';
        });
        $knights = $army->filter(function ($value, $key) {
            return $value->type === 'knight';
        });
        $lords = $army->filter(function ($value, $key) {
            return !!$value->gender;
        });

        if($sergeants->isNotEmpty()){
            $staying = $sergeants->shift();
        }
        else{
            if($knights->isNotEmpty()){
                $staying = $knights->shift();
            }
            else{
                if($lords->isNotEmpty()){
                    foreach($lords as $lord){
                        if($lord !== $moving_lord){
                            $staying = $lords->shift();
                        }
                    }
                }
            }
        }
        $moving = collect([$sergeants, $knights, $lords]);

        return ['moving'=>collect($moving)->flatten(), 'staying'=>$staying];

    }

}
