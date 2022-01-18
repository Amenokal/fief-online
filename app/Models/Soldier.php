<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soldier extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = [
        'type',
        'price',
        'power',
        'pv',
        'village_id',
        'player_id',
        'game_id',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
    
}
