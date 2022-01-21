// CUSTOM CANVAS BANNERS !!!

export function drawAll(power){
    document.querySelectorAll('.banner').forEach(el=>{
        draw(el, power);
    })
}

function getProp(what){
    return window.getComputedStyle(document.documentElement,null).getPropertyValue('--'+what);
}


export function draw(target, power = 1){

    let elm = document.querySelector('.game-view').className.split(' ')[1].split('-')[0];
    let baseColor = getProp(elm);
    let strongColor = getProp(elm+'-strong');
    let txtColor = getProp(elm+'-txt');

    let cvs = target;
    let ctx = cvs.getContext('2d');

    // MANCHE
    ctx.fillStyle = 'rgb(58, 28, 0)';
    ctx.fillRect(cvs.width/2-4, 0, 8, cvs.height);
    ctx.fillRect(cvs.width/15, cvs.height/14.5, cvs.width*.87, cvs.height/20);

    // ATTACHES
    ctx.strokeStyle = 'black';
    ctx.beginPath();
    ctx.moveTo(cvs.width/2,cvs.height/40);
    ctx.lineTo(cvs.height/10, cvs.width/9);
    ctx.closePath();
    ctx.stroke();

    ctx.strokeStyle = 'black';
    ctx.beginPath();
    ctx.moveTo(cvs.width/2,cvs.height/40);
    ctx.lineTo(cvs.width*.85, cvs.width/9);
    ctx.closePath();
    ctx.stroke();


    // BORDER
    ctx.fillStyle = strongColor;
    ctx.beginPath();
    ctx.moveTo(cvs.width/10,cvs.width/10);
    ctx.lineTo(cvs.width/10,cvs.height/1.4);
    ctx.lineTo(cvs.width/2,cvs.height/1.13);
    ctx.lineTo(cvs.width*(9/10),cvs.height/1.4);
    ctx.lineTo(cvs.width*(9/10),cvs.width/10);
    ctx.closePath();
    ctx.fill();

    // BASE
    ctx.fillStyle = baseColor;
    ctx.beginPath();
    ctx.moveTo(cvs.width/5,cvs.width/5);
    ctx.lineTo(cvs.width/5,cvs.height/1.48);
    ctx.lineTo(cvs.width/2,cvs.height/1.23);
    ctx.lineTo(cvs.width*(4/5),cvs.height/1.48);
    ctx.lineTo(cvs.width*(4/5),cvs.width/5);
    ctx.closePath();
    ctx.fill();

    // 2ND COLOR
    ctx.fillStyle = txtColor;
    ctx.beginPath();
    ctx.moveTo(cvs.width/5,cvs.width/5);
    ctx.lineTo(cvs.width/5,cvs.height/1.48);
    ctx.lineTo(cvs.width/2,cvs.height/1.23);
    ctx.lineTo(cvs.width/2,cvs.height/1.48);
    ctx.lineTo(cvs.width/2,cvs.width/5);
    ctx.closePath();
    ctx.fill();

    // CHEVRONS
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