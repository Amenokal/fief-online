<?php

namespace App\Custom\Phases;

use App\Models\Game;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Custom\Entities\Lord;
use App\Events\MarriageEvent;
use Illuminate\Http\JsonResponse;
use App\Events\MarryProposalEvent;

class DiplomacyPhase {

    public static function canMarry(Request $request) : JsonResponse
    {
        $player = $request->user()->player;

        if(!!$player->married_to || $player->turn_order === Game::current()->current_player){
            return response()->json(['allowed'=>false]);
        }
        else {
            return response()->json(['allowed'=>true]);
        }

    }

    public static function getOtherLords(Request $request) : JsonResponse
    {
        $family = Player::where('family_name', $request->familyName)->first();
        return response()->json([
            'playerColor' => $family->color,
            'lords' => $family->lords()->pluck('name'),
        ]);
    }

    public static function whithWhoCanMarry(Request $request) : JsonResponse
    {
        $lord = Lord::asCard($request->lord);
        if($lord->hasTitle('Évêque') || $lord->hasTitle("d'Arc") || $lord->married){
            return response()->json(['lords'=>[]]);
        }

        $otherFamily = Player::where('color', $request->otherFamilyColor)->first();
        if(!!$lord->player->married_to || !!$otherFamily->married_to){
            return response()->json(['lords'=>[]]);
        }

        $maleLords = [];
        $femaleLords = [];
        foreach($otherFamily->lords() as $otherLord){
            if($otherLord->gender === 'M' && $otherLord->on_board && !$otherLord->hasTitle('Évêque')){
                $maleLords[] = $otherLord->name;
            }
            elseif($otherLord->gender === 'F' && $otherLord->on_board && !$otherLord->hasTitle("d'Arc")){
                $femaleLords[] = $otherLord->name;
            }
        }
        if($lord->gender === 'M' && !!$femaleLords){
            return response()->json(['lords'=>$femaleLords]);
        }
        elseif($lord->gender === 'F' && !!$maleLords){
            return response()->json(['lords'=>$maleLords]);
        }
    }

    public static function sendProposal(Request $request) : void
    {
        $askingLord = $request->askingLord;
        $askingFamily = Lord::asCard($askingLord)->player;
        $askedLord = $request->askedLord;
        $askedFamily = Lord::asCard($askedLord)->player;

        event(new MarryProposalEvent($askingFamily, $askingLord, $askedFamily, $askedLord));
    }

    public static function acceptProposal(Request $request) : void
    {
        $askingLord = $request->askingLord;
        $askedLord = $request->askedLord;
        $askingFamily = Lord::asCard($askingLord)->player;
        $askedFamily = Lord::asCard($askedLord)->player;

        Lord::asCard($askingLord)->update(['married'=>true]);
        Lord::asCard($askedLord)->update(['married'=>true]);
        $askingFamily->update(['married_to'=>$askedFamily->id]);
        $askedFamily->update(['married_to'=>$askingFamily->id]);

        event(new MarriageEvent($askingFamily, $askingLord, $askedFamily, $askedLord));
    }

}
