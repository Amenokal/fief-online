const { default: axios } = require("axios");

document.getElementById('moveBtn').addEventListener('click', e=>{
    console.log('moveBtn')
    e.target.classList.toggle('active')
});

document.querySelector('.game-view').addEventListener('click',e=>{
    let phase = document.querySelector('.current-phase');

    // MOVE PHASE >>> WHEN CLICK ON LORD
    if(phase.id === "phase-11" && document.querySelector('#moveBtn.active') && e.target.className.includes('lord') ){

        // OPEN MOVE OPTIONS
        e.target.parentNode.nextElementSibling.classList.add('show');

        // SET INITIAL ARMY POSITION DATA
        e.target.classList.add('moving-lord');
        e.target.parentNode.parentNode.classList.add('moving-army');
        e.target.parentNode.parentNode.parentNode.classList.add('village-from');

        // ADD MOVE OPTION LISTENERS
        // document.querySelector('.move-menu.show').children[0].addEventListener('click', inspect, true);
        // document.querySelector('.move-menu.show').children[1].addEventListener('click', letOne, true);
        document.querySelector('.move-menu.show').children[2].addEventListener('click', moveAll, true);
        // document.querySelector('.move-menu.show').children[3].addEventListener('click', cleanMovePhase, true);
    }
});


function moveAll(e){
    console.log('func movall')
    if(!!document.querySelectorAll('.move-option.active')[0]){
        e.target.classList.remove('active')
    }else{
        e.target.classList.add('active');
    }

    document.querySelectorAll('.village').forEach(el=>{
        el.addEventListener('click', moveAllListeners, true)
    })
}

function moveAllListeners(e){
    if(document.querySelector('.current-phase').id === "phase-11" && e.currentTarget.className.includes('village')){
        e.currentTarget.classList.add('village-to');
        axios.post('./move/all', {
            lord: document.querySelector('.moving-lord').id,
            villageFrom: document.querySelector('.village-from').id,
            villageTo: document.querySelector('.village-to').id
        })
        .then(res=>{

            // MANAGES VILLAGES OWNERSHIPS DISPLAY
            let vFrom = document.querySelector('.village-from');
            let vTo = document.querySelector('.village-to');

            document.querySelector('.moving-army').remove();
            vTo.innerHTML += res.data;

            if(vFrom.className.includes('bordered')){vFrom.className = vFrom.className.split(' ')[0]}
            if(vTo.className.includes('bordered')){vTo.className = vTo.className.split(' ')[0]}

            if(res.headers.fromvillagecolor){vFrom.classList.add(`${res.headers.fromvillagecolor}-bordered`)}
            else{vFrom.classList.add("empty")}

            if(res.headers.tovillagecolor){
                vTo.classList.remove('empty');
                vTo.classList.add(`${res.headers.tovillagecolor}-bordered`);
            }
        })
        .then(()=>{

            // CLEAN CLASSES & LISTENERS
            document.querySelector('.village-to').classList.remove('village-to');
            document.querySelectorAll('.village').forEach(el=>{
                el.removeEventListener('click', moveAllListeners, true);
            })
        })
    }
}

// function letOne(e){
//     if(document.querySelector('#let-one.active')){
//         document.querySelector('.active').classList.remove('active')
//     }
//     if(!e.target.className.includes('active')){
//         e.target.classList.add('active');
//     }
//     document.querySelectorAll('.village').forEach(el=>{
//         el.addEventListener('click', letOneListener, true)
//     })
// }
// function letOneListener(e){
//     if(e.eventPhase === 1){
//         e.currentTarget.classList.add('village-to');
//         axios.post('./let/one', {
//             lord: document.querySelector('.moving-lord').id,
//             village: document.querySelector('.village-to').id
//         })
//         .then(res=>{
//             console.log(res);
//             // if(document.querySelector('.moving-army>.army-forces>.sergeant-container').hasChildNodes()){
//             //     document.querySelector('.moving-army>.army-forces>.sergeant-container').firstElementChild.remove();
//             // }else if(document.querySelector('.moving-army>.army-forces>.knight-container').hasChildNodes()){
//             //     document.querySelector('.moving-army>.army-forces>.knight-container').firstElementChild.remove();
//             // }
//             // document.querySelector('.moving-army').remove();
//             // document.querySelector('.village-to').innerHTML += res.data;
//             // cleanMovePhase();
//         })
//     }
// }
// function closeMoveOptions(){
//     document.querySelector('.moving-army').classList.remove('moving-army');
//     document.querySelector('.village-from').classList.remove('village-from');
//     if(document.querySelector('.active')){
//         document.querySelector('.active').classList.remove('active');
//     }
//     document.querySelector('.move-menu.show').children[0].removeEventListener('click', inspect, true);
//     document.querySelector('.move-menu.show').children[1].removeEventListener('click', letOne, true);
//     document.querySelector('.move-menu.show').children[2].removeEventListener('click', moveAll, true);
//     document.querySelector('.move-menu.show').children[3].removeEventListener('click', closeMoveOptions, true);
//     document.querySelector('.move-menu.show').classList.remove('show');
// }



            // ::::: OPTION SELECT :::::
            // -------------------------

    // // ACTIVE OPTION #1 >>> MOVE ALL
    // if(document.querySelector('.move-menu.show') && e.target.id === 'move-all'){
    //     e.target.classList.toggle('active');
    // }
    // // ACTIVE OPTION #2 >>> MOVE ALL BUT 1
    // if(document.querySelector('.move-menu.show') && e.target.id === 'let-one'){
    //     e.target.classList.toggle('active');
    // }

    // if(document.querySelector('#move-all.active')||
    //     document.querySelector('#let-one.active')){
    //         console.log('active listeners')
    //     const vilg = document.querySelectorAll('.village');
    //     vilg.forEach(el=>{
    //         el.addEventListener('click', activeVillageListeners, true)
    //     })
    // }


// function cleanMovementPhase(){
//     document.getElementById('moveBtn').classList.remove('active');
//     document.querySelector('.move-menu.show').classList.remove('show');
//     document.querySelector('.active').classList.remove('active');
//     document.querySelector('.village-from').classList.remove('from');
//     document.querySelector('.village-to').classList.remove('to');
// }
