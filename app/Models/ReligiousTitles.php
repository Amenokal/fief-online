<?php

namespace App\Models;

use App\Custom\Helpers\CurrentGame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReligiousTitles extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = [
        'player_id'
    ];

}
