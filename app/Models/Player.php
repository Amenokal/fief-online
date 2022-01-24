<?php

namespace App\Models;

use App\Custom\Services\PlayerServices;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'familyname',
        'color',
        'gold',
        'married_to',
        'user_id',
        'game_id',
    ];

    public function lords(int $nb)
    {
        return Card::where([
            'game_id'=>Game::current()->id,
            'player_id' => $this->id,
            'deck' => 'lord'
        ])
        ->skip($nb)
        ->first();
    }

    public function lordsHere(Village $village)
    {
        return Card::where([
            'game_id' => Game::current()->id,
            'player_id' => $this->id,
            'village_id' => $village->id,
            'deck' => 'lord'
        ])->get();
    }
    public function sergeantsHere(Village $village)
    {
        return Soldier::where([
            'player_id' => $this->id,
            'game_id' => Game::current()->id,
            'village_id' => $village->id,
            'type' => 'sergeant'
        ])->get();
    }
    public function knightsHere(Village $village)
    {
        return Soldier::where([
            'player_id' => $this->id,
            'game_id' => Game::current()->id,
            'village_id' => $village->id,
            'type' => 'knight'
        ])->get();
    }
    public function armyHere(Village $village)
    {
        if($this->sergeantsHere($village) || $this->knightsHere($village) || $this->lordsHere($village)){
            return true;
        }else {
            return false;
        }
    }

    public function remainingSergeants()
    {
        return Soldier::where([
            'game_id'=>Game::current()->id,
            'village_id'=>null,
            'type'=>'sergeant'
        ])->get();
    }
    public function remainingKnights()
    {
        return Soldier::where([
            'game_id'=>Game::current()->id,
            'village_id'=>null,
            'type'=>'knight'
        ])->get();
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function soldiers()
    {
        return $this->hasMany(Soldier::class);
    }

    public function villages()
    {
        return $this->hasMany(Village::class);
    }



    /////



    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
