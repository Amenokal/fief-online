import axios from "axios";

import { Game } from '../classes/Game.js';
import { Builder } from '../classes/Builder.js';
import { Army } from '../classes/Army.js';

import { firstLordAnimation } from '../animations/cards.js';



// \\\
// ----------------------------
// GAME START ::::: CREATE GAME
// ----------------------------
// ///

export function startGame(){
    axios.post('./gamestart/0')
    .then(()=>{
        Game.update();
    });
}



// \\\
// -----------------------------------
// GAME START ::::: STEP 1 = DRAW LORD
// -----------------------------------
// ///

export function drawFirstLord(){
    console.log('telling server to draw first lord...')
    axios.post('./game/phase')
    .then(res => {
        console.log('server answers : '+res);

        if(!res.data.error){
            firstLordAnimation(res.data.drawnCard);
        }
        else{
            console.log(res.data.error);
        }
    });
};



// \\\
// ----------------------------------------
// GAME START ::::: STEP 2 = CHOOSE VILLAGE
// ----------------------------------------
// ///

export function chooseStartVillage(e){
    document.querySelectorAll('.village.empty').forEach(el=>{
        el.classList.add('to-choose');
        el.addEventListener('click', chooseVillage, true);
    });
};

function chooseVillage(e){
    let village = e.currentTarget;
    let villageName = e.currentTarget.id;
    axios.post('./gamestart/2', {
        village: villageName
    })
    .then(res => {
        if(!res.data.error){
            Builder.newCastle(villageName);
            Army.firstArmyTo(villageName, res.headers.playercolor, res.data);
            village.classList.add(res.headers.playercolor+'-bordered');
            document.querySelectorAll('.village').forEach(el=>{
                el.classList.remove('to-choose');
            })
        }
        else {
            console.log(res.data.error);
        }
    })
};
