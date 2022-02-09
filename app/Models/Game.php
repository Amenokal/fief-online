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
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'mod',
        'is_started',
        'is_over',
        'current_player',
        'current_phase',
        'current_turn',
    ];



    public static function current()
    {
        return Game::latest()->first();
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }



    public function cards()
    {
        return $this->hasMany(Card::class);
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

    public function titles()
    {
        return $this->hasMany(Title::class);
    }

    public static function turn()
    {
        return [
            'player'=>Game::current()->current_player,
            'phase'=>Game::current()->current_phase,
            'turn'=>Game::current()->current_turn
        ];
    }
}
