<?php

namespace App\Http\Controllers\Game;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Custom\Services\DeckServices;

class CardsController extends Controller
{
    public static function discard(Request $request)
    {
        DeckServices::discard($request->deck, $request->card);
    }
}
