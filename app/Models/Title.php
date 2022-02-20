<?php

namespace App\Models;

use App\Models\Village;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Title extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;
    public $fillable = [
        'type',
        'zone',
        'title_m',
        'title_f',
        'player_id',
        'lord_name',
        'game_id'
    ];



    /**
     * Return corresponding crown title.
     * $zone range => 1 to 8;
     */
    public static function getCrown(int $zone) : Title
    {
        if($zone>0 && $zone<9){
            return Title::where([
                'game_id' => Game::current()->id,
                'type' => 'crown',
                'zone' => $zone
            ])
            ->first();
        }
    }



    /**
     * Return corresponding cross title.
     * $zone range => 1 to 5;
     */
    public static function getCross(int $zone) : Title
    {
        if($zone>0 && $zone<5){
            return Title::where([
                'game_id' => Game::current()->id,
                'type' => 'cross',
                'zone' => $zone
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
        if($this->type === 'crown'){
            return Village::where([
                'game_id'=>Game::current()->id,
                'crown_zone'=>$this->zone
            ])->get();
        }
        else if($this->type === 'cross'){
            return Village::where([
                'game_id'=>Game::current()->id,
                'cross_zone'=>$this->zone
            ])->get();
        }
    }


    public static function bishops() : Collection
    {
        return Title::where('title_m', 'Évêque')->get();
    }

    public function isAvailable() : bool
    {
        foreach($this->villages() as $vilg){
            if(!$vilg->hasOwner()){
                return false;
            }
        }

        if(!!$this->lord_name){
            return false;
        }

        return true;
    }
}
