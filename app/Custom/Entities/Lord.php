<?php

namespace App\Custom\Entities;

use App\Models\Card;
use App\Models\Game;
use App\Models\Title;
use App\Models\Soldier;
use Illuminate\Support\Collection;

class Lord {

   /**
    * Return all Lords as Card Collection.
    */
    public static function all() : Collection
    {
        return Card::whereNotNull('gender')
        ->where('gender', '!=', 'O')
        ->get();
    }


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
            'lord_name' => $this->name,
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
            'lord_name' => $this->name,
        ])
        ->exists();
    }

}
