const { default: axios } = require("axios");

document.querySelector('.game-view').addEventListener('click',e=>{

    // ONCLICK LORD
    if(e.target.className.includes('lord')){
        let phase = document.querySelector('.current-phase');

        e.target.classList.add('moving');
        
        // OPEN MOVE OPTIONS ONLY IN MOVEMENT PHASE
        if(phase.id === 'phase-11' && document.querySelector('.move-active')){
            e.target.parentNode.nextElementSibling.nextElementSibling.classList.add('show');
        }
        // SHOW ARMY FORCES OTHERWISE
        else{
            e.target.parentNode.nextElementSibling.classList.toggle('show');
        }

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

    // ACTIVE MOVE ALL OPTION
    if(document.querySelector('.move-options.show') && e.target.id === 'move-option-move-all'){
        e.target.classList.toggle('active');
    }
    // ACTIVE MOVE ALL BUT 1 OPTION
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

        let path;
        if(moveAll){
            path = './move/all';
        }else if(letOne){
            path = './move/let/one';
        }

        axios.post(path, {
            lord: document.querySelector('.moving').id,
            village: document.querySelector('.to').id
        })
        .then(res=>{
            document.querySelector('.moving').parentNode.parentNode.remove();
            document.querySelector('.to').innerHTML += res.data;
        })
        .then(()=>{
            if(document.querySelector('.move-options.show')){
                document.querySelector('.move-options.show').classList.remove('show');
            }
            if(document.querySelector('.active')){
                document.querySelector('.active').classList.remove('active');
            }
            document.querySelector('.to').classList.remove('to');
        })

    }



})

