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
        $to = Mayor::find($request->villageTo);
        $army = Marechal::armyOf(Realm::lord($request->lord));
        ArmyServices::move($army, $to);

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

    public function letOne(Request $request)
    {
        $to = Mayor::find($request->villageTo);
        $lord = Realm::lord($request->lord);
        $army = Marechal::armyOf($lord);

        $moving = ArmyServices::letOne($army, $lord)['moving'];
        $staying = ArmyServices::letOne($army, $lord)['staying'];
        ArmyServices::move($moving, $to);

        return response()
        ->view('components.army', [
            'village' => Mayor::find($request->villageTo),
            'families' => Realm::families()
        ])
        ->withHeaders([
            'toVillageColor' => Mayor::find($request->villageTo)->player->color ?? false,
            'staying' => $staying->type
         ]);
    }
}
