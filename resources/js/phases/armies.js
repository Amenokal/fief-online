const { default: axios } = require("axios");
import { draw } from '../banner.js';

document.getElementById('moveBtn').addEventListener('click', e=>{
    e.target.classList.toggle('move-active')
})
document.querySelector('.game-view').addEventListener('click',e=>{
    let phase = document.querySelector('.current-phase');

    // ONCLICK BANNER >>> SHOW FORCES
    if(e.target.className.includes('banner')){
        e.target.nextElementSibling.classList.toggle('show');
        console.log(e.target.previousElementSibling);
    }


    // ONCLICK LORD >>> MOVE PHASE
    if(e.target.className.includes('lord') && phase.id === 'phase-11' && document.querySelector('.move-active')){

        // OPEN MOVE OPTIONS ONLY IN MOVEMENT PHASE
        e.target.classList.add('moving');
        e.target.parentNode.nextElementSibling.classList.add('show');

    }

    // CLOSE MOVE OPTIONS
    if(document.querySelector('.move-options.show') && e.target.id === 'move-option-close'){
        document.querySelector('.move-options.show').classList.remove('show');
        document.querySelector('.moving').classList.remove('moving');

        if(document.querySelector('.active')){
            document.querySelector('.active').classList.remove('active');
        }
    }

            // ::::: OPTION SELECT :::::
            // -------------------------

    // ACTIVE OPTION #1 >>> MOVE ALL
    if(document.querySelector('.move-options.show') && e.target.id === 'move-option-move-all'){
        e.target.classList.toggle('active');
    }
    // ACTIVE OPTION #2 >>> MOVE ALL BUT 1 
    if(document.querySelector('.move-options.show') && e.target.id === 'move-option-let-one'){
        e.target.classList.toggle('active');
    }


            // ::::: OPTION REQUESTS :::::
            // ---------------------------

    // MOVE ALL // 1 BEHIND
    if(document.querySelector('.move-options.show') &&
    (e.target.className.includes('village') || e.target.parentNode.className.includes('village') )){
        
        let moveAll = document.getElementById('move-option-move-all').className.includes('active');
        let letOne = document.getElementById('move-option-let-one').className.includes('active');


        if(e.target.className.includes('village')){
            e.target.classList.add('to');
        }else if(e.target.parentNode.className.includes('village')){
            e.target.parentNode.classList.add('to');
        }

        console.log(document.querySelector('.to').id);

        let path;
        if(moveAll){
            path = './move/all';
        }else if(letOne){
            path = './move/let/one';
        }

        if(document.querySelector('.moving') && document.querySelector('.to'))
        {
            axios.post(path, {
                lord: document.querySelector('.moving').id,
                village: document.querySelector('.to').id
            })
            .then(res=>{
                document.querySelector('.moving').parentNode.parentNode.remove();
                document.querySelector('.to').innerHTML += res.data;
                draw(document.querySelector('.to').lastElementChild.children[2])
            })
            .then(()=>{
                if(document.querySelector('.move-options.show')){
                    document.querySelector('.move-options.show').classList.remove('show');
                }
                if(document.querySelector('.active')){
                    document.querySelector('.active').classList.remove('active');
                }
                if(document.querySelector('.move-active')){
                    document.querySelector('.move-active').classList.remove('move-active');
                }
                if(document.querySelector('.to')){
                    document.querySelector('.to').classList.remove('to');
                }
            })
        }
        else {
            if(document.querySelector('.move-options.show')){
                document.querySelector('.move-options.show').classList.remove('show');
            }
            if(document.querySelector('.active')){
                document.querySelector('.active').classList.remove('active');
            }
            if(document.querySelector('.move-active')){
                document.querySelector('.move-active').classList.remove('move-active');
            }
            if(document.querySelector('.to')){
                document.querySelector('.to').classList.remove('to');
            } 
        }



    }



})

