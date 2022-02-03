const { default: axios } = require("axios");



// \\\
// -----------------
// GOLD ::::: INCOME
// -----------------
// ///

export function getIncome(){
    axios.post('./gold/income')
    .then(res=>{
        document.querySelector('.current-player').parentNode.innerHTML = res.data;
    })
}



// \\\
// --------------
// GOLD ::::: BUY
// --------------
// ///

export function readyToBuy(e){
    if(document.querySelector('.buy-this')){
        document.querySelector('.buy-this').classList.remove('buy-this');
    }
    e.target.classList.add('buy-this');

    document.querySelectorAll('.village').forEach(el=>{
        el.addEventListener('click', buyHere, true);
    })

    document.querySelectorAll('.crown').forEach(el=>{
        el.addEventListener('click', buyTitle);
    })
};

function buyHere(e){
    let village = false;
    let type = document.querySelector('.buy-this').id.split('-')[1];

    if(e.currentTarget.className.includes('village')){
        village = e.currentTarget.id;
    }

    if(village){
        if(document.querySelector('.buy-this').id.includes('moulin')){
            axios.post('./gold/buy/mill', {
                village: village,
                type: type
            })
            .then(res=>{
                document.querySelector(`#${village}>.buildings`).innerHTML += res.data;
                document.querySelector('.current-player').nextElementSibling.children[1].innerText = 'Or: '+res.headers.gold;
            })
        }
        else if(document.querySelector('.buy-this').id.includes('chateau')){
            axios.post('./gold/buy/castle', {
                village: village,
                type: type
            })
            .then(res=>{
                document.querySelector(`#${village}>.buildings`).innerHTML += res.data;
                document.querySelector('.current-player').nextElementSibling.children[1].innerText = 'Or: '+res.headers.gold;
            })
        }
        else if(document.querySelector('.buy-this').id.includes('sergeant')){
            axios.post('./gold/buy/sergeant', {
                village: village,
                type: type
            })
            .then(res=>{
                if(res.headers.gold){
                    document.querySelector(`#${village}>.armies`).innerHTML = res.data;
                    document.querySelector('.current-player').nextElementSibling.children[1].innerText = 'Or: '+res.headers.gold;
                }
            })
        }
        else if(document.querySelector('.buy-this').id.includes('knight')){
            axios.post('./gold/buy/knight', {
                village: village,
                type: type
            })
            .then(res=>{
                if(res.headers.gold){
                    document.querySelector(`#${village}>.armies`).innerHTML = res.data;
                    document.querySelector('.current-player').nextElementSibling.children[1].innerText = 'Or: '+res.headers.gold;
                }
            })
        }
        else if(document.querySelector('.buy-this').id.includes('crown') && document.querySelector('.selected-title') && document.querySelector('.selected-lord')){
            axios.post('./gold/buy/crown', {
                village: village,
                title: document.querySelector('.selected-title').id.split('-')[1],
                lord: document.querySelector('.selected-lord').id
            })
            .then(res=>{
                if(res.headers.gold){
                    document.querySelector(`#${village}>.buildings`).innerHTML += res.data;
                    document.querySelector('.current-player').nextElementSibling.children[1].innerText = 'Or: '+res.headers.gold;
                }
            })
        }
    }
    document.querySelector('.buy-this').classList.remove('buy-this');
    document.querySelectorAll('.village').forEach(el=>{
        el.removeEventListener('click', buyHere, true);
    })
}

function buyTitle(e){
    e.target.classList.add('selected-title');
    document.querySelectorAll('.crown').forEach(el=>{
        el.removeEventListener('click', buyTitle);
    })
    document.querySelector('.current-player').click();
    document.querySelector('body').addEventListener('click', chooseLordForCrown);
}

function chooseLordForCrown(e){
    if(e.target.className.includes('slot', 'player-board')){
        document.getElementById(e.target.className.split(' ')[1].split('-')[2]).classList.add('selected-lord');
    }
    document.querySelectorAll('.village').forEach(el=>{
        el.addEventListener('click', buyHere, true);
    })
}
