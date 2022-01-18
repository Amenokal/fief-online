<?php

namespace App\Models;

use App\Custom\Helpers\Local;
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
        'type',
        'gender',
        'instant',
        'on_board',
        'order',
        'img_src',
        'game_id',
        'player_id',
        'village_id',
        // 'lord_title_id',
        // 'religious_title_id',
    ];



    public static function draw(Card $card)
    {
        return $card->update(['player_id' => Local::player()->id]);
    }

    public function play()
    {
        return $this->update(['on_board' => true]);
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
