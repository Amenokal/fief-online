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

    public static function turn()
    {
        return GameTurns::where('id', self::current()->id)->first();
    }

    public function eventCards()
    {
        return EventCards::where('game_id', $this->id)->get();
    }
    public function lordCards()
    {
        return LordCards::where('game_id', $this->id)->get();
    }
    
}
