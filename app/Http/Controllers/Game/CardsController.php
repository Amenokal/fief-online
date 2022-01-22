<?php

namespace App\Http\Controllers\Game;

use Illuminate\Http\Request;
use App\Custom\Helpers\Gipsy;
use App\Http\Controllers\Controller;
use App\Custom\Services\DeckServices;

class CardsController extends Controller
{
    public static function draw(Request $request)
    {
        return DeckServices::draw($request->deck, $request->isDisaster);
    }

    public static function discard(Request $request)
    {
        DeckServices::discard($request->deck, $request->card);
    }

    public static function shuffle(Request $request)
    {
        return Gipsy::shuffleDeck($request->deck);
    }
}
