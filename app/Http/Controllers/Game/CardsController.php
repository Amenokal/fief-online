<?php

namespace App\Http\Controllers\Game;

use Illuminate\Http\Request;
use App\Custom\Helpers\Gipsy;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Realm;
use App\Custom\Helpers\Marechal;
use App\Http\Controllers\Controller;
use App\Custom\Services\DeckServices;
use Illuminate\Http\JsonResponse;

class CardsController extends Controller
{
    public static function discard(Request $request)
    {
        DeckServices::discard($request, $request->cardName);
    }

    public static function initDraw(Request $request) : JsonResponse
    {
        if($request->user()->player->inHandCards()->count() > 2){
            return response()->json(['allowed'=>false]);
        }
        else {
            if(is_null($request->user()->player->drawn_card) || $request->user()->player->drawn_card === 'event'){
                return response()->json(['allowed'=>true, 'event'=>true, 'lord'=>true]);
            }
            elseif($request->user()->player->drawn_card === 'lord'){
                return response()->json(['allowed'=>true, 'event'=>true]);
            }
            else {
                return response()->json(['allowed'=>false]);
            }
        }
    }

    public static function draw(Request $request)
    {
        return DeckServices::draw($request);
    }



    public static function shuffle(Request $request)
    {
        return Gipsy::shuffleDeck($request->deck);
    }

    public static function showDisasters()
    {
        return DeckServices::showDisasters();
    }

    public static function playLord(Request $request)
    {
        $lord = Realm::inHandLord($request->lord);
        $village = Mayor::find($request->village);
        if($village->owner()->id === Local::player()->id){
            Marechal::newLord($lord, $village);
        }
    }

    public static function addWealth(Request $request)
    {
        $village = Mayor::find($request->village);
        $card = $request->card;
        DeckServices::addWealth($card, $village);
    }

    public static function removeDisaster(Request $request)
    {
        $village = Mayor::find($request->village);
        $card = $request->card;
        DeckServices::removeDisaster($card, $request->disaster, $village);
    }
}
