import { drawFirstLord } from '../phases/00_start';
import { chooseStartVillage } from '../phases/00_start';

import { discard } from '../phases/02_cards';
import { draw } from '../phases/02_cards';
import { showDisasters } from '../phases/02_cards';
import { playCard } from '../phases/02_cards';

import { getIncome } from '../phases/03_gold';
import { prepareBuyPhase } from '../phases/03_gold';
import { readyToBuy } from '../phases/03_gold';

import { moveListeners } from '../phases/04_armies';

export class Phases {

    static addListeners(phase){

        let game = document.querySelector('.game-view');
        game.replaceWith(game.cloneNode(true));

        switch(phase){
            case 0: initDrawFirstLord();
            break;
            case 1: initChooseStartLocation();
            break;

            case 6: initDiscard();
            break;

            case 7: initDraw();
            break;

            case 8: initDisasters();
            break;

            case 9: initPlayCards();
            break;

            case 10: initIncome();
            break;

            case 11: initBuy();
            break;

            case 12: initMove();
            break;
        }
    }
}


// PHASE 00 ::::: GAME START
// -------------------------

    function initDrawFirstLord(){
        document.getElementById('step1').addEventListener('click', drawFirstLord)
    }
    function initChooseStartLocation(){
        document.getElementById('step2').addEventListener('click', chooseStartVillage)
    }



// PHASE 02 ::::: CARDS
// --------------------

    // DISCARD
    function initDiscard(){
        document.querySelectorAll('.player-hand>.card').forEach(card=>{
            card.addEventListener('click', discard);
        })
    }

    // DRAW
    function initDraw(){
        document.querySelectorAll('#lordCardPile>span, #eventCardPile>span').forEach(pile=>{
            pile.addEventListener('click', draw);
        })
    }

    // DISASTERS
    function initDisasters(){
        document.getElementById('disasters-btn').addEventListener('click', showDisasters);
    }

    // PLAY
    function initPlayCards(){
        document.querySelectorAll('.player-hand>.card').forEach(el=>{
            el.addEventListener('click', playCard);
        });
    }



// PHASE 03 ::::: GOLD
// -------------------

    // INCOME
    function initIncome(){
        document.getElementById('income-btn').addEventListener('click', getIncome);
    }

    // BUY
    function initBuy(){
        document.querySelectorAll('#buyBtn-moulin, #buyBtn-chateau, #buyBtn-sergeant, #buyBtn-knight, #buyBtn-crown, #buyBtn-cardinal').forEach(el=>{
            el.addEventListener('click', readyToBuy)
        })
    }

// PHASE 04 ::::: MOVEMENTS
// ------------------------

    // MOVE
    function initMove(){
        document.querySelector('.game-view').addEventListener('click', moveListeners);
    }
