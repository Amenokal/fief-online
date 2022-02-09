<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = [
        'type',
        'price',
        'income',
        'defense',
        'village_id',
        'game_id',
    ];



    // relationships
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }



    // methods
    /**
     * Return a Building wich is still available.
     *
     * @params "mill" || "castle" || "city"
     */
    public static function get(string $type) : Building
    {
        return Building::where([
            'village_id'=>null,
            'type'=>$type,
            'game_id'=>Game::current()->id
        ]);
    }

    /**
     * Return true if a building is still available to purchase.
     *
     * @params "mill" || "castle" || "city"
     */
    public static function isStillAvailable(string $type) : bool
    {
        return Building::where([
            'village_id'=>null,
            'type'=>$type,
            'game_id'=>Game::current()->id
        ])->exists();
    }

}
