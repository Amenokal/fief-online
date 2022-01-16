<?php 

namespace App\Custom\Classes;

use App\Models\Games;
use App\Models\Players;
use Illuminate\Http\Request;


class TurnsHandler {

    public function init()
    {
        $turn = [
            'player_index' => 1,
            'phase_index' => 1,
            'turn_index' => 1
        ];

        Games::first()->update(['turn' => json_encode($turn)]);
    }

    public function nextPhase()
    {
        $py_i = json_decode(Games::first()->turn, true)['player_index'];
        $ph_i = json_decode(Games::first()->turn, true)['phase_index'];
        $t_i = json_decode(Games::first()->turn, true)['turn_index'];
        
        $pCount = Players::all()->count();

        if($py_i < $pCount){
            $py_i++;
        }else if($py_i >= $pCount && $ph_i < 14){
            $py_i = 0;
            $ph_i++;
        }else{
            $py_i = 0;
            $ph_i = 0;
            $t_i++;
        }
        
        $turn = json_encode([
            'player_index' => $py_i,
            'phase_index' => $ph_i,
            'turn_index' => $t_i
        ]);
        Games::first()->update(['turn' => $turn]);
                    
        $message = $this->phaseMessage($ph_i);
        $nextPlayer = Players::skip($py_i)->take(1)->get()[0]->username;

        return response()->json([
            'phase' => $message,
            'nextPlayer' => $nextPlayer
        ]);

    }

    public function phaseMessage(int $phase)
    {   
        switch($phase)
        {
            case 1 :
                return 'Mariages';
                break;
            case 2 :
                return 'Élection des Évêques';
                break;
            case 3 :
                return 'Élection du Pape';
                break;
            case 4 :
                return 'Élection du Roi';
                break;
            case 5 :
                return 'Défausse de cartes';
                break;
            case 6 :
                return 'Pioche de cartes';
                break;
            case 7 :
                return 'Calamités';
                break;
            case 8 :
                return 'Pose de cartes';
                break;
            case 9 :
                return 'Revenus';
                break;
            case 10 :
                return 'Dépenses';
                break;
            case 11 :
                return 'Mouvements';
                break;
            case 12 :
                return 'Batailles';
                break;
            case 13 :
                return 'Pillage';
                break;
            case 14 :
                return 'Fin du tour';
                break;
        }
    }
};
