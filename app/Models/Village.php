<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = [
        'name',
        'capital',
        // 'lord_territory',
        // 'religious_territory',
        'game_id',
        'player_id',
    ];

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
        return $this->hasMany(Buildings::class);
    }



    /////



    public function game()
    {
        return $this->belongsTo(Game::class);
    }
    
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

}
