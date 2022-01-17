<?php

namespace App\Models;

use App\Custom\Services\PlayerServices;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Players extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'game_id',
        'familyname',
        'color',
        'gold',
        'married_to'
    ];

    public static function auth()
    {
        return Players::where('user_id', Auth::user()->id)->first();
    }

    public function cards()
    {
        $lord_cards = LordCards::where('player_id', $this->id)->get();
        $event_cards = EventCards::where('player_id', $this->id)->get();
        return $lord_cards->merge($event_cards);
    }

    public function draw(string $type)
    {
        return PlayerServices::drawCard($this, $type);
    }

}
