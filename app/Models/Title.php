<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = [
        'type',
        'zone',
        'title_m',
        'title_f',
        'player_id',
        'lord_id',
        'game_id'
    ];
}
