<?php

namespace App\Custom\Entities;

use App\Models\Game;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Events\BannerInfo\NewTurn\NewTurnMessageForSelfEvent;
use App\Events\BannerInfo\NewTurn\NewTurnMessageForOthersEvent;


class BannerInfo {

    // public static function displayBannerInfo(Request $request, $info)
    // {
    //     self::messageForCurrentPlayer($request, $info);
    //     self::messageForOthers($request);
    // }

    public static function messageForCurrentPlayer(Request $request, $info)
    {
        $message = '';
        $phase = Game::current()->current_phase;

        switch($phase){
            case 1 : $message = 'Choisissez votre village de départ';
            break;

            case 2 : $message = 'Proposez une alliance';
            break;

            case 3 : $message = 'Présentez un membre pour un évêché';
            break;

            case 4 : $message = "Présentez un membre pour l'élection du Pape";
            break;

            case 5 : $message = "Présentez un membre pour l'élection du Roi";
            break;

            case 6 : $message = 'Défaussez des cartes';
            break;

            case 7 : $message = 'Piochez des cartes';
            break;

            case 8 : $message = $info ? "Les calamités s'abattent" : "Pas de calamités";
            break;

            case 9 : $message = 'Jouez des cartes';
            break;

            case 10 : $message = 'Percevez vos revenus';
            break;

            case 11 : $message = 'Dépensez vos revenus';
            break;

            case 12 : $message = 'Déplacez vos troupes';
            break;
        }
        event(new NewTurnMessageForSelfEvent($request, $message));
    }

    public static function messageForOthers(Request $request, $info)
    {
        $family = Player::where('turn_order', Game::current()->current_player)->first()->family_name;
        $message = 'La '.$family.' ';
        $phase = Game::current()->current_phase;

        switch($phase){
            case 1 : $message .= 'choisi son village de départ';
            break;

            case 2 : $message .= 'réfléchit à des alliances';
            break;

            case 3 : $message = 'Présentez un membre pour un évêché';
            break;

            case 4 : $message = "Présentez un membre pour l'élection du Pape";
            break;

            case 5 : $message = "Présentez un membre pour l'élection du Roi";
            break;

            case 6 : $message .= 'se défausse de cartes';
            break;

            case 7 : $message .= 'pioche des cartes';
            break;

            case 8 : $message = $info ? "Les calamités s'abattent" : "Pas de calamités";
            break;

            case 9 : $message .= 'joue ses cartes';
            break;

            case 10 : $message .= 'perçoit ses revenus';
            break;

            case 11 : $message .= 'fait ses achats';
            break;

            case 12 : $message .= 'fait ses déplacements';
            break;
        }

        event(new NewTurnMessageForSelfEvent($request, $message));
    }

}
