import axios from "axios";

import { Game } from '../classes/Game.js';
import { Builder } from '../classes/Builder.js';
import { Army } from '../classes/Army.js';
import { firstLordAnimation } from "../animations/cards.js";


// \\\
// ----------------------------
// GAME START ::::: CREATE GAME
// ----------------------------
// ///

export function playerReady(){
    axios.post('./player/ready')
    .then(()=>{
        Game.update();
    });
}

export function createGame(){
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
    axios.post('./gamestart/1')
    .then(res => {
        let cards = res.data.cards;
        let amount = cards[0].length
        for(let i=0; i<amount; i++){
            setTimeout(() => {
                if(cards[2][i]){
                    firstLordAnimation(cards[0][i]);
                }
                else {
                    firstLordAnimation(cards[0][i], cards[1][i]);
                }

                if(i==amount-1){
                    setTimeout(() => {
                        axios.post('./gamestart/2')
                        .then(res=>{
                            if(res.data.allowed){
                                setStartVillageListeners();
                            }
                        })
                    }, 5000);
                }
            }, i*5000);
        }
    })
};



// \\\
// ----------------------------------------
// GAME START ::::: STEP 2 = CHOOSE VILLAGE
// ----------------------------------------
// ///

export function checkForChooseVillage(){
    axios.post('./gamestart/2')
    .then(res=>{
        if(res.data.allowed){
            setStartVillageListeners();
        }
    })
}

function setStartVillageListeners(){
    document.querySelectorAll('.village.empty').forEach(el=>{
        el.classList.add('to-choose');
        el.addEventListener('click', chooseVillage, true);
    });
};

function chooseVillage(e){
    // let village = e.currentTarget;
    let villageName = e.currentTarget.id;
    axios.post('./gamestart/3', {
        village: villageName
    })
    // .then(res => {
    //     if(!res.data.error){
    //         Builder.newCastle(villageName);
    //         Army.firstArmyTo(villageName, res.headers.playercolor, res.data);
    //         village.classList.add(res.headers.playercolor+'-bordered');
    //         document.querySelectorAll('.village').forEach(el=>{
    //             el.classList.remove('to-choose');
    //         })
    //     }
    //     else {
    //         console.log(res.data.error);
    //     }
    // })
};
