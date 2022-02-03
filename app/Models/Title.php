<?php

namespace App\Models;

use App\Models\Village;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function villages()
    {
        return Village::where([
            'game_id'=>Game::current()->id,
            'lord_territory'=>$this->zone
        ])->get();
    }
}
