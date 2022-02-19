// \\\
// ------------------------------
// ::::: SHOW PLAYER BOARDS :::::
// ------------------------------
// ///

export async function showBoard(e){
    if(!document.querySelector('.player-board.open')){
        let player = e.target;
        await axios.get('./show/board', {params: {house: player.innerText}})
        .then(res=>{
            document.querySelector('main').innerHTML += res.data;
            document.querySelector('.player-board').classList.add('open');
            player.addEventListener('click', showBoard)
        })
        .then(res=>{
            document.querySelector('.player-board.open').addEventListener('click', closeBoard);
            document.querySelectorAll('.player-name').forEach(el=>{
                el.addEventListener('click', showBoard)
            })
        })
    }
}

export function closeBoard(e){
    let pBoard = document.querySelector('.player-board.open');
    pBoard.classList.remove('open');
    pBoard.classList.add('close');
    setTimeout(() => {
        pBoard.remove();
    }, 1500);
}
