const { default: axios } = require("axios");
const { Builder } = require("../classes/Builder");

document.querySelectorAll('#buyBtn-moulin, #buyBtn-sergeant, #buyBtn-knight').forEach(el=>{
    el.addEventListener('click', readyToBuy)
})
function readyToBuy(e){
    if(document.querySelector('.buy-this')){
        document.querySelector('.buy-this').classList.remove('buy-this');
    }
    e.target.classList.add('buy-this');

    document.querySelectorAll('.village').forEach(el=>{
        el.addEventListener('click', buyHere, true);
    })
};

function buyHere(e){
    let village = false;
    let type = document.querySelector('.buy-this').id.split('-')[1];

    if(e.currentTarget.className.includes('village')){
        village = e.currentTarget.id;
    }

    if(village){
        axios.post('./gold/buy', {
            village: village,
            type: type
        })
        .then(res=>{
            console.log(res);

            document.querySelector(`#${village}>.village-buildings`).innerHTML += res.data;
        })
    }
    document.querySelectorAll('.village').forEach(el=>{
        el.removeEventListener('click', buyHere, true);
    })
}
