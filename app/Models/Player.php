<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Custom\Services\PlayerServices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'family_name',
        'color',
        'gold',
        'married_to',
        'turn_order',
        'user_id',
        'game_id',
    ];



    // relationships
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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



    public function inHandCards() : Collection
    {
        return Card::where([
            'game_id'=>Game::current()->id,
            'player_id'=>$this->id,
            'on_board'=>false
        ])
        ->get();
    }



    public function lordsHere(Village $village) : Collection
    {
        return Soldier::where([
            'game_id' => Game::current()->id,
            'player_id' => $this->id,
            'village_id' => $village->id,
            'type' => 'lord'
        ])
        ->get();
    }

    public function soldiersHere(Village $village) : Collection
    {
        return Soldier::where([
            'game_id' => Game::current()->id,
            'player_id' => $this->id,
            'village_id' => $village->id,
        ])
        ->where('type', '!=', 'lord')
        ->get();
    }

    public function armyHere(Village $village) : bool
    {
        return $this->soldiersHere($village) || $this->lordsHere($village);
    }



    public function canBuy(Building $building) : bool
    {
        return $this->gold >= $building->price;
    }



    // METHODS

    public function draw(Card $card) : Card
    {
        $card->update([
            'is_next' => false,
            'player_id' => $this->id
        ]);

        Card::where([
            'deck' => $card->deck,
            'player_id' => null,
            'on_board' => false
        ])
        ->inRandomOrder()
        ->first()
        ->update(['is_next'=>true]);

        return $card;
    }

}
