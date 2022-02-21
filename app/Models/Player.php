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
        'drawn_card',
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

    public function lords() : Collection
    {
        return Card::where([
            'game_id'=>Game::current()->id,
            'player_id'=>$this->id,
            'on_board'=>true,
            'deck'=>'lord'
        ])
        ->get();
    }

    public function eligibleForBishopLords() : array
    {
        $lords = Card::where([
            'game_id'=>Game::current()->id,
            'player_id'=>$this->id,
            'on_board'=>true,
            'deck'=>'lord',
            'gender'=>'M',
            'married'=>false
        ])
        ->get();

        $lords2 = $lords->filter(function ($value, $key){
            return !$value->hasTitle('Évêque');
        });

        return $lords2->all();
    }

    public function bishopVoteCount(Title $title) : int
    {
        $voteCount = 0;

        foreach($this->villages as $village){
            if($village->cross_zone === $title->zone){
                $voteCount += 1;
                if($village->capital){
                    $voteCount += 1;
                }
            }
        }

        foreach($this->lords() as $lord){
            if($lord->hasTitle('Évêque')){
                $voteCount += 2;
                if($lord->hasTitle('Cardinal')){
                    $voteCount += 1;
                }
            }
        }

        return $voteCount;
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
