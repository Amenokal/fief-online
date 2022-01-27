// \\\
// ---------------------
// ANIMATIONS ::::: CARD
// ---------------------
// ///

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
