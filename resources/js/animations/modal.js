import { Game } from '../classes/Game';
import { chooseMyMembers } from '../phases/01_diplomacy';

export async function showModal(){
    document.getElementById('marryMyself').classList.remove('allowed');
    document.getElementById('marryMyself').removeEventListener('click', chooseMyMembers);
    document.getElementById('end-turn').classList.remove('allowed');
    document.getElementById('end-turn').removeEventListener('click', Game.endTurn);

    let imgTop = new Image();
    imgTop.src = '../fief-online.com/public/storage/images/parchemin-top.png';
    imgTop.onload = ()=>{
        let imgBot = new Image();
        imgBot.src = '../fief-online.com/public/storage/images/parchemin-bottom.png';
        imgBot.onload = ()=>{
            document.querySelector('.modal').classList.add('showpacity');
        }
    }
}

export function closeMarriageModal(){
    document.getElementById('marryMyself').classList.add('allowed');
    document.getElementById('marryMyself').addEventListener('click', chooseMyMembers);
    document.getElementById('end-turn').classList.add('allowed');
    document.getElementById('end-turn').addEventListener('click', Game.endTurn);

    document.querySelector('.modal').style.opacity = "0";
    document.querySelector('.game-view').classList.remove('blurred');
    document.getElementById('marryMyself').addEventListener('click', chooseMyMembers)
    setTimeout(() => {
        document.querySelector('.modal').classList.remove('showpacity');
    }, 300);
    setTimeout(() => {
        document.querySelector('.modal').remove();
    }, 500);
}
