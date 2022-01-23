import axios from "axios";
import { drawAnimation } from '../animations/cards.js';


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



