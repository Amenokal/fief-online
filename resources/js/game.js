const { default: axios } = require('axios');
const { Game } = require('./classes/Game');

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
        console.log('i shall update !')
        Game.update();
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





