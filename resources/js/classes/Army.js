export class Army{

    static firstArmyTo(villageName, playerColor, armyContent){
        let vilg = document.getElementById(villageName);
        document.querySelector(`#${villageName}>.armies`).innerHTML += armyContent;
        vilg.classList.remove('empty');
        vilg.classList.add(`${playerColor}-bordered`);
    }


    // static addArmyTo(villageName, playerColor, armyContent){
    //     console.log(armyContent);
    //     let armyContainer = document.querySelector(`#${villageName}>.armies`);

    //     let hasArmyHere = !!document.querySelector(`#${villageName}>.armies>.${playerColor}`);
    //     console.log(hasArmyHere);
    //     if(!hasArmyHere){
    //         document.querySelector(`#${villageName}>.armies`).innerHTML += armyContent;
    //     }
    //     else {
    //         let sergeantCount = (temp.match(/lord/g) || []).length;
    //         let sergeantCount = (temp.match(/sergeant/g) || []).length;
    //         let knightCount = (temp.match(/knight/g) || []).length;
    //         document.querySelector(`#${villageName}>.armies>.${playerColor}>.army-forces`).innerHTML +=
    //     }

    // }


    static removeMovingArmy(){
        document.querySelectorAll('.moving-army>.army-forces>.sergeant:not(.splited-to-stay), .moving-army>.army-forces>.knight:not(.splited-to-stay), .moving-army>.lord-forces>.lord:not(.splited-to-stay)')
        .forEach(el=>{
            el.remove();
        })
    }

    static movingArmy(){
        let soldiers = [];
        document.querySelectorAll('.moving-army>.army-forces>span:not(.splited-to-stay)').forEach(el=>{
            if(el.className.includes('lord')){
                soldiers.push(el.id);
            }
            else{
                soldiers.push(el.className.split(' ')[0]);
            }
        })
        return soldiers
    }

    static movingLords(){
        let lords = [];
        document.querySelectorAll('.moving-army>.lord-forces>.lord:not(.splited-to-stay)').forEach(el=>{
            lords.push(el.id)
        })
        return lords;
    }

}
