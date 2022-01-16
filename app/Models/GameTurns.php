<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameTurns extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = ['turn', 'phase', 'player', 'game_id'];

}
