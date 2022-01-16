<?php 

namespace App\Custom\Classes;

use Illuminate\Http\Request;
use App\Custom\Helpers\CurrentPlayer;

class CardsHandler {

    public function drawLord()
    {
        return response()->json(CurrentPlayer::drawLord());
    }

    public function drawEvent(Request $request)
    {
        return response()->json(CurrentPlayer::drawEvent($request->discard));
    }

    public function discard(Request $request)
    {
        CurrentPlayer::discard($request->name);
    }
    
}