<?php

namespace App\Models;

use App\Models\Card;
use App\Models\Game;
use App\Models\Player;
use App\Models\Soldier;
use App\Models\Building;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Village extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = [
        'name',
        'capital',
        'crown_zone',
        'cross_zone',
        'player_id',
        'game_id'
    ];



    // get himself
    public static function get(string $name) : Village
    {
        return self::where('name', $name)->first();
    }

    // game relationship
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    // owner relationship
    public function player()
    {
        return Player::find($this->player_id);
    }

    // building relationships
    public function buildings()
    {
        return $this->hasMany(Building::class);
    }

   /**
    * Check if this village already has this building.
    *
    * @params "mill" || "castle" || "city"
    */
    public function hasBuilding(string $type) : bool
    {
        return $this->buildings()->where('type', $type)->get()->isNotEmpty();
    }

   /**
    * Return all buildings on this village.
    */
    public function buildingsHere() : Collection
    {
        return $this->buildings()
            ->where([
                'game_id'=>Game::current()->id,
                'village_id'=>$this->id
            ])
            ->get();
    }



    // cards relationships
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

   /**
    * Check if this village is affected by calamity.
    *
    * @params "starvation" || "storm" || "plague" || "harvest" || "wealth".
    */
    public function isModifiedBy(string $name) : bool
    {
        return Card::where([
            'game_id'=>Game::current()->id,
            'cross_id'=>$this->cross_zone,
            'name'=>$name
        ])
        ->exists();
    }



    // title relationship
    public function crownTitle() : Title
    {
        return Title::where([
            'game_id'=>Game::current()->id,
            'id'=>$this->crown_zone
        ])->first();
    }
    public function crossTitle() : Title
    {
        return Title::where([
            'game_id'=>Game::current()->id,
            'id'=>$this->cross_zone
        ])->first();
    }



    // soldiers relationships
    public function soldiers()
    {
        return $this->hasMany(Soldier::class);
    }

    public function lords() : Collection
    {
        return Soldier::where([
            'game_id' => Game::current()->id,
            'type' => 'lord',
            'village_id' => $this->id
        ])->get();
    }

}
