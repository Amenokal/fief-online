// \\\
// ---------------------
// ANIMATIONS ::::: CARD
// ---------------------
// ///

export function drawAnimation(newCard, nextCardType){
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

export function disasterAnimation(nextCardType){
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
