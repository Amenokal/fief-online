<?php

namespace App\Http\Controllers;

use App\Models\Games;
use App\Models\Players;
use App\Models\Villages;
use App\Models\Buildings;
use Illuminate\Http\Request;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Builder;
use App\Custom\Helpers\Marechal;
use Illuminate\Support\Facades\Auth;
use App\Custom\Services\BootServices;
use App\Custom\Services\DeckServices;
use App\Custom\Services\StartGameServices;

class TestController extends Controller
{
    public function test()
    {
        $card = StartGameServices::drawFirstLord();
        return response()->json($card);
    }

    public function test2(Request $request)
    {
        $village = StartGameServices::chooseVillage($request->village);
        return response()->json($village);
    }

    public function test3(Request $request)
    {
        // return Marechal::moveArmy;
    }

    public function t(Request $request)
    {
        dd(Games::current()->soldiers);
    }

}
