<?php

namespace App\Http\Controllers\Game;

use App\Custom\Entities\BannerInfo;
use App\Custom\Helpers\Realm;
use App\Models\Game;
use Illuminate\Http\Request;
use App\Events\NewTurnBannerEvent;
use App\Http\Controllers\Controller;
use App\Custom\Services\TurnServices;
use App\Events\NewTurnBannerForOthersEvent;
use App\Events\UpdateGameEvent;

class TurnController extends Controller
{
    public static function giveTurn(Request $request)
    {
        if(!Game::current()){
            return response()->json(['phase' => -1]);
        }
        elseif(Game::current()->current_phase === 0){
            $turn = TurnServices::giveTurn();
            return response()->json(['turn'=>$turn, 'phase'=>$turn['phase']]);
        }
        else{

            if($request->user()->player->turn_order === Game::current()->current_player){

                if(Game::current()->current_phase<1){
                    BannerInfo::messageForCurrentPlayer($request, '');
                    $turn = TurnServices::giveTurn();
                    return response()->json(['turn'=>$turn, 'phase'=>$turn['phase']]);
                }
                elseif(Game::current()->current_phase === 8){
                    $disasters = Realm::incommingDisasters()->count() > 0;
                    BannerInfo::messageForCurrentPlayer($request, $disasters);
                    BannerInfo::messageForOthers($request, $disasters);

                    if(!$disasters){
                        Game::current()->update(['current_phase'=>9]);
                        event(new UpdateGameEvent());
                    }
                }
            }
            else{
                BannerInfo::messageForOthers($request, '');
            }
        }
    }

    public static function changeTurn(Request $request)
    {
        TurnServices::changeTurn($request->phase);
    }

    public static function endTurn(Request $request)
    {
        if($request->user()->player->turn_order === Game::current()->current_player){
            return TurnServices::passTurn($request);
        }
    }

}
