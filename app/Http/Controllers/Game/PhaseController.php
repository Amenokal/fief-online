<?php

namespace App\Http\Controllers\Game;

use Illuminate\Http\Request;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Realm;
use App\Custom\Helpers\Marechal;
use App\Http\Controllers\Controller;
use App\Custom\Services\ArmyServices;
use App\Custom\Services\GameStartServices;

class PhaseController extends Controller
{
    // PHASE 0 ::::: START GAME
    public function drawFirstLord()
    {
        return GameStartServices::drawFirstLord();
    }
    public function chooseVillage(Request $request)
    {
        $village = Mayor::find($request->village);
        return GameStartServices::chooseVillage($village);
    }


    // PHASE ? ::::: MOVEMENTS
    public function moveAll(Request $request)
    {
        $army = Marechal::armyOf(Realm::lord($request->lord));
        ArmyServices::moveAll($army, Mayor::find($request->villageTo));

        return response()
            ->view('components.army', [
                'village' => Mayor::find($request->villageTo),
                'families' => Realm::families()
            ])
            ->withHeaders([
                'fromVillageColor' => Mayor::find($request->villageFrom)->player->color ?? false,
                'toVillageColor' => Mayor::find($request->villageTo)->player->color ?? false,
            ]);
    }

    // public function letOne(Request $request)
    // {
    //     $army = Marechal::letOne(Realm::lord($request->lord))['army'];
    //     $one = Marechal::letOne(Realm::lord($request->lord))['one'];
    //     $to = Mayor::find($request->village);

    //     ArmyServices::march($army, $to);

    //     return response()->json(
    //         ['movingArmy' => view('components.army', [
    //             'village' => $to,
    //             'families' => Realm::families()
    //             ]),
    //         'one' => $one
    //         ]
    //     );
    // }
}
