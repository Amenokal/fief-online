<?php

namespace App\Models;

use App\Custom\Helpers\Local;
use App\Custom\Helpers\Marechal;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Card extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;
    public $fillable = [
        'game_id',

        'deck',
        'name',
        'gender',
        'instant',
        'disaster',

        'on_board',
        'is_next',

        'card_img',
        'verso_img',

        'player_id',
        'village_id',
        'crown_id',
        'cross_id',
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
    public static function getNext(string $deck) : self
    {
        return Card::where([
            'deck' => $deck,
            'is_next' => true
        ])
        ->first();
    }



    public function play()
    {
        $this->update(['on_board' => true]);
        return $this;
    }

    public function discard()
    {
        $this->delete();
    }

}
