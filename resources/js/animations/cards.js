
// \\\
// --------------------------------
// ANIMATIONS ::::: CARD ANIMATIONS
// --------------------------------
// ///

export function createNextCard(data){
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

export function drawAnimation(data){
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