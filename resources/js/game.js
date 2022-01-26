const { default: axios } = require('axios');

require('./bootstrap');
require('./phases/00_start');
require('./phases/02_cards');
require('./phases/03_gold');
require('./phases/04_armies');



// \\\
// ------------------------------
// ::::: SHOW PLAYER BOARDS :::::
// ------------------------------
// ///

document.querySelectorAll('.player-name').forEach(el=>{
    el.addEventListener('click', showBoard);
})

function showBoard(e){
    if(!document.querySelector('.player-board.open')){
        let player = e.target;
        axios.get('./show/board', {params: {house: player.innerText}})
        .then(res=>{
            document.querySelector('main').innerHTML += res.data;
            document.querySelector('.player-board').classList.add('open');
            player.addEventListener('click', showBoard)
        })
        .then(res=>{
            document.querySelector('.player-board.open').addEventListener('click', closeBoard);
            document.querySelectorAll('.player-name').forEach(el=>{
                el.addEventListener('click', showBoard);
            })
        })
    }
}

function closeBoard(e){
    let pBoard = document.querySelector('.player-board.open');
    pBoard.classList.remove('open');
    pBoard.classList.add('close');
    setTimeout(() => {
        pBoard.remove();
    }, 1500);
}


// \\\
// ---------------------
// BUILDINGS ::::: BUILD
// ---------------------
// ///


// CASTLES !!!

// var draw = false;
// document.getElementById('make-off').onclick = ()=>{draw = false};
// document.getElementById('make-moulin').onclick = ()=>{draw = 'moulin'};
// document.getElementById('make-chateau').onclick = ()=>{draw = 'chateau'};
// document.getElementById('make-cite').onclick = ()=>{draw = 'cite'};

// document.querySelector('.locations').addEventListener('click',e=>{

//     if(document.getElementById('charles')){
//         document.getElementById('charles').remove();
//     }
//     e.target.innerHTML += `<span class='lord' id='charles'></span>`;

//     if((e.target.className.includes('village') || e.target.className.includes('city') ||
//         e.target.parentNode.className.includes('village') || e.target.parentNode.className.includes('city'))
//         && draw ){
//         e.target.innerHTML += `<span class='${draw}'></span>`;

//     }
//     if((draw == 'moulin' && e.target.className.includes('moulin')) ||
//         (draw == 'chateau' && e.target.className.includes('chateau')) ||
//         (draw == 'cite' && e.target.className.includes('cite'))){
//         e.target.remove();
//     }
// })



// \\\
// -------------------------------------------
// TURNS ::::: PASS TURNS BTN & PHASE SELECTOR
// -------------------------------------------
// ///

document.getElementById('turn-indicator').addEventListener('click', e=>{
    if(e.target.id.includes('phase') && !e.target.className){
        axios.post('./changeturn', {
            phase: e.target.id.split('-')[1]
        })
        .then(() => {
            let oldPhase = document.querySelector('.current-phase');
            e.target.className = oldPhase.className;
            oldPhase.className = "";
        })
    }
})

document.getElementById('end-turn').addEventListener('click',endTurn);
function endTurn(){
    axios.post('./endturn')
    .then(res => {
        let firstPhase = document.getElementById('turn-indicator').children[0];
        let currentPhase = document.querySelector('.current-phase');
        let nextPhase = document.querySelector('.current-phase').nextElementSibling;
        let color = res.data.color;

        if(res.data.player){
            currentPhase.className = `current-phase ${color}-bordered`;
        }else if(res.data.phase){
            nextPhase.className = `current-phase ${color}-bordered`;
            currentPhase.className = "";
        }else if(res.data.turn){
            firstPhase.className = `current-phase ${color}-bordered`;
            currentPhase.className = "";
        }
    })
}



// \\\
// -------------------
//  ::::: RESETS :::::
// -------------------
// ///

document.getElementById('resetDeck').addEventListener('click', e=>{
    axios.post('./reset/deck')
    .then(()=>{
        for(let i=0; i<document.querySelector('.player-hand').children.length; i++){
            document.querySelector('.player-hand').children[i].remove();
        }
    })
})

document.getElementById('resetBoard').addEventListener('click', e=>{
    axios.post('./reset/board')
    .then(res=>{
        let castles = document.querySelectorAll('.chateau');
        let lords = document.querySelectorAll('.lord');
        let banners = document.querySelectorAll('.banner');
        if(castles){
            for(let c of castles){
                c.remove()
            }
        }
        if(lords){
            for(let l of lords){
                l.remove()
            }
        }
        if(banners){
            for(let b of banners){
                b.remove()
            }
        }
    })
})
