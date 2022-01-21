// import { draw } from './army.js';
import { createNextCard } from './animations/cards.js';
import { drawAnimation } from './animations/cards.js';

const { default: axios } = require('axios');
const { remove } = require('lodash');
require('./bootstrap');
require('./animations/cards')
require('./animations/armies')


// \\\
// -----------------------
// ::::: ONLOAD INIT :::::
// -----------------------
// ///

document.onload = init();

function init(){
    document.querySelector('.locations').addEventListener('click', e=>{
        chooseVillage(e);
        moveArmy(e);
    })
}

// fun for later
// function addBtnFx(e){
//     console.log(e.target);
//     let btns = document.querySelectorAll('button');

//     btns.forEach(el=>{
//         el.addEventListener('click', e=>{
//             let fx = new Audio('./storage/fx/click.mp3');
//             console.log(fx);
//             fx.play();
//         })
//     })
// }

// \\\
// -----------------------------------
// GAME START ::::: STEP 1 = DRAW LORD
// -----------------------------------
// ///


document.getElementById('step1').addEventListener('click', e => {
    axios.post('./gamestart/1')
    .then(res => {
        if(res.data){
            createNextCard(res.data);
            drawAnimation(res.data)
        }
    });
})


// \\\
// ----------------------------------------
// GAME START ::::: STEP 2 = CHOOSE VILLAGE
// ----------------------------------------
// ///



document.getElementById('step2').addEventListener('click', e=>{
    e.target.classList.toggle('choose-village');
})

function chooseVillage(e){
    if(document.querySelector('.choose-village') &&
        (e.target.className === 'city' || e.target.className === 'village')){
        axios.post('./gamestart/2', {
            village: e.target.id
        })
        .then(res => {
            if(res.data){

                e.target.innerHTML += 
                `<span class=chateau></span>
    
                <div class='army'>
                    <span id='${res.data.name}' class='lord'></span>
                </div>`;
                document.getElementById('step2').classList.remove('choose-village');


                // BANNERS :: add later
                // let bannerCount = document.querySelectorAll('.lord-banner').length+1;
                // <canvas height="400px" width="250px" class='banner' id="banner${bannerCount}"></canvas>
                // let target = document.getElementById(`banner${bannerCount}`);
                // draw(target, res.data.power);
            }
        });
    }
}


// \\\
// --------------------------
// CARDS ::::: DRAW & DISCARD
// --------------------------
// ///



// document.querySelector('.game-cards').addEventListener('click', e=>{
//     let pileType = e.target.parentNode.parentNode.className.includes('lord') ? 'lord' : 'event';
//     sendDrawRequest(cardType, pileType);
// })

// DISCARD
// document.querySelector('.player-hand').addEventListener('click', e => {
//     if(e.target.parentNode.className.includes('card')){
//         axios.post('./discard', {
//             name: e.target.id.split('-')[1]
//         })
//         .then(() => {
//             e.target.parentNode.remove();
//         })
//     }
// })


// \\\
// ---------------------
// BUILDINGS ::::: BUILD
// ---------------------
// ///


// CASTLES !!!

// var draw = false;
// document.getElementById('make-off').onclick = ()=>{draw = false};
// document.getElementById('make-moulin').onclick = ()=>{draw = 'moulin'};
// document.getElementById('make-chateau').onclick = ()=>{draw = 'chateau'};
// document.getElementById('make-cite').onclick = ()=>{draw = 'cite'};

// document.querySelector('.locations').addEventListener('click',e=>{

//     if(document.getElementById('charles')){
//         document.getElementById('charles').remove();
//     }
//     e.target.innerHTML += `<span class='lord' id='charles'></span>`;

//     if((e.target.className.includes('village') || e.target.className.includes('city') ||
//         e.target.parentNode.className.includes('village') || e.target.parentNode.className.includes('city'))
//         && draw ){
//         e.target.innerHTML += `<span class='${draw}'></span>`;

//     }
//     if((draw == 'moulin' && e.target.className.includes('moulin')) ||
//         (draw == 'chateau' && e.target.className.includes('chateau')) ||
//         (draw == 'cite' && e.target.className.includes('cite'))){
//         e.target.remove();
//     }
// })



