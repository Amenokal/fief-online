import { chooseMyMembers } from '../phases/01_diplomacy';

export async function showModal(){
    await loadImg1();
    await loadImg2();
    return 'done';
}

function loadImg1(){
    let imgTop = new Image();
    imgTop.src = '../fief-online.com/public/storage/images/parchemin-top.png';
    imgTop.onload = ()=>{
        return true;
    }
}
function loadImg2(){
    let imgBot = new Image();
    imgBot.src = '../fief-online.com/public/storage/images/parchemin-bottom.png';
    imgBot.onload = ()=>{
        return true;
    }
}

export function closeMarriageModal(){
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
