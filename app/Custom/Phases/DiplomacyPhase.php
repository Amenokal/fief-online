<?php

namespace App\Custom\Phases;

use App\Models\Card;
use App\Models\Game;
use App\Models\Title;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Custom\Entities\Lord;
use App\Events\MarriageEvent;
use Illuminate\Http\JsonResponse;
use App\Events\MarryProposalEvent;
use App\Events\BishopCandidatEvent;
use App\Events\ValidateChoiceEvent;

class DiplomacyPhase {

    // MARRIAGE

    public static function canMarry(Request $request) : JsonResponse
    {
        $player = $request->user()->player;

        if(!!$player->married_to || $player->turn_order === Game::current()->current_player){
            return response()->json(['allowed'=>true]);
        }
        else {
            return response()->json(['allowed'=>false]);
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

    public static function whithWhoCanMarry(Request $request)
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
        return response()->json(['lords'=>[]]);
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



    // BISHOP ELECTION

    public static function initBishopElection(Request $request) : JsonResponse
    {
        foreach(Title::bishops() as $title){
            if($title->isAvailable()){
                return response()->json(['zone' => $title->zone]);
            }
        }
        return response()->json(['zone' => []]);
    }

    public static function newBishopCandidat(Request $request) : void
    {
        event(new BishopCandidatEvent(Lord::asCard($request->lord), $request->event));
    }

    public static function validateChoice(Request $request) : void
    {
        event(new ValidateChoiceEvent($request->user()->player));
    }

    private static $vote;
    private static $votes;

    public static function startBishopElection(Request $request) : JsonResponse
    {
        self::$votes = [];
        foreach(Player::all() as $player){
            self::$vote = 0;
            $title = Title::getCross($request->zone);
            foreach($player->villages as $village){
                if($village->cross_zone === $title->zone){
                    self::$vote += 1;
                    if($village->capital){
                        self::$vote += 1;
                    }
                }
            }

            foreach($player->lords() as $lord){
                if($lord->hasTitle('Évêque')){
                    self::$vote += 2;
                    if($lord->hasTitle('Cardinal')){
                        self::$vote += 1;
                    }
                }
            }

            self::$votes[$player->color] = self::$vote;
        }

        return response()->json(['vote'=>self::$votes]);
    }
}
