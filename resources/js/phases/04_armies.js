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

            // INSPECT >> OPEN ARMY MANAGER MODAL
            if(e.target.className.includes('inspect') && e.target.className.includes('active')){
                openArmyManager(e);
            }

            // ON "ACTIVE" > ADD VILLAGE LISTENERS
            document.querySelectorAll('.village').forEach(el=>{
                el.addEventListener('click', villageListeners, true);
            })
            console.log('village listeners added');
        }
    }
});

function villageListeners(e){
    if(document.querySelector('.current-phase').id === "phase-11" && e.currentTarget.className.includes('village')){
        e.currentTarget.classList.add('village-to');
        console.log('village listener');

        if(document.querySelector('.move-all.active')){
            moveAll(e)
        }else if(document.querySelector('.let-one.active')){
            letOne(e)
        }else if(document.querySelector('.inspect.active')){
            console.log('inspect option active')
            inspect(e)
        }
    }
}

function moveAll(e){
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

function letOne(e){
    axios.post('./move/letone', {
        lord: document.querySelector('.moving-lord').id,
        villageFrom: document.querySelector('.village-from').id,
        villageTo: document.querySelector('.village-to').id
    })
    .then(res=>{
        let vTo = document.querySelector('.village-to');

        // MOVE ARMIES
        ArmyManager.removeMovingSoldiers(res.headers.staying);
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

function inspect(){
    console.log(ArmyManager.movingLords());
    console.log(ArmyManager.movingArmy());

    axios.post('./move/inspect', {
        lords: ArmyManager.movingLords(),
        army: ArmyManager.movingArmy(),
        villageTo: document.querySelector('.village-to').id
    })
    .then(res=>{

        let vTo = document.querySelector('.village-to');

        // MOVE ARMIES
        ArmyManager.removeMovingArmy();
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
        document.querySelectorAll('.splited-to-stay').forEach(el=>{
            el.classList.remove('splited-to-stay')
        })
        document.querySelector('.moving-army').classList.remove('moving-army');
        document.querySelector('.move-menu.show>.active').classList.remove('active');
        document.querySelector('.move-menu.show').classList.remove('show');
        document.querySelector('.village-to').classList.remove('village-to');
        document.querySelectorAll('.village').forEach(el=>{
            el.removeEventListener('click', villageListeners, true);
        })
    })
}



function openArmyManager(e){
    axios.get('./show/army/manager', {
        params:{
            'lord': document.querySelector('.moving-lord').id,
            'village': document.querySelector('.village-from').id
        }
    })
    .then(res=>{
        document.querySelector('main').innerHTML += res.data;
        let villageName = document.querySelector('.a-m-village>h1');
        villageName.innerText = villageName.innerText.replace('-', " ").toUpperCase();
        document.querySelector('.army-manager').addEventListener('click', armyManagerListener);
    })
}

function armyManagerListener(e){
    if((e.target.className.includes('lord') || e.target.className.includes('token'))){
        if(e.target.parentNode.className.includes('a-m-staying')){
            e.target.classList.toggle('selected-to-move');
        }else if(e.target.parentNode.className.includes('a-m-moving')){
            e.target.classList.toggle('selected-to-stay');
        }
    }

    if(e.target.className.includes('to-move-btn')){
        let toMove = document.querySelectorAll('.selected-to-move');
        toMove.forEach(el=>{
            let clone = el.cloneNode();
            clone.classList.remove('selected-to-move');
            if(el.className.includes('token')){
                document.querySelector('.a-m-moving-army').appendChild(clone);
            }else if(el.className.includes('lord')){
                document.querySelector('.a-m-moving-lords').appendChild(clone);
            }
            el.remove();
        })
    }else if(e.target.className.includes('to-stay-btn')){
        let toStay = document.querySelectorAll('.selected-to-stay');
        toStay.forEach(el=>{
            let clone = el.cloneNode();
            clone.classList.remove('selected-to-stay');
            if(el.className.includes('token')){
                document.querySelector('.a-m-staying-army').appendChild(clone);
            }else if(el.className.includes('lord')){
                document.querySelector('.a-m-staying-lords').appendChild(clone);
            }
            el.remove();
        })

    }

    if(e.target.id === 'a-m-cancel-btn'){
        document.querySelector('.army-manager.modal').remove();
    }else if(e.target.id ==='a-m-validate-btn'){

        document.querySelectorAll('.a-m-staying-lords>.lord, .a-m-staying-army>.token').forEach(el=>{
            if(el.className.includes('lord')){
                document.querySelector('.village-from>.moving-army>.lord-forces>#'+el.id).classList.add('splited-to-stay');
            }
            else if(el.className.includes('sergeant') || el.className.includes('knight')){
                document.querySelector(`.village-from>.moving-army>.army-forces>.${el.className.split(' ')[0]}-container>.${el.className.split(' ')[0]}:not(.splited-to-stay)`).classList.add('splited-to-stay');
            }
        });

        document.querySelector('.army-manager.modal').remove();

        document.querySelectorAll('.village').forEach(el=>{
            el.addEventListener('click', villageListeners, true);
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