// \\\
// -------------------------------------------
// TURNS ::::: PASS TURNS BTN & PHASE SELECTOR
// -------------------------------------------
// ///



document.getElementById('turn-indicator').addEventListener('click', e=>{
    if(e.target.id.includes('phase') && !e.target.className){
        axios.post('./changeturn', {
            phase: e.target.id.split('-')[1]
        })
        .then(() => {
            let oldPhase = document.querySelector('.current-phase');
            e.target.className = oldPhase.className;
            oldPhase.className = "";
        })
    }
})

document.getElementById('end-turn').addEventListener('click',endTurn);
function endTurn(){
    axios.post('./endturn')
    .then(res => {
        let firstPhase = document.getElementById('turn-indicator').children[0];
        let currentPhase = document.querySelector('.current-phase');
        let nextPhase = document.querySelector('.current-phase').nextElementSibling;
        let color = res.data.color;

        if(res.data.player){
            currentPhase.className = `current-phase ${color}-bordered`;
        }else if(res.data.phase){
            nextPhase.className = `current-phase ${color}-bordered`;
            currentPhase.className = "";
        }else if(res.data.turn){
            firstPhase.className = `current-phase ${color}-bordered`;
            currentPhase.className = "";
        }
    })
}



// \\\
// ------------------------
// ARMIES ::::: SHOW FORCES
// ------------------------
// ///



document.querySelector('.locations').addEventListener('click',e=>{
    if(e.target.className.includes('lord') && !document.querySelector('.move-active')){
        showArmy(e);
    }
})

function showArmy(e){
    
    axios.post('./show/army', {
        lord: e.target.id,
        village: e.target.parentNode.parentNode.id
    })
    .then(res=>{
        console.log(res);
        // let modal = document.getElementById('info-modal');
        // modal.classList.add('show');
        // modal.classList.add(res.data.color+'-bordered');

        // modal.addEventListener('click', ()=>{modal.classList.remove('show')})
    })
}


// \\\
// ----------------------
// ARMIES ::::: MOUVEMENT
// ----------------------
// ///



document.getElementById('moveBtn').addEventListener('click', e=>{
    e.target.classList.toggle('move-active');
})
function moveArmy(e){

        // FROM
    // if((e.target.parentNode.className.includes('army') || e.target.className.includes('army'))
    //     && document.querySelector('.move-active')){
        
    //     if(!document.querySelector('.from') &&
    //     (e.target.parentNode.parentNode.className.includes('city') ||
    //         e.target.parentNode.parentNode.className.includes('village'))){
    //             e.target.parentNode.parentNode.classList.add('from');
    //     }
    // }

    //     // TO
    // else if(document.querySelector('.from')){
    //     if(e.target.className.includes('city') || e.target.className.includes('village')){
    //         e.target.classList.add('to');
    //     }
    //     else if(e.target.parentNode.className.includes('city') || e.target.parentNode.className.includes('village')){
    //         e.target.parentNode.classList.add('to');
    //     }

    //     if(document.querySelector('.move-active')){
    //         document.querySelector('.move-active').classList.remove('move-active');
    //     }
    // }

    // if(document.querySelector('.from') && document.querySelector('.to')){
    //     axios.post('./move/army', {
    //         from: document.querySelector('.from').id,
    //         to: document.querySelector('.to').id,
    //     })
    //     .then(res=>{
    //         console.log(res)
    //     })
    // }

}








// \\\
// -------------------
//  ::::: RESETS :::::
// -------------------
// ///



document.getElementById('resetDeck').addEventListener('click', e=>{
    axios.post('./reset/deck')
    .then(()=>{
        for(let card of document.querySelector('.player-hand').children){
            if(card){
                card.remove()
            }
        }
    })
})

document.getElementById('resetBoard').addEventListener('click', e=>{
    axios.post('./reset/board')
    .then(res=>{
        let castles = document.querySelectorAll('.chateau');
        let lords = document.querySelectorAll('.lord');
        let banners = document.querySelectorAll('.banner');
        if(castles){
            for(let c of castles){
                c.remove()
            }
        }
        if(lords){
            for(let l of lords){
                l.remove()
            }  
        }
        if(banners){
            for(let b of banners){
                b.remove()
            }  
        }
    })
})
