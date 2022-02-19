
export class GameElements {

    static lordCardRecto(name){
        return `<span
            class='card ${name}-card'
        ></span>`
    };

    static castle = '<span class="chateau"></span>';
    static city = '<span class="cite"></span>';
    static mill = '<span class="moulin"></span>';

    static localPlayer = {
        color(){ return document.querySelector('.game-view').className.split(' ')[1].split('-')[0] },
        order(){ return document.querySelector('.player-info-wrapper.'+this.color()+'-bordered').id.split('-')[1] },
        familyName(){ return document.querySelector('.player-info-wrapper.'+this.color()+'-bordered>.player-name').innerText }
    }

}
