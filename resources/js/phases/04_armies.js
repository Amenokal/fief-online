const { default: axios } = require("axios");

document.getElementById('moveBtn').addEventListener('click', e=>{
    e.target.classList.toggle('move-active')
});

document.querySelector('.game-view').addEventListener('click',e=>{
    let phase = document.querySelector('.current-phase');

    // ONCLICK LORD >>> MOVE PHASE
    if( phase.id === 'phase-11' && document.querySelector('.move-active') && e.target.className.includes('lord') ){

        // OPEN MOVE OPTIONS
        e.target.parentNode.nextElementSibling.classList.add('show');

        // SET INITIAL ARMY POSITION DATA
        e.target.classList.add('moving-lord');
        e.target.parentNode.parentNode.classList.add('moving-army');
        e.target.parentNode.parentNode.parentNode.classList.add('village-from');

        // ADD MOVE OPTION LISTENERS
        document.querySelector('.move-options.show').children[0].addEventListener('click', inspect, true);
        document.querySelector('.move-options.show').children[1].addEventListener('click', letOne, true);
        document.querySelector('.move-options.show').children[2].addEventListener('click', moveAll, true);
        document.querySelector('.move-options.show').children[3].addEventListener('click', cleanMovePhase, true);
    }
});


function moveAll(e){
    if(document.querySelector('.active')){
        document.querySelector('.active').classList.remove('active')
    }
    if(!e.target.className.includes('active')){
        e.target.classList.add('active');
    }
    document.querySelectorAll('.village').forEach(el=>{
        el.addEventListener('click', moveAllListener, true)
    })
}
function moveAllListener(e){
    if(e.eventPhase === 1){
        e.currentTarget.classList.add('village-to');
        axios.post('./move/all', {
            lord: document.querySelector('.moving-lord').id,
            village: document.querySelector('.village-to').id
        })
        .then(res=>{
            document.querySelector('.moving-army').remove();
            document.querySelector('.village-to').innerHTML += res.data;
            cleanMovePhase();
        })
    }
}

function letOne(e){
    if(document.querySelector('.active')){
        document.querySelector('.active').classList.remove('active')
    }
    if(!e.target.className.includes('active')){
        e.target.classList.add('active');
    }
    document.querySelectorAll('.village').forEach(el=>{
        el.addEventListener('click', letOneListener, true)
    })
}
function letOneListener(e){
    if(e.eventPhase === 1){
        e.currentTarget.classList.add('village-to');
        axios.post('./let/one', {
            lord: document.querySelector('.moving-lord').id,
            village: document.querySelector('.village-to').id
        })
        .then(res=>{
            if(document.querySelector('.moving-army>.army-forces>.sergeant-container').hasChildNodes()){
                document.querySelector('.moving-army>.army-forces>.sergeant-container').firstElementChild.remove();
            }else if(document.querySelector('.moving-army>.army-forces>.knight-container').hasChildNodes()){
                document.querySelector('.moving-army>.army-forces>.knight-container').firstElementChild.remove();
            }
            document.querySelector('.moving-army').remove();
            document.querySelector('.village-to').innerHTML += res.data;
            cleanMovePhase();
        })
    }
}
// function closeMoveOptions(){
//     document.querySelector('.moving-army').classList.remove('moving-army');
//     document.querySelector('.village-from').classList.remove('village-from');
//     if(document.querySelector('.active')){
//         document.querySelector('.active').classList.remove('active');
//     }
//     document.querySelector('.move-options.show').children[0].removeEventListener('click', inspect, true);
//     document.querySelector('.move-options.show').children[1].removeEventListener('click', letOne, true);
//     document.querySelector('.move-options.show').children[2].removeEventListener('click', moveAll, true);
//     document.querySelector('.move-options.show').children[3].removeEventListener('click', closeMoveOptions, true);
//     document.querySelector('.move-options.show').classList.remove('show');
// }



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

    if(document.querySelector('#move-option-move-all.active')||
        document.querySelector('#move-option-let-one.active')){
            console.log('active listeners')
        const vilg = document.querySelectorAll('.village');
        vilg.forEach(el=>{
            el.addEventListener('click', activeVillageListeners, true)
        })
    }

            // ::::: OPTION REQUESTS :::::
            // ---------------------------
            

    if(document.querySelector('.move-options.show') &&
    (e.target.className.includes('village') || e.target.parentNode.className.includes('village') )){
        
        let moveAll = document.getElementById('move-option-move-all').className.includes('active');
        let letOne = document.getElementById('move-option-let-one').className.includes('active');

        if(e.target.className.includes('village')){
            villageTo = e.target;
        }else if(e.target.parentNode.className.includes('village')){
            villageTo = e.target.parentNode;
        }

        // REQUEST
        if((document.getElementById('move-option-move-all').className.includes('active') ||
            document.getElementById('move-option-let-one').className.includes('active')) &&
            villageTo !==null
        ){
            
            let path;
            if(moveAll){
                path = './move/all';
            }else if(letOne){
                path = './move/let/one';
            }
            axios.post(path, {
                lord: movingLord.id,
                village: villageTo.id
            })
            .then(res=>{
                document.querySelector('.moving').parentNode.parentNode.remove();
                document.querySelector('.to').innerHTML += res.data;
                if(letOne){
                    if(armyFrom.children[2].children[0].children[0].children){
                        armyFrom.children[2].children[0].children[0].remove()
                    }else if(armyFrom.children[2].children[1].children[0].children){
                        armyFrom.children[2].children[0].children[1].remove()
                    }else if(armyFrom.children[0].children){
                        for(let i=0; i<armyFrom.children[0].children.length; i++){
                            if(!armyFrom.children[0].children[i].className.includes('moving')){
                                armyFrom.children[0].children[i].remove();
                            }
                        }
                    }
                }else{
                    armyFrom.remove();
                }
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




function activeVillageListeners(e){
    if(e.eventPhase === 1){
        console.log(e.currentTarget);
    }
    removeVillageListeners();
}
function removeVillageListeners(){
    console.log('remove listners');
    let vilg = document.querySelectorAll('.village');
    vilg.forEach(el=>{
        el.removeEventListener('click', activeVillageListeners, true)
    })
}