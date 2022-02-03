export class GameElements {

    static lordCardRecto(name, src){
        return `<span
            id=${name}
            class='card'
            style='background-image: url(${src})'
        ></span>`
    };

    static castle = '<span class="chateau"></span>';
    static city = '<span class="cite"></span>';
    static mill = '<span class="moulin"></span>';

}
