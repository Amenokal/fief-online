import axios from "axios";
import { Village } from '../classes/Village.js';
import { drawAnimation } from '../animations/cards.js';
import { disasterAnimation } from '../animations/cards.js';


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
    let pile = e.target.parentNode.id.split('CardPile')[0];
    let isDisaster = e.target.className.includes('disaster');

    // DRAW
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

    // SHUFFLE IF EMPTY
    if(e.target.id.includes('shuffle')){
        let deck = e.target.id.split('-')[1];
        axios.post('./shuffle', {
            deck: deck
        })
        .then(res=>{
            document.querySelector(`${deck}-pile-wrapper`).innerHTML =
            `<spanclass="card ${res.data.nextCardType}-verso"/>`
        })
    }
})

// DISASTERS
document.getElementById('disasters-btn').addEventListener('click', showDisasters);
function showDisasters(e){
    axios.get('./disasters/show')
    .then(res=>{
        console.log(res.data);
        for(let i=0; i<res.data.length; i++){
            setTimeout(() => {
                document.getElementById('incDisas-'+i).innerHTML =
                    `<span
                        class="card disaster-recto ${res.data[i].name}"
                        style="background-image: url('${res.data[i].img}')"
                    ></span>`

                if(res.data[i].zone === 6){
                    document.getElementById('incDisas-'+i).innerHTML = "<div class='card-pile inc-disas' id='incDisas-{{$i}}'></div>";
                }

                res.data[i].villages.forEach(el => {
                    let icon;
                    if(res.data[i].name === 'Famine'){
                        icon = '<i class="disas-icon fas fa-water"></i>';
                    }else if(res.data[i].name === 'Mauvais Temps'){
                        icon = '<i class="far fa-snowflake"></i>';
                    }else if(res.data[i].name === 'Peste'){
                        icon = '<i class="fas fa-skull-crossbones"></i>';
                    }

                    document.querySelector(`#${el}>.icons`).innerHTML += icon;
                });
            }, i*1000);
        }
    })
}

// PLAY CARDS
document.querySelectorAll('.player-hand>.card').forEach(el=>{
    el.addEventListener('click', playCard);
});
function playCard(e){
    if(document.querySelector('.to-be-played') && !e.target.className.includes('to-be-played')){
        document.querySelector('.to-be-played').classList.remove('to-be-played')
    }
    e.target.classList.toggle('to-be-played');

    if(document.querySelector('.to-be-played')){
        document.querySelectorAll('.village').forEach(el=>{
            el.addEventListener('click', playCardOnVillage, true)
        })
    }else{
        document.querySelectorAll('.village').forEach(el=>{
            el.removeEventListener('click', playCardOnVillage, true)
        })
    }
}

function playCardOnVillage(e){
    let card = document.querySelector('.to-be-played');
    let cardName = document.querySelector('.to-be-played').id.split('-')[1];
    let village = e.currentTarget.id;
    let hadEffect = false;

    // ADD WEALTH
    if((cardName == 'Bonne Récolte' && !Village.disaster(village, 'Famine') && !Village.disaster(village, 'Mauvais Temps')) ||
        (cardName == 'Beau Temps' && !Village.disaster(village, 'Mauvais Temps') && !Village.disaster(village, 'Famine'))){

            axios.post('./play/add/wealth', {
                card: cardName,
                village: village
            })
            .then(()=>{
                Village.allFromReligiousZone(village).forEach(el=>{
                    Village.addIcon(el.id, cardName)
                });
                card.remove();
            })

    }

    // REMOVE DISASTER
    else if((cardName == 'Bonne Récolte' && Village.disaster(village, 'Famine')) ||
        (cardName == 'Beau Temps' && Village.disaster(village, 'Mauvais Temps')) ){

            let disaster = Village.disaster(village, 'Famine') ? 'Famine' : 'Mauvais Temps';

            axios.post('./play/remove/disaster', {
                card: cardName,
                village: village,
                disaster: disaster
            })
            .then(()=>{
                Village.allFromReligiousZone(village).forEach(el=>{

                    if(Village.disaster(village, 'Famine')){
                        Village.disaster(el.id, 'Famine').remove();
                    }
                    else if(Village.disaster(village, 'Mauvais Temps')){
                        Village.disaster(el.id, 'Mauvais Temps').remove();
                    }
                })
                document.querySelector('.'+disaster).remove();
                card.remove()
            })
    }
    else if(cardName == 'Beau Temps' && !Village.disaster(village, 'Mauvais Temps') &&
    !Village.disaster(village, 'Famine')){
        Village.allFromReligiousZone(village).forEach(el=>{
            Village.addIcon(el.id, cardName)
        })
        hadEffect = true;
    }


    if(hadEffect){
        card.remove();
    }
}
