<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buildings extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = [
        'name',
        'price',
        'income',
        'defense',
        'on_board',
        'game_id',
        'village_id'
    ];
}
