import { drawAll } from './army.js';
const { default: axios } = require('axios');
const { remove } = require('lodash');
require('./bootstrap');


// \\\
// -----------------------
// ::::: ONLOAD INIT :::::
// -----------------------
// ///

document.onload = init();

function init(){
    drawAll(3);
}


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

document.querySelector('.locations').addEventListener('click', e=>{
    if(document.querySelector('.choose-village')){
        axios.post('./gamestart/2', {
            village: e.target.id
        })
        .then(res => {
            if(res.data){
                document.getElementById(res.data).innerHTML += 
                `<span class=chateau></span>

                <div class='army'>
                    <span class='lord'>
                        <canvas height="400px" width="250px" class='lord-banner' id="banner${document.querySelectorAll('.lord-banner').length+1}"></canvas>
                    </span>
                </div>
                `;
                drawAll();
            }
        });
    }
    // else if(document.querySelector('.make-army')){
    //     axios.post('./step3', {
    //         village: e.target.id,
    //         army: ['sergeant',3,'knight',1]
    //     })
    //     .then(res => {
    //         let color = document.querySelector('.game-view').className.split(' ')[1].split('-')[0];
    //         e.target.innerHTML += `<span class='token soldier ${color}-bordered'></span>`;
    //     });
    // }
})



// \\\
// --------------------------------
// ANIMATIONS ::::: CARD ANIMATIONS
// --------------------------------
// ///

function createNextCard(data){
    let pile = document.querySelector(`.${data.deck}-pile-wrapper`);
    pile.children[0].id = 'to-draw';
    pile.children[0].style.zIndex = 2;

    let type;
    if(data.deck === 'lord'){
        type = 'lord'
    }else if(data.deck === 'event'){
        type = data.nextType ? 'disaster' : 'event'
    }
    pile.innerHTML +=
    `<figure class='card ${type}-card'>
        <span class='overline'></span>
    </figure>`
}

function drawAnimation(data){
    let card = document.getElementById('to-draw');
    card.classList.add('draw-animation');

    let anim = setTimeout(() => {
        card.remove();
        document.querySelector('.player-hand').innerHTML +=
        `<figure class='card'>
            <img src='${data.img_src}' id='${data.name}'>
        </figure>`
    }, 1000);

}

function disasterAnimation(){
    let card = document.querySelector('.disaster-card');
    card.remove();

    let pile;
    if(incDisasterNb()<3){
        pile = document.querySelectorAll('.incomming-disaster-card-wrapper')[incDisasterNb()];
    } else {
        pile = document.querySelector('.event-discard-pile-wrapper');
    }
    pile.innerHTML +=
    `<figure class='card incomming-disaster'>
        <span class='overline'></span>
    </figure>`

}
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



// \\\
// ------------------------
// CARDS ::::: DRAW & RESET
// ------------------------
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
// ------------------------
// CARDS ::::: DRAW & RESET
// ------------------------
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
        .then(res => {
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