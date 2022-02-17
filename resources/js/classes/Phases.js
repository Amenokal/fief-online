import axios from 'axios';
import { playerReady } from '../phases/00_start';
import { createGame } from '../phases/00_start';
import { drawFirstLord } from '../phases/00_start';
import { checkForChooseVillage } from '../phases/00_start';

import { discard } from '../phases/02_cards';
import { draw } from '../phases/02_cards';
import { showDisasters } from '../phases/02_cards';
import { playCard } from '../phases/02_cards';

import { getIncome } from '../phases/03_gold';
import { prepareBuyPhase } from '../phases/03_gold';
import { readyToBuy } from '../phases/03_gold';

import { moveListeners } from '../phases/04_armies';

export class Phases {

    static prepare(phase){

        console.log('current phase : '+phase);
        // let game = document.querySelector('.game-view');
        // game.replaceWith(game.cloneNode(true));

        switch(phase){

            case -1: initPrepareGame();
            break;

            case 0: drawFirstLord();
            break;
            case 1: checkForChooseVillage();
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

            default: break;
        }
    }
}



// PHASE 00 ::::: GAME START
// -------------------------

    function initPrepareGame(){
        if(document.getElementById('userReadyBtn')){
            document.getElementById('userReadyBtn').addEventListener('click', playerReady);
        }

        if(document.getElementById('startGameBtn')){
            document.getElementById('startGameBtn').addEventListener('click', createGame);
        }
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
