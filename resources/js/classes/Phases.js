import axios from 'axios';
import { Game } from '../classes/Game';

import { playerReady, createGame, drawFirstLord, checkForChooseVillage } from '../phases/00_start';
import { chooseMyMembers, startBishopElection } from '../phases/01_diplomacy';
import { discard, draw, showDisasters, playCard } from '../phases/02_cards';
import { getIncome, prepareBuyPhase, readyToBuy } from '../phases/03_gold';
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

            case 2: initMarriage();
            break;
            case 3: initBishopElection();
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



// PHASE 01 ::::: DIPLOMACY
// ------------------------

    function initMarriage(){
        axios.post('./diplo/marriage/init')
        .then(res=>{
            if(res.data.allowed){
                document.getElementById('marryMyself').classList.add('allowed');
                document.getElementById('marryMyself').addEventListener('click', chooseMyMembers);

                document.getElementById('end-turn').classList.add('allowed');
                document.getElementById('end-turn').addEventListener('click', Game.endTurn);

            }
        })
    }

    function initBishopElection(){
        axios.post('./diplo/bishop/init')
        .then(res=>{
            if(res.data.zone.length === 0){
                console.log("Aucun évêché n'est disponible")
            }
            else {
                startBishopElection(res.data.zone);
            }
        })
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
