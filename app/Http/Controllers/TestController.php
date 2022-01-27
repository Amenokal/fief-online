<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Game;
use App\Models\Games;
use App\Models\Players;
use App\Models\Soldier;
use App\Models\Village;
use App\Models\Building;
use App\Models\Villages;
use App\Models\Buildings;
use Illuminate\Http\Request;
use App\Custom\Helpers\Gipsy;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Realm;
use App\Custom\Helpers\Builder;
use App\Custom\Helpers\Marechal;
use App\Custom\Helpers\Architect;
use Illuminate\Support\Facades\Auth;
use App\Custom\Services\BootServices;
use App\Custom\Services\DeckServices;
use App\Custom\Services\StartGameServices;

class TestController extends Controller
{
    public function resetCards()
    {
        Card::where('game_id', Game::current()->id)
        ->update([
            'on_board'=>false,
            'player_id'=>null,
            'village_id'=>null,
            'is_next' => false
        ]);
        Gipsy::shuffleDeck('lord');
        Gipsy::shuffleDeck('event');
    }

    public function resetBoard()
    {
        Building::where('game_id',Game::current()->id)
        ->update(['village_id'=>null,]);

        Village::where('game_id',Game::current()->id)
        ->update(['player_id'=>null]);

        Card::where([
            'game_id' => Game::current()->id,
        ])
        ->update([
            'on_board'=>false,
            'village_id'=>null,
            'cross_id'=>null
        ]);

        Soldier::where('game_id',Game::current()->id)
        ->update(['village_id'=>null]);
    }

    public function playerBoard()
    {
        return view('components.player-board');
    }

}
