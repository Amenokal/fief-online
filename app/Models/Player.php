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

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function soldiers()
    {
        return $this->hasMany(Soldier::class);
    }

    public function turn()
    {
        return $this->hasOne(GameTurn::class);
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
