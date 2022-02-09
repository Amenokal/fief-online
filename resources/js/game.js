const { Game } = require('./classes/Game');

require('./bootstrap');

document.onload = Game.getData();
// document.onload = Game.setListeners();

// document.querySelectorAll('.village').forEach(el=>{
//     el.addEventListener('click', e=>{
//         if(!e.currentTarget.className.includes('empty')){
//             e.currentTarget.classList.toggle(`show-influence`);
//         }
//     }, true)
// })

