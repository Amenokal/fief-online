export class ArmyManager{

    static removeMovingSoldiers(type){
        let armyToRemoveFrom = Array.from(document.querySelectorAll('.moving-army>.army-forces>.sergeant-container>*, .moving-army>.army-forces>.knight-container>*, .moving-army>.lord-forces>*'));
        armyToRemoveFrom.splice(armyToRemoveFrom.findIndex(el=>el.className.split(' ')[0] === type || el.id === type), 1);
        armyToRemoveFrom.forEach(el=>{
            el.remove();
        })
    }

    static removeMovingArmy(army){
        document.querySelectorAll('.moving-army>.army-forces>.sergeant-container>.sergeant:not(.splited-to-stay), .moving-army>.army-forces>.knight-container>.knight:not(.splited-to-stay), .moving-army>.lord-forces>.lord:not(.splited-to-stay)')
        .forEach(el=>{
            el.remove();
        })
    }

    static movingArmy(){
        let soldiers = [];
        document.querySelectorAll('.moving-army>.army-forces>.sergeant-container>.sergeant:not(.splited-to-stay), .moving-army>.army-forces>.knight-container>.knight:not(.splited-to-stay)').forEach(el=>{
            soldiers.push(el.className.split(' ')[0]);
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
