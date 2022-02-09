<?php

namespace App\Http\Controllers\Game;

use App\Models\Game;
use App\Models\Player;
use App\Models\Village;
use Illuminate\Http\Request;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Noble;
use App\Custom\Helpers\Realm;
use App\Custom\Helpers\Marechal;
use App\Custom\Helpers\Architect;
use App\Custom\Phases\StarterPhase;
use App\Http\Controllers\Controller;
use App\Custom\Phases\FirstLordPhase;
use App\Custom\Services\ArmyServices;
use App\Custom\Services\BankServices;

class PhaseController extends Controller
{
    // PHASE 0 ::::: START GAME
    public function drawFirstLord()
    {
        return StarterPhase::drawFirstLord();
    }
    public function chooseVillage(Request $request)
    {
        $village = Village::get($request->village);
        return StarterPhase::chooseVillage($village);
    }





    // PHASE ::::: REVENUS
    public function getIncome()
    {
        $data = BankServices::income();
        return response()
            ->view('components.player-info', [
                'fam' => Local::player(),
                'currentplayer' => Realm::currentPlayer()
            ])
            ->withHeaders([
                'data' => $data
            ]);
    }

    // PHASE ::::: BUY
    public function buyMill(Request $request)
    {
        $village = Mayor::find($request->village);
        $building = Architect::building('moulin');

        if(BankServices::canBuyMill($village, Local::player())) {
            Architect::build($building, $village);
            Local::player()->update(['gold'=>Local::player()->gold - $building->price]);

            return response()->view('components.buildings', [
                'building' => $building,
                'village' => $village
            ])
            ->withHeaders([
                'gold'=>Local::player()->gold
            ]);
        }
    }
    public function buyCastle(Request $request)
    {
        $village = Mayor::find($request->village);
        $building = Architect::building('chateau');

        if(BankServices::canBuyCastle($village, Local::player())) {
            Architect::build($building, $village);
            Local::player()->update(['gold'=>Local::player()->gold - $building->price]);

            return response()->view('components.buildings', [
                'building' => $building,
                'village' => $village
            ])
            ->withHeaders([
                'gold'=>Local::player()->gold,
                'color'=>Local::player()->color
            ]);
        }
    }
    public function buySergeant(Request $request)
    {
        $village = Mayor::find($request->village);

        if(BankServices::canBuySergeant($village, Local::player())) {
            Marechal::recruit(['sergeant', 1], $village);
            Local::player()->update(['gold'=> Local::player()->gold - 1]);

            return response()->view('components.army', [
                'families' => Realm::families(),
                'village' => $village
            ])
            ->withHeaders([
                'gold'=>Local::player()->gold,
            ]);
        }
    }
    public function buyKnight(Request $request)
    {
        $village = Mayor::find($request->village);

        if(BankServices::canBuyKnight($village, Local::player())) {
            Marechal::recruit(['knight', 1], $village);
            Local::player()->update(['gold'=> Local::player()->gold - 1]);

            return response()->view('components.army', [
                'families' => Realm::families(),
                'village' => $village
            ])
            ->withHeaders([
                'gold'=>Local::player()->gold,
            ]);
        }
    }
    public function buyTitle(Request $request)
    {
        $title = Noble::crown($request->title);
        $village = Mayor::find($request->village);
        $lord = Realm::lord($request->lord);
        $building = Architect::building('cite');

        if(BankServices::canBuyTitle($village, Local::player())) {
            $price = Noble::priceOf($title);
            Local::player()->update(['gold'=> Local::player()->gold - $price]);
            $lord->getCrown($title);
            Architect::build($building, $village);

            return response()->view('components.buildings', [
                'building' => $building,
                'village' => $village
            ])
            ->withHeaders([
                'gold'=>Local::player()->gold,
                'color'=>Local::player()->color
            ]);
        }
    }




    // PHASE ::::: MOVEMENTS
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

    public function showArmyManager(Request $request)
    {
        $village = Mayor::find($request->village);
        $lord = Realm::lord($request->lord);

        return view('components.army-manager', [
            'player' => $lord->player,
            'village' => $village
        ]);
    }

    public function inspect(Request $request)
    {
        $to = Mayor::find($request->villageTo);
        $army = Marechal::splitedArmy($request);
        ArmyServices::move($army, $to);

        return response()
            ->view('components.army', [
                'village' => Mayor::find($request->villageTo),
                'families' => Realm::families()
            ])
            ->withHeaders([
                'toVillageColor' => $to->player->color ?? false,
            ]);
    }
}
