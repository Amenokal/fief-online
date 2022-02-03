import { GameElements } from "./GameElements";

export class Builder {

    static newCastle(villageName){
        let target = document.querySelector(`#${villageName}>.buildings`);
        target.innerHTML += GameElements.castle;
    }

}
