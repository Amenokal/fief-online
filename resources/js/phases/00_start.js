import { drawAnimation } from '../animations/cards.js';

// \\\
// -----------------------------------
// GAME START ::::: STEP 1 = DRAW LORD
// -----------------------------------
// ///

document.getElementById('step1').addEventListener('click', ()=>{
    axios.post('./gamestart/1')
    .then(res => {
        if(!res.data.error){
            drawAnimation(res.data.drawnCard, res.data.nextCardType)
        }
        else{
            console.log(res.data.error);
        }
    });
});



// \\\
// ----------------------------------------
// GAME START ::::: STEP 2 = CHOOSE VILLAGE
// ----------------------------------------
// ///

document.getElementById('step2').addEventListener('click', e=>{
    e.target.classList.toggle('active');

    document.querySelectorAll('.village').forEach(el=>{
        if(e.target.className.includes('active')){
            el.addEventListener('click', chooseVillage, true);
            if(el.className.includes('empty')){
                el.classList.add('to-choose');
            }
        }else{
            el.removeEventListener('click', chooseVillage, true);
            if(el.className.includes('to-choose')){
                el.classList.remove('to-choose');
            }
        }
    });
})

function chooseVillage(e){
    let village = e.currentTarget;
    axios.post('./gamestart/2', {
        village: village.id
    })
    .then(res => {
        console.log(res.data.error);
        if(!res.data.error){
            village.innerHTML += `<span class='chateau'></span>`
            village.innerHTML += res.data;
            document.getElementById('step2').classList.remove('active');
        }
        else {
            console.log(res.data.error);
        }
    });
}



// \\\
// ----------------------------
// GAME START ::::: CLEAN PHASE
// ----------------------------
// ///

function cleanStartPhase(){
    document.querySelectorAll('.village').forEach(el=>{
        el.removeEventListener('click', chooseVillage, true);
    })
    document.querySelectorAll('.village').forEach(el=>{
        el.classList.remove('to-choose');
    })
    document.getElementById('step2').classList.remove('active')
    document.querySelector('.game-view').removeEventListener('click', prepareChooseVillage);
}
