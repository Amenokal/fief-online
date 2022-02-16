const { default: axios } = require('axios');
const { Game } = require('./classes/Game');
import { firstLordAnimation } from './animations/cards';

require('./bootstrap');

document.onload = Game.update();

window.Echo.channel('starter-phase')
    .listen('.draw-first-lord-event', e=>{
        console.log('channel received = ', e);
        firstLordAnimation(e.cardName, e.player);
    })








// if(document.getElementById('startGameBtn')){
//     document.getElementById('startGameBtn').addEventListener('click', ()=>{
//         axios.post('./gamestart/0')
//             .then(()=>{
//                 Game.update();
//             })
//     })
// }

// if(document.getElementById('lunchGame')){
//     document.getElementById('lunchGame').addEventListener('click', ()=>{
//         Game.update()
//     })
// }
// if(document.getElementById('startSeq')){
//     document.getElementById('startSeq').addEventListener('click', ()=>{
//         axios.post('./gamestart/1')
//         .then((res)=>{
//             console.log(res);
//         })
//     })
// }
// document.querySelectorAll('.village').forEach(el=>{
//     el.addEventListener('click', e=>{
//         if(!e.currentTarget.className.includes('empty')){
//             e.currentTarget.classList.toggle(`show-influence`);
//         }
//     }, true)
// })





