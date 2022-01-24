export class ArmyManager{

    static removeLeftSoldiers(type){
        let armyToRemoveFrom = Array.from(document.querySelectorAll('.moving-army>.army-forces>.sergeant-container>*, .moving-army>.army-forces>.knight-container>*, .moving-army>.lord-forces>*'));
        armyToRemoveFrom.splice(armyToRemoveFrom.findIndex(el=>el.className.split(' ')[0] === type || el.id === type), 1);
        armyToRemoveFrom.forEach(el=>{
            el.remove();
        })
    }

}
