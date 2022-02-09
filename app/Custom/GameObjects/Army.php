<?php

namespace App\Custom\GameObjects;

use App\Models\Player;
use App\Models\Soldier;
use App\Models\Village;
use Illuminate\Support\Collection;

class Army {

    public static $army = [];

    public static function from(Village $village, Player $player) : Collection
    {
        foreach($village->soldiers as $soldier){
            self::$army[] = Soldier::where([
                'player_id' => $player->id,
                'type' => $soldier->type
                ])
                ->first();
        }
        return collect(self::$army);
    }
        public function lords()
        {
            return collect($this)->filter(function ($value, $key){
                return $value->type === 'lord';
            });
        }

        public function soldiers()
        {
            return collect($this)->filter(function ($value, $key){
                return $value->type !== 'lord';
            });
        }

    public function moveAll(Village $to) : void
    {
        foreach($this as $soldier){
            $soldier->update(['village_id'=>$to->id]);
        }

        if(!$to->player_id){
            $to->update(['player_id'=>$soldier->player->id]);
        }
    }
}
