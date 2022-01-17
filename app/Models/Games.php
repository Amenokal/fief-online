<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Games extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = ['mod', 'is_over'];

    public static function current()
    {
        return self::latest()->first();
    }

    public function players()
    {
        return Players::where('game_id', $this->id)->get();
    }
}
