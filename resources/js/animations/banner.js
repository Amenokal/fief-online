// CUSTOM CANVAS BANNERS !!!

export function drawBanners(){
    console.log('init')
    document.querySelectorAll('.banner').forEach(el=>{
        console.log(el)
        draw(el);
    })
}

function getProp(what){
    return window.getComputedStyle(document.documentElement,null).getPropertyValue('--'+what);
}


export function draw(target){

    console.log(target);

    let elm = document.querySelector('.game-view').className.split(' ')[1].split('-')[0];
    let baseColor = getProp(elm);
    let strongColor = getProp(elm+'-strong');
    let txtColor = getProp(elm+'-txt');
    let power = target.className.split(' ')[2].split('-')[1];

    let cvs = target;
    let ctx = cvs.getContext('2d');

    // MANCHE
    ctx.fillStyle = 'rgb(58, 28, 0)';
    ctx.fillRect(119, 0, 12, 400);
    ctx.fillRect(25, 35, 200, 12);

    // // ATTACHES
    // ctx.strokeStyle = 'black';
    // ctx.beginPath();
    // ctx.moveTo(cvs.width/2,cvs.height/40);
    // ctx.lineTo(cvs.height/10, cvs.width/9);
    // ctx.closePath();
    // ctx.stroke();

    // ctx.strokeStyle = 'black';
    // ctx.beginPath();
    // ctx.moveTo(cvs.width/2,cvs.height/40);
    // ctx.lineTo(cvs.width*.85, cvs.width/9);
    // ctx.closePath();
    // ctx.stroke();






    // BORDER
    ctx.fillStyle = strongColor;
    ctx.beginPath();
    ctx.moveTo(35,30);
    ctx.lineTo(35,300);
    ctx.lineTo(125,350);
    ctx.lineTo(215,300);
    ctx.lineTo(215,300);
    ctx.lineTo(215,30);
    ctx.closePath();
    ctx.fill();

    // // BASE
    ctx.fillStyle = baseColor;
    ctx.beginPath();
    ctx.moveTo(50,50);
    ctx.lineTo(50,285);
    ctx.lineTo(125,325);
    ctx.lineTo(200,285);
    ctx.lineTo(200,50);
    ctx.closePath();
    ctx.fill();



    // // POWER
    ctx.fillStyle = txtColor;
    ctx.beginPath();
    ctx.moveTo(50,285);
    ctx.lineTo(125,325);
    ctx.lineTo(125,325-((275/37)*1));
    ctx.lineTo(50,325-((275/37)*1));
    ctx.closePath();
    ctx.fill();





    // // CHEVRONS
    ctx.fillStyle = strongColor;
    for(let i=0; i<power; i++){
        ctx.beginPath();
        ctx.moveTo(cvs.width/5,(cvs.height/6)+      70*i-15);
        ctx.lineTo(cvs.width/5,(cvs.height/6+40)+      70*i-15);
        ctx.lineTo(cvs.width/2,(cvs.height/3.3+40)+      70*i-15);
        ctx.lineTo(cvs.width*.8,(cvs.height/6+40)+      70*i-15);
        ctx.lineTo(cvs.width*.8,(cvs.height/6)+      70*i-15);
        ctx.lineTo(cvs.width/2,(cvs.height/3.3)+      70*i-15);
        ctx.closePath();
        ctx.fill();
    }



    // ARMOIRIES
    // var img = new Image;
    // img.src = "/fief/storage/app/public/banners/blue.png";
    // img.width = '20%';
    // img.height = '20%';
    // img.onload = ()=>{
    //     ctx.drawImage(img, 75, 75, 100, 100);
    // }

}