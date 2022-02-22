import axios from "axios";

import { Game } from '../classes/Game.js';
import { Village } from '../classes/Village.js';

import { drawAnimation } from '../animations/cards.js';
import { disasterAnimation } from '../animations/cards.js';
import { initDraw } from "../classes/Phases.js";



// \\\
// -------------------
// CARDS ::::: DISCARD
// -------------------
// ///

export function discard(e){
    let card = e.target;
    let cardName = e.target.className.split(' ')[1].split('-')[0];

    axios.post('./cards/discard', {
        cardName: cardName
    })
    .then(()=>{
        card.classList.add('discarded');
        setTimeout(() => {
            card.remove();
        }, 1000);
    })
}



// \\\
// ----------------
// CARDS ::::: DRAW
// ----------------
// ///

export function draw(e){
    let deck = e.target.parentNode.id.includes('lord') ? 'lord' : 'event';

    // DRAW
    if((deck == 'lord' || deck == 'event') && e.target.className.includes('card')){
        axios.post('./cards/draw', {
            deck: deck,
        })
        .then(res=>{
            if(!res.data.wasDisaster){
                drawAnimation(res.data.drawnCard, res.data.nextCardType);
            }
            else{
                disasterAnimation(res.data.nextCardType);
            }
        })
    }

    initDraw();

    // SHUFFLE IF EMPTY
    // if(e.target.id.includes('shuffle')){
    //     let deck = e.target.id.split('-')[1];
    //     axios.post('./shuffle', {
    //         deck: deck
    //     })
    //     .then(res=>{
    //         document.querySelector(`${deck}-pile-wrapper`).innerHTML =
    //         `<span class="card ${res.data.nextCardType}-verso"/>`
    //     })
    // }

}



// \\\
// --------------------
// CARDS ::::: DISASTER
// --------------------
// ///

export function showDisasters(){
    axios.get('./disasters/show')
    .then(res=>{
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



// \\\
// ----------------
// CARDS ::::: PLAY
// ----------------
// ///

export function playCard(e){


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

    // PLAY LORD
    if(card.id.includes('lord') && (!card.id.includes('Cardinal') || !card.id.includes('arc'))){

        axios.post('./play/lord', {
            lord: cardName,
            village: village
        })
        .then(()=>{
            Game.update();
        })
    }

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
