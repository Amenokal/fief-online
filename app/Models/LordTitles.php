<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LordTitles extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = [
        'player_id'
    ];
    
}
