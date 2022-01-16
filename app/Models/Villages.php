<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Villages extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = [
        'name',
        'lord_territory',
        'religious_territory',
        'player_id',
        'game_id'
    ];

}
