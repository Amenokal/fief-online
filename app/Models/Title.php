<?php

namespace App\Models;

use App\Models\Village;
use Illuminate\Support\Collection;
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


    /**
     * Return corresponding crown title.
     * $zone range => 1 to 8;
     */
    public static function getCrown(int $zone) : self
    {
        if($zone>0 && $zone<9){
            return Title::where([
                'game_id' => Game::current()->id,
                'crown_zone' => $zone
            ])
            ->first();
        }
    }



    /**
     * Return corresponding cross title.
     * $zone range => 1 to 5;
     */
    public static function getCross(int $zone) : self
    {
        if($zone>0 && $zone<5){
            return Title::where([
                'game_id' => Game::current()->id,
                'cross_zone' => $zone
            ])
            ->first();
        }
    }



    /**
     * Return all villages ruled by this title.
     * Villages depends if chained after a crown title or a cross title.
     */
    public function villages() : Collection
    {
        if($this->crown_id){
            return Village::where([
                'game_id'=>Game::current()->id,
                'crown_zone'=>$this->zone
            ])->get();
        }
        else if($this->cross_id){
            return Village::where([
                'game_id'=>Game::current()->id,
                'cross_zone'=>$this->zone
            ])->get();
        }
    }
}
