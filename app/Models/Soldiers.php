<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soldiers extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = [
        'name',
        'price',
        'power',
        'pv',
        'on_board',
        'game_id',
        'village_id',
        'player_id'
    ];
    
}
