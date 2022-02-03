<?php

namespace App\Custom\Helpers;

use App\Models\Card;
use App\Models\Game;
use App\Models\Title;
use App\Models\Player;
use App\Models\Soldiers;
use App\Models\Villages;
use App\Models\LordCards;

class Noble {

    public static function crown(int $title)
    {
        return Title::where([
            'game_id'=>Game::current()->id,
            'zone'=>$title
        ])
        ->first();
    }

    public static function priceOf(Title $title)
    {
        return $title->villages()->count() * 2;
    }
}
