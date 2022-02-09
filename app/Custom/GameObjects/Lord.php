<?php

namespace App\Custom\GameObjects;

use App\Models\Card;
use App\Models\Game;
use App\Models\Title;
use App\Models\Soldier;
use Illuminate\Support\Collection;

class Lord {

   /**
    * Return the corresponding card.
    */
    public static function asCard(string $name) : Card
    {
        return Card::where([
            'game_id' => Game::current()->id,
            'name' => $name
        ])
        ->first();
    }

   /**
    * Return the corresponding soldier.
    */
    public static function asSoldier(string $name) : Soldier
    {
        return Soldier::where([
            'game_id' => Game::current()->id,
            'name' => $name
        ])
        ->first();
    }



   /**
    * Return corresponding titles.
    * Must be chained after asCard()
    */
    public function titles() : Collection
    {
        return Title::where([
            'game_id' => Game::current()->id,
            'lord_id' => $this->id,
        ])
        ->get();

    }

   /**
    * Return true if lord is titled.
    * Must be chained after asCard()
    */
    public function isTitled() : bool
    {
        return Title::where([
            'game_id' => Game::current()->id,
            'lord_id' => $this->id,
        ])
        ->exists();
    }
}
