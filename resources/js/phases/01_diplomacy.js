import axios from "axios";
import { showModal, closeMarriageModal } from "../animations/modal";
import { showBoard, closeBoard } from "../animations/playerBoard";
import { Game } from "../classes/Game";
import { GameElements } from "../classes/GameElements";

// \\\
// ------------------------
// DIPLOMACY ::::: MARRIAGE
// ------------------------
// ///

export function chooseMyMembers(){
    document.querySelector('.game-view').classList.toggle('blurred');
    axios.get('./show/modal')
    .then(res=>{
        document.querySelector('.game-container').innerHTML += res.data;
        document.getElementById('end-turn').addEventListener('click', Game.endTurn);
    })
    .then(res=>{
        document.querySelector('.modal').classList.add('showpacity');
        document.querySelector('.close-modal-btn').addEventListener('click', closeMarriageModal);
        document.querySelectorAll('.player-name').forEach(el=>{
            if(el.innerText !== GameElements.localPlayer.familyName()){
                el.addEventListener('click', getOtherLords)
            }
        })
    })
}

function getOtherLords(e){
    axios.post('./diplo/marriage/0',{
        'familyName': e.target.innerText
    })
    .then(res=>{
        document.querySelector('.other-player-lords').className = "other-player-lords "+res.data.playerColor+"-bordered";
        document.querySelector('.other-player-lords').innerHTML = "";
        res.data.lords.forEach(el=>{
            document.querySelector('.other-player-lords').innerHTML += '<span class="'+el+'-card"></span>'
        })
    })
    .then(()=>{
        document.querySelectorAll('.player-lords>span').forEach(el=>{
            el.addEventListener('click', e=>{
                if(!e.target.className.includes('selected')){
                    e.target.classList.add('selected');
                    axios.post('./diplo/marriage/1', {
                        lord: document.querySelector('.player-lords>.selected').className.split(' ')[1].split('-')[0],
                        otherFamilyColor: document.querySelector('.other-player-lords').className.split(' ')[1].split('-')[0]
                    })
                    .then(res=>{
                        res.data.lords.forEach(el=>{
                            document.querySelector('.'+el+'-card').classList.add('available');
                            document.querySelector('.'+el+'-card').addEventListener('click',availableLordToSelect);
                        })
                    })

                }
                else {
                    document.querySelectorAll('.selected').forEach(el=>{
                        el.classList.remove('selected');
                    })
                    document.querySelectorAll('.available').forEach(el=>{
                        el.classList.remove('available');
                    })
                    document.querySelectorAll('.other-player-lords>span').forEach(el=>{
                        el.removeEventListener('click', availableLordToSelect);
                    })
                }
            })
        })
    })
}

function availableLordToSelect(e){
    if(!e.target.className.includes('selected') && e.target.className.includes('available')){
        e.target.classList.add('selected');
        document.querySelector('.modal-btn').classList.add('active');
        document.querySelector('.modal-btn').addEventListener('click', sendProposal);
    }
    else {
        e.target.classList.remove('selected');
        document.querySelector('.modal-btn').classList.remove('active');
        document.querySelector('.modal-btn').removeEventListener('click', sendProposal);
    }
}

function sendProposal(e){
    closeMarriageModal();
    document.querySelector('.players').innerHTML+=`<span class='message'>La demande a bien été envoyée.</span>`;
    axios.post('./diplo/marriage/2', {
        'askingLord': document.querySelector('.player-lords>span.selected').className.split('-')[0],
        'askedLord': document.querySelector('.other-player-lords>.selected').className.split('-')[0],
    })
}




// \\\
// -------------------------------
// DIPLOMACY ::::: BISHOP ELECTION
// -------------------------------
// ///

export function startBishopElection(zone){
    document.querySelector('.game-view').classList.toggle('blurred');
    axios.get('./show/modal')
    .then(res=>{
        document.querySelector('.game-container').innerHTML += res.data;
    })
    .then(()=>{
        document.querySelector('.modal').classList.add('showpacity');
        document.querySelector('.modal-btn').classList.add('active')
        document.querySelector('.modal-btn').addEventListener('click', validateBishopChoice)
        document.querySelector('.cross-election').classList.add('cross-'+zone);

        if(document.querySelector('.my-lords>span')){
            document.querySelectorAll('.my-lords>span').forEach(el=>{
                el.addEventListener('click', wantsToBeBishop)
            })

        }
    })
}

function wantsToBeBishop(e){
    e.target.classList.toggle('selected');
    console.log(e.target.className);
    if(e.target.className.includes('selected')){
        document.querySelector('.modal-btn').innerText = "Valider";
        axios.post('./diplo/bishop/candidat', {
            lord: e.target.className.split(' ')[1].split('-')[0],
            event: 'add'
        })
    }
    else{
        document.querySelector('.modal-btn').innerText = "Passer";
        axios.post('./diplo/bishop/candidat', {
            lord: e.target.className.split(' ')[1].split('-')[0],
            event: 'remove'
        })
    }
}

function validateBishopChoice(e){
    document.querySelector('.my-lords').parentNode.remove();
    document.querySelector('.modal-btn').classList.remove('active');
    document.querySelector('.modal-btn').removeEventListener('click', validateBishopChoice);

    document.querySelector('.modal-btn').innerText = "En attente des autres joueurs...";
    axios.post('./diplo/bishop/validate/choice')
    .then(()=>{
        console.log(!document.querySelector('.not-decided'))
        if(!document.querySelector('.not-decided')){
            axios.post('./diplo/bishop/election', {
                zone: document.querySelector('.cross-election').className.split(' ')[1].split('-')[1]
            })
        }
    })

}
