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



    // lord relationships
    public static function lord(string $name) : Card
    {
        return Card::where([
            'game_id' => Game::current()->id,
            'name' => $name
        ])
        ->first();
    }



    // methods
    public function draw()
    {
        $this->update(['player_id' => Local::player()->id]);
        return $this;
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
