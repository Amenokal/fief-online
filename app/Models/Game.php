<?php

namespace App\Models;

use App\Models\Card;
use App\Models\User;
use App\Models\Player;
use App\Models\Soldier;
use App\Models\Village;
use App\Models\Building;
use App\Models\GameTurn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory;

    public $fillable = [
        'mod',
        'is_over'
    ];

    public static function current()
    {
        return Game::latest()->first();
    }


    public function turn()
    {
        return $this->hasOne(GameTurn::class);
    }


    public function players()
    {
        return $this->hasMany(Player::class);
    }


    public function cards()
    {
        return $this->hasMany(Card::class);
    }

        public function lordDeck()
        {
            return $this->cards()->where('deck', 'lord')->get();
        }
        public function eventDeck()
        {
            return $this->cards()->where('deck', 'event')->get();
        }


    public function soldiers()
    {
        return $this->hasMany(Soldier::class);
    }
    

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }


    public function villages()
    {
        return $this->hasMany(Village::class);
    }



    /////



    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
