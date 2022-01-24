const { default: axios } = require("axios");
const { ArmyManager } = require("../classes/ArmyManager");

document.getElementById('moveBtn').addEventListener('click', e=>{
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
    }

    // MOVE OPTION TOGGLE "ACTIVE"
    else if (phase.id === "phase-11" && document.querySelector('#moveBtn.active') && e.target.className.includes('move-option') ){
        if(document.querySelector('.move-menu.show>.active')){
            document.querySelector('.move-menu.show>.active').classList.remove('active');
        }
        if(!e.target.className.includes('active')){
            e.target.classList.add('active')

            // ON "ACTIVE" > ADD VILLAGE LISTENERS
            document.querySelectorAll('.village').forEach(el=>{
                el.addEventListener('click', villageListeners, true);
            })
        }
    }
});

function villageListeners(e){
    if(document.querySelector('.current-phase').id === "phase-11" && e.currentTarget.className.includes('village')){
        e.currentTarget.classList.add('village-to');

        if(document.querySelector('.move-all.active')){
            moveAll(e)
        }else if(document.querySelector('.let-one.active')){
            letOne(e)
        }else if(document.querySelector('.inspect.active')){
            inspect(e)
        }
    }
}

function moveAll(e){
    if(document.querySelector('.current-phase').id === "phase-11" && e.currentTarget.className.includes('village')){
        console.log(e.currentTarget);
        e.currentTarget.classList.add('village-to');
        axios.post('./move/moveall', {
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
                el.removeEventListener('click', villageListeners, true);
            })
        })
    }

}

function letOne(e){
    if(document.querySelector('.current-phase').id === "phase-11" && e.currentTarget.className.includes('village')){
        e.currentTarget.classList.add('village-to');
        axios.post('./move/letone', {
            lord: document.querySelector('.moving-lord').id,
            villageFrom: document.querySelector('.village-from').id,
            villageTo: document.querySelector('.village-to').id
        })
        .then(res=>{
            let vTo = document.querySelector('.village-to');

            // MOVE ARMIES
            ArmyManager.removeLeftSoldiers(res.headers.staying);
            vTo.innerHTML += res.data;

            // MANAGES VILLAGES OWNERSHIPS DISPLAY
            if(vTo.className.includes('bordered')){vTo.className = vTo.className.split(' ')[0]}
            if(res.headers.tovillagecolor){
                vTo.classList.remove('empty');
                vTo.classList.add(`${res.headers.tovillagecolor}-bordered`);
            }
        })
        .then(()=>{

            // CLEAN CLASSES & LISTENERS
            document.querySelector('.moving-army').classList.remove('moving-army');
            document.querySelector('.move-menu.show>.active').classList.remove('active');
            document.querySelector('.move-menu.show').classList.remove('show');
            document.querySelector('.village-to').classList.remove('village-to');
            document.querySelectorAll('.village').forEach(el=>{
                el.removeEventListener('click', villageListeners, true);
            })
        })
    }
}


// function cleanMovementPhase(){
//     document.getElementById('moveBtn').classList.remove('active');
//     document.querySelector('.move-menu.show').classList.remove('show');
//     document.querySelector('.active').classList.remove('active');
//     document.querySelector('.village-from').classList.remove('from');
//     document.querySelector('.village-to').classList.remove('to');
// }
