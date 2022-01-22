import axios from "axios";


// \\\
// --------------------
// PHASES ::::: CARDS
// --------------------
// ///


// DISCARD
document.querySelector('.player-hand').addEventListener('click', e=>{
    let phase = document.querySelector('.current-phase').id.split('-')[1];

    if(e.target.className.includes('card') && phase === '5'){
        let card = e.target;

        axios.post('./discard', {
            deck: card.id.split('-')[0],
            card: card.id.split('-')[1]
        })
        .then(()=>{
            if(phase === '5'){
                card.classList.add('discarded');
                setTimeout(() => {card.remove()}, 1000);
            }
        });
    }
})

// DRAW
document.querySelector('.game-cards').addEventListener('click', e=>{
    let phase = document.querySelector('.current-phase').id.split('-')[1];
    let pile = e.target.parentNode.id.split('-')[0];
    let isDisaster = e.target.className.split(' ')[1].split('-')[0] === 'disaster';

    if( (pile == 'lord' || pile == 'event') && phase === '6' && e.target.className.includes('card')){
        axios.post('./draw/card', {
            deck: pile,
            isDisaster: isDisaster
        })
        .then(res=>{
            if(!isDisaster){
                drawAnimation(res.data.drawnCard, res.data.nextCardType)
            }
            else{
                disasterAnimation(res.data.nextCardType)
            }
        });
    }
})

// RESHUFFLE IF EMPTY
document.querySelector('.game-cards').addEventListener('click', e=>{

    if(e.target.id.includes('shuffle')){
        let deck = e.target.id.split('-')[1];
        axios.post('./shuffle', {
            deck: deck
        })
        .then(res=>{
            document.querySelector(`${deck}-pile-wrapper`).innerHTML =
            `<x-card-verso class="card ${res.data.nextCardType}-card"/>`
        })
    }

})
// \\\
// ---------------------
// ANIMATIONS ::::: CARD
// ---------------------
// ///

function drawAnimation(newCard, nextCardType){
    let pile = document.querySelector(`.${newCard.deck}-pile-wrapper`);
    pile.children[0].id = 'to-draw';
    pile.children[0].style.zIndex = 2;
    
    pile.innerHTML += `<x-card-verso class="card ${nextCardType}-card"/>`

    let card = document.getElementById('to-draw');
    card.classList.add('draw-animation');
    setTimeout(() => {
        card.remove();
        document.querySelector('.player-hand').innerHTML +=
        `<x-card-recto
            class="card"
            id="${newCard.deck}-${newCard.name}"
            style="background-image: url(${newCard.img_src})"
        />`
    }, 1000);
}

function disasterAnimation(nextCardType){
    let pile = document.querySelector('.event-pile-wrapper');
    pile.children[0].id = 'to-inc-pile';
    pile.innerHTML += `<x-card-verso class="card ${nextCardType}-card"/>`;
    
    let card = document.getElementById('to-inc-pile');
    let alreadyInc = document.querySelectorAll('.incomming-disaster-card-wrapper>.disaster-card').length;
    card.classList.add(`disas-animation-${alreadyInc}`);

    console.log(card);
    console.log(alreadyInc);

    let timeout = 1000 + (alreadyInc*500);
    setTimeout(() => {
        card.remove();
        let incDisasPiles = document.querySelectorAll('.incomming-disaster-card-wrapper');
        let eventDiscardPile = document.querySelector('.event-discard-pile-wrapper');
        let incPile = alreadyInc < 3 ? incDisasPiles[alreadyInc] : eventDiscardPile;
        incPile.innerHTML += `<x-card-recto class="card disaster-card" />`
    }, timeout);
    
}