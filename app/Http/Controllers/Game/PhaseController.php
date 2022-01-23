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
    public function drawFirstLord()
    {
        return GameStartServices::drawFirstLord();
    }

    public function chooseVillage(Request $request)
    {
        $village = Mayor::find($request->village);
        return GameStartServices::chooseVillage($village);
    }



    public function moveAll(Request $request)
    {
        $army = Marechal::armyOf(Realm::lord($request->lord));
        $to = Mayor::find($request->village);

        ArmyServices::march($army, $to);

        return view('components.army', [
            'village' => $to,
            'families' => Realm::families()
        ]);
    }
    public function letOne(Request $request)
    {
        $army = Marechal::letOne(Realm::lord($request->lord))['army'];
        $one = Marechal::letOne(Realm::lord($request->lord))['one'];
        $to = Mayor::find($request->village);

        ArmyServices::march($army, $to);

        return view('components.army', [
            'village' => $to,
            'families' => Realm::families()
        ]);
    }
}
