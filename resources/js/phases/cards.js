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
    console.log(isDisaster);

    if( (pile == 'lord' || pile == 'event') && phase === '6'){
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
    document.querySelector('.event-pile-wrapper').innerHTML +=
    `<x-card-verso class="card ${nextCardType}-card"/>`
    
    let card = document.querySelector('.disaster-card');
    card.classList.add(`disas-animation-${alreadyInc}`);
    setTimeout(() => {
        card.remove();
    }, 1000);
    
    let incDisasPiles = document.querySelectorAll('.incomming-disaster-card-wrapper');
    let eventDiscardPile = document.querySelector('.event-discard-pile-wrapper');
    let alreadyInc = document.querySelectorAll('.incomming-disaster-card-wrapper>.disaster-card').length;
    let pile = alreadyInc < 3 ? incDisasPiles[alreadyInc] : eventDiscardPile;
    pile.innerHTML += `<x-card-recto class="card disaster-card" />`
}