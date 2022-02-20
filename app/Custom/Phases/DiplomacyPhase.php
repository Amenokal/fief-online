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
use App\Events\BishopElectionEvent;
use App\Events\ValidateChoiceEvent;
use App\Events\EndBishopElectionEvent;
use App\Events\BishopVoteValidatedEvent;
use App\Events\PlayerVotedForBishopEvent;
use App\Events\UpdateGameEvent;

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
        $families = [];
        foreach(Player::all() as $player){
            $families[] = $player->eligibleForBishopLords();
        }

        foreach($families as $eligibles){

            if(!empty($eligibles)){

                foreach(Title::bishops() as $title){
                    if($title->isAvailable()){
                        return response()->json(['zone' => $title->zone]);
                    }
                }

                return response()->json(['error' => "Il n'y a pas d'évêché disponible"]);
            }
        }

        return response()->json(['error' => "Il n'y a aucun seigneur pouvant se présenter"]);
    }

    public static function newBishopCandidat(Request $request) : void
    {
        event(new BishopCandidatEvent(Lord::asCard($request->lord), $request->event));
    }

    public static function validateChoice(Request $request) : void
    {
        event(new ValidateChoiceEvent($request->user()->player));
    }



    private static $votes;

    public static function startBishopElection(Request $request) : JsonResponse
    {
        self::$votes = [];
        foreach(Player::all() as $player){
            self::$votes[$player->color] = $player->bishopVoteCount(Title::getCross($request->zone));
        }

        event(new BishopElectionEvent($request, self::$votes));

        return response()->json(['vote'=>self::$votes]);
    }

    public static function playerVoted(Request $request) : void
    {
        for($i=0; $i<$request->user()->player->bishopVoteCount(Title::getCross($request->zone)); $i++){
            Lord::asCard($request->lordVotedOn)->increment('votes');
        }
        event(new PlayerVotedForBishopEvent($request));
    }

    public static function playerVoteValidated(Request $request) : void
    {
        event(new BishopVoteValidatedEvent($request));
    }

    public static function voteCount(Request $request) : JsonResponse
    {
        $elected = Card::where('votes', '!=', '0')->orderByDesc('votes')->first()->name;
        Lord::asCard($elected)->getTitle(Title::getCross($request->zone));
        return response()->json([
            'elected'=> $elected
        ]);
    }

    public static function nextBishopElection(Request $request)
    {
        if(!!$request->zone){
            Title::getCross($request->zone)->delete();
        }
        event(new UpdateGameEvent());
    }

    public static function endBishopElection(Request $request)
    {
        Title::withTrashed()->where('game_id', Game::current()->id)->restore();
        Game::current()->update(['current_phase' => 4]);
        event(new UpdateGameEvent());
    }

}
