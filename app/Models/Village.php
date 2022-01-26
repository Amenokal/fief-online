<?php

namespace App\Models;

use App\Models\Card;
use App\Models\Game;
use App\Models\Player;
use App\Models\Soldier;
use App\Models\Building;
use App\Custom\Helpers\Marechal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Village extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = [
        'name',
        'capital',
        'lord_territory',
        'religious_territory',
        'game_id',
        'player_id',
    ];

    public function hasBuilding(string $type)
    {
        return $this->buildings()->where('name', $type)->get()->isNotEmpty();
    }



    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function soldiers()
    {
        return $this->hasMany(Soldier::class);
    }

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }

    public function buildingsHere()
    {
        return $this->buildings()
            ->where('village_id', $this->id)
            ->get();
    }

    public function lords()
    {
        return Card::where([
            'game_id' => Game::current()->id,
            'village_id' => $this->id
        ]);
    }

    public function hasMill()
    {
        return Building::where([
            'game_id' => Game::current()->id,
            'village_id' => $this->id,
            'name' => 'moulin'
        ])->exists();
    }

    public function hasArmy()
    {
        return $this->soldiers ? true : false;
    }

    public function hasOwner()
    {
        return !!$this->player;
    }



    /////



    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

}
