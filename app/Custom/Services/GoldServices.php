<?php

namespace App\Custom\Services;

use App\Models\Players;

class GoldServices {

    public static function modify(Players $target, int $amount)
    {
        for($i=0; $i<$amount; $i++){
            if($amount>0){
                $target->increment('gold');
            }else{
                $target->decrement('gold');
            }
        }
    }

    public static function transfer(Players $from, int $amount, Players $to)
    {
        for($i=0; $i<$amount; $i++){
            $from->decrement('gold');
            $to->increment('gold');
        }
    }

}
