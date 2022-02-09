const { default: axios } = require("axios");
import { Game } from "../classes/Game";
const { Army } = require("../classes/Army");



export function moveListeners(e){

    // MOVE PHASE >>> WHEN CLICK ON LORD
    if(e.target.className.includes('lord') ){

        // OPEN MOVE OPTIONS
        if(document.querySelector('.show')){
            document.querySelector('.show').classList.remove('show');
        }
        e.target.parentNode.nextElementSibling.classList.add('show');

        // SET INITIAL ARMY POSITION DATA
        e.target.classList.add('moving-lord');
        e.target.parentNode.parentNode.classList.add('moving-army');
        e.target.parentNode.parentNode.parentNode.parentNode.classList.add('village-from');
    }

    // MOVE OPTION TOGGLE "ACTIVE"
    else if (e.target.className.includes('move-option') ){
        if(e.target.className.includes('close')){
            document.querySelector('.move-menu.show').classList.remove('show');
            document.querySelector('.moving-lord').classList.remove('moving-lord');
            document.querySelector('.moving-army').classList.remove('moving-army');
            document.querySelector('.village-from').classList.remove('village-from');
            if(document.querySelector('active')){
                document.querySelector('active').classList.remove('active');
            }
        }
        else {
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
            }
        }

    }
};

function villageListeners(e){
    if(e.currentTarget.className.includes('village')){
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
    axios.post('./move/moveall', {
        lord: document.querySelector('.moving-lord').id,
        villageFrom: document.querySelector('.village-from').id,
        villageTo: document.querySelector('.village-to').id
    })
    .then(res=>{
        Game.update();
    })
}

function letOne(e){
    axios.post('./move/letone', {
        lord: document.querySelector('.moving-lord').id,
        villageFrom: document.querySelector('.village-from').id,
        villageTo: document.querySelector('.village-to').id
    })
    .then(res=>{
        Game.update();
    })
}

function inspect(){
    console.log(document.querySelector('.village-to'));
    axios.post('./move/inspect', {
        army: Army.movingArmy(),
        villageFrom: document.querySelector('.village-from').id,
        villageTo: document.querySelector('.village-to').id
    })
    .then(res=>{
        Game.update();
    });
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
        document.querySelector('.army-manager').addEventListener('click', armyManagerListeners);

        // REMOVE MOVING LORD FROM 'TO-STAY' ZONE & PUT HIM IN 'TO-MOVE' ZONE HERE ...
    })
}

function armyManagerListeners(e){
    if((e.target.className.includes('lord') || e.target.className.includes('token'))){
        let elem = e.target;
        let clone = elem.cloneNode();

        if(elem.parentNode.className.includes('a-m-staying')){
            if(elem.className.includes('token')){
                document.querySelector('.a-m-moving-army').appendChild(clone);
            }else if(elem.className.includes('lord')){
                document.querySelector('.a-m-moving-lords').appendChild(clone);
            }
        }else if(e.target.parentNode.className.includes('a-m-moving')){
            if(elem.className.includes('token')){
                document.querySelector('.a-m-staying-army').appendChild(clone);
            }else if(elem.className.includes('lord')){
                document.querySelector('.a-m-staying-lords').appendChild(clone);
            }
        }

        elem.remove();
    }

    else if(e.target.id === 'a-m-cancel-btn'){
        document.querySelector('.army-manager.modal').remove();
        document.querySelector('.inspect.active').classList.remove('active');
    }
    else if(e.target.id ==='a-m-validate-btn'){

        document.querySelectorAll('.a-m-staying-lords>.lord, .a-m-staying-army>.token').forEach(el=>{
            if(el.className.includes('lord')){
                document.querySelector('.moving-army>.lord-forces>#'+el.id).classList.add('splited-to-stay');
            }
            else if(el.className.includes('sergeant') || el.className.includes('knight')){
                document.querySelector(`.moving-army>.army-forces>.${el.className.split(' ')[0]}:not(.splited-to-stay)`).classList.add('splited-to-stay');
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
