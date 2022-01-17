<?php

namespace App\Custom\Services;

use App\Models\Players;
use App\Models\EventCards;

class PlayerServices {

    public static function drawCard(Players $who, string $type)
    {
        $deck = $type === 'lord' ? LordCards::class : EventCards::class;



    }

}