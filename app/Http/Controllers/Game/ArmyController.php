<?php

namespace App\Http\Controllers\Game;

use App\Models\Card;
use App\Models\Game;
use Illuminate\Http\Request;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Realm;
use App\Custom\Helpers\Marechal;
use App\Http\Controllers\Controller;

class ArmyController extends Controller
{
    public function showArmy(Request $request)
    {
        // $player = Card::where([
        //     'game_id' => Game::current()->id,
        //     'name' => $request->lord
        // ])
        // ->first()
        // ->player;
        // $village = Mayor::find($request->village);
        // return Marechal::evaluate($player, $village);
    }
}
