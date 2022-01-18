<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameTurn extends Model
{
    use HasFactory;

    public $fillable = [
        'player_id', 
        'phase', 
        'turn', 
        'game_id'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

}
