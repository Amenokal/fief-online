import { GameElements } from '../classes/GameElements';
import { Game } from '../classes/Game.js';


// \\\
// ---------------------
// ANIMATIONS ::::: CARD
// ---------------------
// ///

export function firstLordAnimation(newCard){
    let pile = document.getElementById('lordCardPile');
    pile.innerHTML += '<span class="card lord-verso"></span>';
    console.log(pile);

    let card = pile.children[0];
    card.classList.add('draw-first-lord');
    console.log(card);

    setTimeout(() => {

        card.addEventListener('click',()=>{
            card.classList.add('clicked', 'reveal-1');

            setTimeout(() => {

                card.classList.remove('reveal-1');
                card.classList.add('reveal-2');
                card.id = newCard.name;
                card.style = `background-image: url(${newCard.img_src})`;

                setTimeout(() => {
                    card.classList.remove('reveal-2');
                    card.classList.add('take-first-lord');
                }, 1500);

                setTimeout(() => {
                    document.querySelector('.player-hand').innerHTML +=
                        GameElements.lordCardRecto(newCard.name, newCard.img_src);

                    document.querySelector('.player-hand>.card').classList.add('drawn');

                    card.remove();
                }, 2000);

            }, 500);
        })

    }, 1000);
}

export function drawAnimation(newCard, nextCardType){

    let pile = document.getElementById(`${newCard.deck}CardPile`);
    pile.children[0].id = 'to-draw';
    pile.children[0].style.zIndex = 2;

    pile.innerHTML += `<span class="card ${nextCardType}-verso"></span>`

    let card = document.getElementById('to-draw');
    card.classList.add('draw-animation');
    setTimeout(() => {
        card.remove();
        document.querySelector('.player-hand').innerHTML +=
        `<span
            class="card"
            id="${newCard.deck}-${newCard.name}"
            style="background-image: url(${newCard.img_src})"
        ></span>`
    }, 1000);
}

export function disasterAnimation(nextCardType){
    let pile = document.getElementById('eventCardPile');
    pile.children[0].id = 'to-inc-pile';
    pile.innerHTML += `<span class="card ${nextCardType}-verso"></span>`;

    let card = document.getElementById('to-inc-pile');
    let alreadyInc = document.querySelectorAll('.inc-disas>.card').length < 3 ? document.querySelectorAll('.inc-disas>.card').length : 'discard';
    card.classList.add(`disas-animation-${alreadyInc}`);

    let timeout = 1000 + (alreadyInc*500);
    setTimeout(() => {
        card.remove();
        let incDisasPiles = document.querySelectorAll('.inc-disas');
        let eventDiscardPile = document.getElementById('eventDiscardPile');
        let incPile = alreadyInc < 3 ? incDisasPiles[alreadyInc] : eventDiscardPile;
        incPile.innerHTML += '<span class="card disaster-verso" ></span>'
    }, timeout);

}
