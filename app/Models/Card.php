<?php

namespace App\Models;

use App\Custom\Helpers\Local;
use App\Custom\Helpers\Marechal;
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
        'name',
        'deck',
        'gender',
        'instant',
        'disaster',
        'on_board',
        'is_next',
        'img_src',
        'game_id',
        'player_id',
        'village_id',
        // 'lord_title_id',
        // 'religious_title_id',
    ];

    public function isTitled()
    {
        return Title::where([
            'game_id' => Game::current()->id,
            'lord_id' => $this->id,
        ])->exists();
    }

    public static function draw(Card $card)
    {
        return $card->update(['player_id' => Local::player()->id]);
    }

    public function play()
    {
        $this->update(['on_board' => true]);
        return $this;
    }

    public static function discard(Card $card)
    {
        $card->update([
            'on_board' => false,
            'player_id' => null,
            'village_id' => null
        ]);
        $card->delete();
    }

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


}
