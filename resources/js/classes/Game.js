const { default: axios } = require('axios');
const { Phases } = require('./Phases');


// \\\
// ----------------------------
// ::::: UPDATE GAME-VIEW :::::
// ----------------------------
// ///

export class Game {

    static update(){
        console.log('updating...')
        axios.post('./game/update')
        .then(res=>{
            document.querySelector('.game-container').innerHTML = res.data;
        })
        .then(()=>{
            setListeners();
        })
    }

}

function setListeners(){
    preparePhase();
    addPermanentListeners();
}

function preparePhase(){
    console.log('checking server for current phase...')
    axios.post('./check/phase')
    .then(res=>{
        Phases.prepare(res.data.turn.phase);
    })
}

function addPermanentListeners(){

    console.log('adding permanent listeners...')
    // player-boards
    document.querySelectorAll('.player-name').forEach(el=>{
        el.addEventListener('click', showBoard);
    })

    // turns
    document.getElementById('turn-indicator').addEventListener('click', chooseTurn);

    if(document.getElementById('end-turn')){
        document.getElementById('end-turn').addEventListener('click',endTurn);

        // options
        document.getElementById('fullScreen').addEventListener('click', toggleFullScreen);

        //reset
        document.getElementById('resetAll').addEventListener('click', reset)
    }
}



// \\\
// ------------------------------
// ::::: SHOW PLAYER BOARDS :::::
// ------------------------------
// ///

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
// -------------------------------------------
// TURNS ::::: PHASE SELECTOR & PASS TURNS BTN
// -------------------------------------------
// ///

function chooseTurn(e){
    if(e.target.id.includes('phase') && !e.target.className){
        axios.post('./changeturn', {
            phase: e.target.id.split('-')[1]
        })
        .then(() => {
            Game.update();
        })
    }
}

function endTurn(){
    axios.post('./endturn')
    .then(res => {
        Game.update();
    })
}



// \\\
// --------------------
//  ::::: OPTIONS :::::
// --------------------
// ///

function toggleFullScreen(e){
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
    } else {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      }
    }
}



// \\\
// -------------------
//  ::::: RESETS :::::
// -------------------
// ///

function reset(){
    axios.post('./reset/board')
    .then(()=>{
        axios.post('./reset/deck')
        .then(()=>{
            Game.update();
        })
    })
}
