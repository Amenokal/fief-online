<?php

namespace App\Models;

use App\Models\Village;
use App\Custom\Entities\Lord;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function isBishopZoneAvailable() : bool
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



    public static function takenCardinals() : Collection
    {
        return Title::where('title_m', 'Cardinal')->whereNotNull('lord_name')->get();
    }



    public static function pope() : Title
    {
        return Title::where('title_m', 'Pape')->first();
    }
    public function canPopeBeElected() : bool
    {
        $canBeElected = true;

        if(!is_null($this->lord_name)){
            $canBeElected = false;
        }

        $cardinals = Title::where('title_m', 'Cardinal')->whereNotNull('lord_name')->get();
        if($cardinals->count() < 2){
            $canBeElected = false;
        }

        return $canBeElected;
    }



    public static function king() : Title
    {
        return Title::where('title_m', 'Roi')->first();
    }
    public function canKingBeElected() : bool
    {
        $canBeElected = true;

        if(!is_null($this->lord_name)){
            $canBeElected = false;
        }

        $nobleLords = [];
        $religiousLords = [];
        foreach(Title::all() as $title){
            if(!is_null($title->lord_name) && $title->type === 'crown'){
                $nobleLords[] = Lord::asCard($title->lord_name)->name;
            }
            elseif(!is_null($title->lord_name) && ($title->type === 'cross' || $title->type === 'payed-cross')){
                $religiousLords[] = Lord::asCard($title->lord_name)->name;
            }
        }

        $nobleLords = array_unique($nobleLords);
        $religiousLords = array_unique($religiousLords);

        if(count($religiousLords) < 2 || count($nobleLords) + count($religiousLords) < 3){
            $canBeElected = false;
        }

        return $canBeElected;
    }
}
