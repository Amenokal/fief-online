const { default: axios } = require('axios');
const { remove } = require('lodash');

require('./bootstrap');




document.querySelector('.end-turn-btn').addEventListener('click',endTurn);

function endTurn(){
    axios.post('./nextturn')
}

document.querySelector('.game-cards').addEventListener('click', e=>{
    let pileType = e.target.parentNode.parentNode.className.includes('lord') ? 'lord' : 'event';
    sendDrawRequest(cardType, pileType);
})

function sendDrawRequest(pileType){
    axios.post('./draw/'+pileType, {
        discard: incDisasterNb()>2
    })
    .then(res => {
        let drawnCard = res.data[0];
        let nextCard = res.data[1];

        createNextCard(nextCard);

        if(drawnCard.type !== 'disaster'){
            drawAnimation(drawnCard)
        }else if(drawnCard.type === 'disaster'){
            disasterAnimation()
        }
    })
}

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
    card.remove();

    document.querySelector('.player-hand').innerHTML +=
    `<figure class='card in-hand-card'>
        <img src='${drawnCard.img_src}' id='${drawnCard.name}'>
    </figure>`
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

function incDisasterNb(){
    return document.querySelectorAll('.incomming-disaster').length;
}

// DISCARD
document.querySelector('.player-hand').addEventListener('click', e => {
    if(e.target.parentNode.className.includes('card')){
        axios.post('./discard', {
            name: e.target.id.split('-')[1]
        })
        .then(() => {
            e.target.parentNode.remove();
        })
    }
})