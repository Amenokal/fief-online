<?php 

namespace App\Custom\Classes;

use App\Models\Games;
use App\Models\Players;
use Illuminate\Http\Request;
use App\Custom\Helpers\CurrentGame;
use App\Custom\Services\TurnServiceProvider;

class TurnsHandler {

    public function endTurn()
    {

        // return TurnServiceProvider::endTurn();
        $turn = CurrentGame::turn();
        $messages = json_decode(file_get_contents(storage_path('data/meta/turn.json')), true);

        return response()->json($messages);
    }

};
