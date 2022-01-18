import {drawAll} from './army.js';

const { default: axios } = require('axios');
const { remove } = require('lodash');

require('./bootstrap');

document.onload = drawAll(3);

// document.querySelector('.end-turn-btn').addEventListener('click',endTurn);
// function endTurn(){
//     axios.post('./nextturn')
// }

// document.querySelector('.game-cards').addEventListener('click', e=>{
//     let pileType = e.target.parentNode.parentNode.className.includes('lord') ? 'lord' : 'event';
//     sendDrawRequest(cardType, pileType);
// })




document.getElementById('step1').addEventListener('click', e => {
    axios.post('./gamestart/1')
    .then(res => {
        createNextCard(res);
        drawAnimation(res)
    });
})

function createNextCard(nextCard){
    let pile = document.querySelector(`.${nextCard.type}-pile-wrapper`);
    pile.children[0].style.zIndex = 2;
    pile.innerHTML +=
    `<figure class='card ${nextCard.type}-card'>
        <p>next card</p>
        <span class='overline'></span>
    </figure>`
}

function drawAnimation(drawnCard){
    let card = document.querySelector(`.${drawnCard.type}-card`);
    card.classList.add('draw-animation');

    setTimeout(() => {
        card.remove();
        document.querySelector('.player-hand').innerHTML +=
        `<figure class='card in-hand-card'>
            <img src='${drawnCard.img_src}' id='${drawnCard.name}'>
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


document.getElementById('step2').addEventListener('click', e=>{
    e.target.classList.toggle('choose-village');
})
document.getElementById('step3').addEventListener('click', e=>{
    e.target.classList.toggle('make-army');
})

document.querySelector('.locations').addEventListener('click', e=>{
    if(document.querySelector('.choose-village')){
        axios.post('./gamestart/2', {
            village: e.target.id
        })
        .then(res => {
            document.getElementById(res.data).innerHTML += 
            `<span class=chateau></span>

            <div class='army'>
                <span class='lord'>
                    <canvas height="400px" width="250px" class='lord-banner' id="banner${document.querySelectorAll('.lord-banner').length+1}"></canvas>
                </span>
            </div>
            `;
            drawAll();
        });
    }
    else if(document.querySelector('.make-army')){
        axios.post('./step3', {
            village: e.target.id,
            army: ['sergeant',3,'knight',1]
        })
        .then(res => {
            let color = document.querySelector('.game-view').className.split(' ')[1].split('-')[0];
            e.target.innerHTML += `<span class='token soldier ${color}-bordered'></span>`;
        });
    }
})





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