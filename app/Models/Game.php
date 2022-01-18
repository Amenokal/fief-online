<?php

namespace App\Models;

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
        return $this->hasMany(LordCard::class);
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
