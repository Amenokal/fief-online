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
                <span class='waiting-user'>${e.username}</span>
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
    .listen('.bishopElection', e=>{
        if(!e.startElection){
            axios.post('./diplo/bishop/next', {
                zone: document.querySelector('.cross-election').className.split(' ')[1].split('-')[1]
            })
        }
        else {

            document.querySelectorAll('.other-lords>div').forEach(el=>{
                if(el.children.length === 0){
                    el.remove();
                }
            })

            document.querySelectorAll('.other-lords>div').forEach(el=>{
                el.classList.add('not-decided');
            })

            if(e.canVote.length>0){

                document.querySelector('.election-container>div').innerHTML += "<section class='vote-container'></section";

                e.canVote.forEach(el=>{
                    if(el === GameElements.localPlayer.color()){
                        document.querySelector('.vote-container').innerHTML +=
                        `<div class='votes'>
                            <span class='full-vote-token ${GameElements.localPlayer.color()}-bordered'></span>
                            <span class='null-vote-token ${GameElements.localPlayer.color()}-bordered'></span>
                        </div>`;


                    }
                    else {
                        document.querySelector('.vote-container').innerHTML +=
                        `<div class='votes'>
                            <span class='hidden-vote-token ${el}-bordered'></span>
                            <span class='hidden-vote-token ${el}-bordered'></span>
                        </div>`;
                    }
                })

                if(e.votes){
                    document.querySelector('.modal-btn').innerText = "Votez...";
                    document.querySelector('.modal-btn').classList.remove('active');

                    document.querySelectorAll('.full-vote-token.'+GameElements.localPlayer.color()+'-bordered, .null-vote-token.'+GameElements.localPlayer.color()+'-bordered').forEach(el=>{
                        el.addEventListener('click', (e)=>{
                            if(document.querySelector('.selected') && !e.target.className.includes('selected')){
                                document.querySelector('.selected').classList.remove('selected');
                                e.target.classList.add('selected');
                            }
                            else if(e.target.className.includes('selected')){
                                e.target.classList.remove('selected');
                            }
                            else {
                                e.target.classList.add('selected');
                            }
                        });
                    });

                    document.querySelectorAll('.other-lords>div').forEach(el=>{

                        el.addEventListener('click', (e)=>{
                            if(e.target.className.includes('modal-card')){

                                if(document.querySelector('.selected') &&
                                    !document.querySelector('.other-lords>.'+e.target.parentNode.className.split(' ')[0]+'>.full-vote-token') &&
                                    !document.querySelector('.other-lords>.'+e.target.parentNode.className.split(' ')[0]+'>.null-vote-token')
                                ){
                                    let token = document.querySelector('.selected');
                                    e.target.parentNode.appendChild(token.cloneNode(true));
                                    token.remove();

                                    document.querySelector('.selected').classList.add('voted');
                                    document.querySelector('.selected').classList.remove('selected');

                                    axios.post('./diplo/bishop/voted', {
                                        lordVotedOn: e.target.className.split(' ')[1].split('-')[0],
                                        zone: document.querySelector('.cross-election').className.split(' ')[1].split('-')[1]
                                    });
                                }
                            }

                        })
                    })
                }
            }
        }
    })
    .listen('.playerVoted', e=>{
        if(e.color !== GameElements.localPlayer.color()){
            document.querySelector(".votes>.hidden-vote-token."+e.color+"-bordered").remove();
            document.querySelector('.'+e.lordVotedOn+'-card').parentNode.innerHTML +=
                "<span class='hidden-vote-token "+e.color+"-bordered'></span>"
            let votes = document.querySelectorAll(".hidden-vote-token."+e.color+"-bordered:not(.votes>.hidden-vote-token)");
            for(let i=0; i<votes.length; i++){
                votes[i].style.top = `-${60 + ((i-1) * 10)}px`;
            }
        }

        if(document.querySelectorAll('.votes>.'+GameElements.localPlayer.color()+'-bordered').length<2){
            document.querySelector('.modal-btn').classList.add('active');
            document.querySelector('.modal-btn').innerText = "Valider";
            document.querySelector('.modal-btn').addEventListener('click', countVotes)
        }
    })
    .listen('.bishopVoteValidated', e=>{
        document.querySelectorAll('.votes>.'+e.color+'-bordered').forEach(el=>{
            el.remove();
        })
    })
    .listen('.elected', e=>{
        document.querySelector('.election-container>div').innerHTML =
            '<span class="'+e.elected+'-card"></span>'
    })

function countVotes(){
    document.querySelector('.modal-btn').classList.remove('active');
    document.querySelector('.modal-btn').innerText = "En attente des autres joueurs...";
    document.querySelector('.modal-btn').removeEventListener('click', countVotes);

    let send = true;
    document.querySelectorAll('.votes').forEach(el=>{
        if(el.children.length > 1){
            console.log(el.children.length)
            send = false;
        }
    })

    if(send){
        axios.post('./diplo/bishop/vote/count', {
            zone: document.querySelector('.cross-election').className.split(' ')[1].split('-')[1]
        })
    }
    else {
        axios.post('./diplo/bishop/vote/validated');
    }
}





window.Echo.channel('special-'+GameElements.localPlayer.order())
    .listen('.marryProposal', e=>{
        displayMarriageProposal(e);
    })
    .listen('.refuseMarriage', e=>{
        document.querySelector('.players').innerHTML+=
            `<span class='message'>
                ${e.message}
            </span>`;
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
            axios.post('./diplo/marriage/accept', {
                askingLord: askingLord,
                askedLord: askedLord
            })
        })
    })
    document.querySelectorAll('.refuseProposal').forEach(el=>{
        el.addEventListener('click', (e)=>{
            e.target.parentNode.remove();
            axios.post('./diplo/marriage/refuse', {
                askingLord: askingLord,
                askedLord: askedLord
            })
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
