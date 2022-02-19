const { default: axios } = require('axios');
const { Game } = require('./classes/Game');
const { GameElements } = require('./classes/GameElements');

require('./bootstrap');



document.onload = Game.update();



window.Echo.channel('lobby')
    .listen('.newUserJoin', e=>{
        console.log('channel received = ', e);
        document.querySelector('.waiting-lobby').innerHTML += `
            <div class='lobby-users'>
                <span>${e.username}</span>
            </div>`
    })
    .listen('.createGame', ()=>{
        Game.update();
    })



window.Echo.channel('game')
    .listen('.shouldUpdate', e=>{
        Game.update();
    })
    .listen('.newMarriage', e=>{
        document.querySelector('.players').innerHTML+=
            `<span class='message'>
                ${upCase(e.askingLord)}, de la ${e.askingFamily} se marie avec ${upCase(e.askedLord)}, de la ${e.askedFamily} !
            </span>`;
    })
    .listen('.newBishopCandidat', e=>{
        console.log(e.event);
        if(e.event === 'add'){
            document.querySelector('.other-lords>.'+e.familyColor+'-bordered').innerHTML +=
                `<span class="modal-card ${e.lord}-card"></span>`
        }
        else if (e.event === 'remove'){
            document.querySelector('.other-lords>.'+e.familyColor+'-bordered').innerHTML = "";
        }
    })
    .listen('.validateChoice', e=>{
        document.querySelector('.other-lords>.'+e.color+'-bordered').classList.remove('not-decided');
    })




window.Echo.channel('special-'+GameElements.localPlayer.order())
    .listen('.marryProposal', e=>{
        displayMarriageProposal(e);
    })

function displayMarriageProposal(data){
    let askingLord = data.askingLord;
    let askingFamily = data.askingFamily;
    let askedLord = data.askedLord;

    document.querySelector('.players').innerHTML+=
        `<span class='message'>
            ${upCase(askingLord)}, de la ${askingFamily} propose de se marrier avec ${upCase(askedLord)} !
            <button class='acceptProposal'>Accepter</button>
            <button class='refuseProposal'>Refuser</button>
        </span>`;

    document.querySelectorAll('.acceptProposal').forEach(el=>{
        el.addEventListener('click', (e)=>{
            e.target.parentNode.remove();
            console.log(askingLord, askedLord)
            axios.post('./diplo/marriage/accept', {
                askingLord: askingLord,
                askedLord: askedLord
            })
        })
    })
    document.querySelectorAll('.refuseProposal').forEach(el=>{
        el.addEventListener('click', (e)=>{
            e.target.parentNode.remove();
        })
    })
}
function upCase(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

// document.querySelectorAll('.village').forEach(el=>{
//     el.addEventListener('click', e=>{
//         if(!e.currentTarget.className.includes('empty')){
//             e.currentTarget.classList.toggle(`show-influence`);
//         }
//     }, true)
// })
