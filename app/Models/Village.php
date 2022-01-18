<?php

namespace App\Models;

use App\Models\Building;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Village extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = [
        'name',
        'capital',
        // 'lord_territory',
        // 'religious_territory',
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
